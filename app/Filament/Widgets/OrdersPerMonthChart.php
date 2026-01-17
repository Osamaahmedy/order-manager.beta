<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class OrdersPerMonthChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Orders per month';

    // ✅ Full width
    protected int|string|array $columnSpan = 'full';

    // ✅ ارتفاع أكبر
    protected static ?string $maxHeight = '360px';

    protected function getData(): array
    {
        $branchId = $this->filters['branch_id'] ?? null;

        [$labels, $values] = $this->countPerMonth(
            Order::query()->when($branchId, fn ($q) => $q->where('branch_id', $branchId)),
            12
        );

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $values,

                    // ✅ Area
                    'fill' => true,
                    'tension' => 0.4,

                    // ✅ خط أنعم
                    'borderWidth' => 2,
                    'pointRadius' => 0,
                    'pointHoverRadius' => 6,
                    'pointHitRadius' => 20,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    /**
     * ✅ خيارات احترافية + تفاعل Hover قوي + Gradient Area
     */
    protected function getOptions(): array
    {
        return [
            'maintainAspectRatio' => false,
            'responsive' => true,
            'plugins' => [
                'legend' => ['display' => false],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
                    'padding' => 12,
                    'displayColors' => false,
                ],
            ],

            // ✅ hover/interaction مثل الداشبورد الحديثة
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],

            // ✅ أنيميشن خفيف
            'animation' => [
                'duration' => 450,
            ],

            // ✅ محاور أنظف
            'scales' => [
                'x' => [
                    'grid' => ['display' => false],
                    'ticks' => [
                        'maxRotation' => 0,
                        'autoSkip' => true,
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'drawBorder' => false,
                    ],
                    'ticks' => [
                        'precision' => 0,
                    ],
                ],
            ],

            /**
             * ✅ Gradient fill (احترافي)
             * Chart.js scriptable backgroundColor
             */
            'datasets' => [
                'line' => [
                    'backgroundColor' => [
                        'type' => 'scriptable',
                        'fn' => "function(ctx){
                            const chart = ctx.chart;
                            const {ctx: c, chartArea} = chart;
                            if (!chartArea) return 'rgba(245, 158, 11, 0.15)'; // fallback
                            const g = c.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            g.addColorStop(0, 'rgba(245, 158, 11, 0.28)');
                            g.addColorStop(1, 'rgba(245, 158, 11, 0.02)');
                            return g;
                        }",
                    ],
                    'borderColor' => 'rgba(245, 158, 11, 1)',
                ],
            ],
        ];
    }

    private function countPerMonth($query, int $months = 12): array
    {
        $start = now()->subMonths($months - 1)->startOfMonth();

        $rows = (clone $query)
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as m, COUNT(*) as c")
            ->where('created_at', '>=', $start)
            ->groupBy('m')
            ->orderBy('m')
            ->pluck('c', 'm')
            ->toArray();

        $labels = [];
        $values = [];

        for ($i = 0; $i < $months; $i++) {
            $m = now()->subMonths(($months - 1) - $i);
            $key = $m->format('Y-m');

            $labels[] = $m->format('M');
            $values[] = (int) ($rows[$key] ?? 0);
        }

        return [$labels, $values];
    }
}
