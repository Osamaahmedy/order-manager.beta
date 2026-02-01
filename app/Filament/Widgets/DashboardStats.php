<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use App\Models\User;
use Filament\Widgets\StatsOverviewWidget;
use Filament\Widgets\StatsOverviewWidget\Stat;

class DashboardStats extends StatsOverviewWidget
{
    protected function getStats(): array
    {
        // حسابات الطلبات
        $ordersThisMonth = Order::whereMonth('created_at', now()->month)->count();
        $ordersLastMonth = Order::whereMonth('created_at', now()->subMonth()->month)->count();
        $ordersChange = $this->calculateChange($ordersThisMonth, $ordersLastMonth);

        // حسابات العملاء
        $customersThisMonth = User::whereMonth('created_at', now()->month)->count();
        $customersLastMonth = User::whereMonth('created_at', now()->subMonth()->month)->count();
        $customersChange = $this->calculateChange($customersThisMonth, $customersLastMonth);

        return [
            // بطاقة الطلبات - بنفسجي نيون
            Stat::make('الطلبات (هذا الشهر)', number_format($ordersThisMonth))
                ->description($ordersChange >= 0 ? "↗ {$ordersChange}% بونص أداء" : "↘ {$ordersChange}% تراجع")
                ->descriptionIcon($ordersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($ordersChange >= 0 ? 'success' : 'danger')
                ->chart($this->countPerDay(Order::class))
                ->extraAttributes([
                    'style' => '
                        background: linear-gradient(135deg, rgba(99, 102, 241, 0.15), rgba(168, 85, 247, 0.15));
                        border: 1px solid rgba(99, 102, 241, 0.2);
                        border-radius: 24px;
                        transition: all 0.3s ease;
                    ',
                    'onmouseover' => 'this.style.transform="translateY(-5px)"; this.style.boxShadow="0 10px 20px rgba(99, 102, 241, 0.2)"',
                    'onmouseout' => 'this.style.transform="translateY(0)"; this.style.boxShadow="none"',
                ]),

            // بطاقة العملاء - أخضر زمردي
            Stat::make('العملاء الجدد', number_format($customersThisMonth))
                ->description($customersChange >= 0 ? "↗ {$customersChange}% نمو حيوي" : "↘ {$customersChange}% انخفاض")
                ->descriptionIcon($customersChange >= 0 ? 'heroicon-m-arrow-trending-up' : 'heroicon-m-arrow-trending-down')
                ->color($customersChange >= 0 ? 'success' : 'danger')
                ->chart($this->countPerDay(User::class))
                ->extraAttributes([
                    'style' => '
                        background: linear-gradient(135deg, rgba(16, 185, 129, 0.15), rgba(5, 150, 105, 0.15));
                        border: 1px solid rgba(16, 185, 129, 0.2);
                        border-radius: 24px;
                        transition: all 0.3s ease;
                    ',
                    'onmouseover' => 'this.style.transform="translateY(-5px)"; this.style.boxShadow="0 10px 20px rgba(16, 185, 129, 0.2)"',
                    'onmouseout' => 'this.style.transform="translateY(0)"; this.style.boxShadow="none"',
                ]),

            // بطاقة النشاط - برتقالي ذهبي
            Stat::make('نشاط النظام', 'مستقر')
                ->description('تفاعل لحظي ممتاز')
                ->descriptionIcon('heroicon-m-bolt')
                ->color('warning')
                ->chart([7, 4, 8, 5, 9, 6, 10])
                ->extraAttributes([
                    'style' => '
                        background: linear-gradient(135deg, rgba(245, 158, 11, 0.15), rgba(234, 88, 12, 0.15));
                        border: 1px solid rgba(245, 158, 11, 0.2);
                        border-radius: 24px;
                        transition: all 0.3s ease;
                    ',
                    'onmouseover' => 'this.style.transform="translateY(-5px)"; this.style.boxShadow="0 10px 20px rgba(245, 158, 11, 0.2)"',
                    'onmouseout' => 'this.style.transform="translateY(0)"; this.style.boxShadow="none"',
                ]),
        ];
    }

    private function calculateChange($current, $previous): float|int
    {
        if ($previous == 0) return $current > 0 ? 100 : 0;
        return round((($current - $previous) / $previous) * 100, 1);
    }

    private function countPerDay(string $modelClass): array
    {
        $start = now()->subDays(11)->startOfDay();
        $rows = $modelClass::query()
            ->selectRaw("DATE(created_at) as d, COUNT(*) as c")
            ->where('created_at', '>=', $start)
            ->groupBy('d')
            ->pluck('c', 'd')
            ->toArray();

        $out = [];
        for ($i = 0; $i < 12; $i++) {
            $day = now()->subDays(11 - $i)->toDateString();
            $out[] = (int) ($rows[$day] ?? 0);
        }
        return $out;
    }
}
