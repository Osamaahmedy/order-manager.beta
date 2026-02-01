<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
// إذا عندك موديل Resident استخدمه بدل User
// use App\Models\Resident;

use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        $demo = (bool) env('DEMO_MODE', false);

        // =========================
        // ✅ وضع الديمو (بيانات وهمية)
        // =========================
        if ($demo) {
            // أرقام “منطقية” للعرض
            $ordersThisMonth     = 1240;
            $ordersLastMonth     = 980;
            $customersThisMonth  = 210;
            $customersLastMonth  = 165;
            $newOrders30         = 860;

            $ordersChange = $ordersLastMonth > 0
                ? round((($ordersThisMonth - $ordersLastMonth) / $ordersLastMonth) * 100, 1)
                : null;

            $customersChange = $customersLastMonth > 0
                ? round((($customersThisMonth - $customersLastMonth) / $customersLastMonth) * 100, 1)
                : null;

            // Sparklines وهمية (آخر 12 يوم)
            $ordersSpark     = $this->demoSparkline(12, base: 60, variance: 25, trend: 'up');
            $customersSpark  = $this->demoSparkline(12, base: 10, variance: 6, trend: 'up');
            $newOrdersSpark  = $this->demoSparkline(12, base: 40, variance: 20, trend: 'steady');

            return [
                $this->statWithTrend(
                    title: 'Orders (This month)',
                    value: number_format($ordersThisMonth),
                    change: $ordersChange,
                    chart: $ordersSpark
                ),

                $this->statWithTrend(
                    title: 'New customers (This month)',
                    value: number_format($customersThisMonth),
                    change: $customersChange,
                    chart: $customersSpark
                ),

                Stat::make('New orders (30 days)', number_format($newOrders30))
                    ->description('Last 30 days')
                    ->color('primary')
                    ->chart($newOrdersSpark),
            ];
        }

        // =========================
        // ✅ وضع الإنتاج (داتا حقيقية)
        // =========================

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

        // Sparkline data (آخر 12 يوم)
        $ordersSpark     = $this->countPerDay(Order::class, 12);
        $customersSpark  = $this->countPerDay(User::class, 12);
        $newOrdersSpark  = $this->countPerDay(Order::class, 12, column: 'created_at');

        return [
            $this->statWithTrend(
                title: 'Orders (This month)',
                value: number_format($ordersThisMonth),
                change: $ordersChange,
                chart: $ordersSpark
            ),

            $this->statWithTrend(
                title: 'New customers (This month)',
                value: number_format($customersThisMonth),
                change: $customersChange,
                chart: $customersSpark
            ),

            Stat::make('New orders (30 days)', number_format($newOrders30))
                ->description('Last 30 days')
                ->color('primary')
                ->chart($newOrdersSpark),
        ];
    }

    /**
     * ✅ يبني Stat مع وصف + أيقونة + لون بناءً على نسبة التغير
     */
    private function statWithTrend(string $title, string $value, ?float $change, array $chart): Stat
    {
        if ($change === null) {
            return Stat::make($title, $value)
                ->description('No data last month')
                ->color('gray')
                ->chart($chart);
        }

        $isUp = $change >= 0;

        return Stat::make($title, $value)
            ->description($isUp ? "+{$change}%" : "{$change}%")
            ->descriptionIcon($isUp ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
            ->color($isUp ? 'success' : 'danger')
            ->chart($chart);
    }

    /**
     * ✅ يرجّع Array أرقام لسباركلاين (عدد سجلات لكل يوم)
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

    /**
     * ✅ داتا وهمية لسباركلاين بشكل جميل (Trend: up|down|steady)
     */
    private function demoSparkline(int $points = 12, int $base = 50, int $variance = 20, string $trend = 'steady'): array
    {
        $out = [];
        $value = $base;

        // نغيّر الميل حسب الترند
        $trendStep = match ($trend) {
            'up' => 2,
            'down' => -2,
            default => 0,
        };

        for ($i = 0; $i < $points; $i++) {
            // random_int بدل rand (أوثق)
            $noise = random_int(-$variance, $variance);

            // تعديل بسيط تدريجي عبر الوقت
            $value += $trendStep + (int) round($noise / 6);

            // منع السالب
            if ($value < 0) $value = 0;

            $out[] = $value;
        }

        return $out;
    }
}
