<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
// إذا عندك موديل Resident استخدمه بدل User
// use App\Models\Resident;

use Carbon\Carbon;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
protected function getStats(): array
{
// Revenue مثال: نجمع عدد الطلبات بدل مبلغ (لأن Order ما فيه price عندك)
$ordersThisMonth = Order::query()
->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
->count();

$ordersLastMonth = Order::query()
->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
->count();

$ordersChange = $ordersLastMonth > 0
? round((($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100, 1)
: null;

// Customers: اختر اللي عندك (User أو Resident)
$customersThisMonth = User::query()
->whereBetween('created_at', [now()->startOfMonth(), now()->endOfMonth()])
->count();

$customersLastMonth = User::query()
->whereBetween('created_at', [now()->subMonth()->startOfMonth(), now()->subMonth()->endOfMonth()])
->count();

$customersChange = $customersLastMonth > 0
? round((($customersThisMonth - $customersLastMonth) / $customersLastMonth) * 100, 1)
: null;

// New orders (آخر 30 يوم)
$newOrders30 = Order::query()
->where('created_at', '>=', now()->subDays(30))
->count();

// Sparkline data (آخر 12 يوم/أسبوع)
$ordersSpark = $this->countPerDay(Order::class, 12);

$customersSpark = $this->countPerDay(User::class, 12);

$newOrdersSpark = $this->countPerDay(Order::class, 12, column: 'created_at');

return [
Stat::make('Orders (This month)', number_format($ordersThisMonth))
->description($ordersChange === null ? 'No data last month' : ($ordersChange >= 0 ? "+{$ordersChange}%" : "{$ordersChange}%"))
->descriptionIcon($ordersChange !== null && $ordersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
->color($ordersChange !== null && $ordersChange < 0 ? 'danger' : 'success')
->chart($ordersSpark),

Stat::make('New customers (This month)', number_format($customersThisMonth))
->description($customersChange === null ? 'No data last month' : ($customersChange >= 0 ? "+{$customersChange}%" : "{$customersChange}%"))
->descriptionIcon($customersChange !== null && $customersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
->color($customersChange !== null && $customersChange < 0 ? 'danger' : 'success')
->chart($customersSpark),

Stat::make('New orders (30 days)', number_format($newOrders30))
->description('Last 30 days')
->color('primary')
->chart($newOrdersSpark),
];
}

/**
* يرجّع Array أرقام لسباركلاين (عدد سجلات لكل يوم)
*/
private function countPerDay(string $modelClass, int $days = 12, string $column = 'created_at'): array
{
$start = now()->subDays($days - 1)->startOfDay();

$rows = $modelClass::query()
->selectRaw("DATE($column) as d, COUNT(*) as c")
->where($column, '>=', $start)
->groupBy('d')
->orderBy('d')
->pluck('c', 'd')
->toArray();

$out = [];
for ($i = 0; $i < $days; $i++) {
$day = now()->subDays(($days - 1) - $i)->toDateString();
$out[] = (int) ($rows[$day] ?? 0);
}

return $out;
}
}
