<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class OrdersDailyArea extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Orders (Last 14 days)';

    // ✅ نصف المربع (يعني 2 في الصف)
    protected int|string|array $columnSpan = 1;

    // ✅ أكبر
    protected static ?string $maxHeight = '340px';

    protected function getData(): array
    {
        $branchId = $this->filters['branch_id'] ?? null;

        [$labels, $values] = $this->countPerDay(
            Order::query()->when($branchId, fn($q) => $q->where('branch_id', $branchId)),
            14
        );

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $values,
                    'fill' => true,
                    'tension' => 0.42,
                    'borderWidth' => 2,
                    'pointRadius' => 0,
                    'pointHoverRadius' => 7,
                    'pointHitRadius' => 22,
                ],
            ],
            'labels' => $labels, // ✅ تواريخ الأيام
        ];
    }

    protected function getType(): string
    {
        return 'line';
    }

    protected function getOptions(): array
    {
        return [
            'responsive' => true,
            'maintainAspectRatio' => false,

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
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'hover' => [
                'mode' => 'index',
                'intersect' => false,
            ],
            'scales' => [
                'x' => [
                    'grid' => ['display' => false],
                    'ticks' => [
                        'autoSkip' => true,
                        'maxRotation' => 0,
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'ticks' => ['precision' => 0],
                ],
            ],

            // ✅ Area gradient
            'datasets' => [
                'line' => [
                    'borderColor' => 'rgba(245, 158, 11, 1)',
                    'backgroundColor' => [
                        'type' => 'scriptable',
                        'fn' => "function(context){
                            const chart = context.chart;
                            const {ctx, chartArea} = chart;
                            if (!chartArea) return 'rgba(245,158,11,0.18)';
                            const g = ctx.createLinearGradient(0, chartArea.top, 0, chartArea.bottom);
                            g.addColorStop(0, 'rgba(245,158,11,0.30)');
                            g.addColorStop(1, 'rgba(245,158,11,0.02)');
                            return g;
                        }",
                    ],
                ],
            ],
        ];
    }

    private function countPerDay($query, int $days = 14): array
    {
        $start = now()->subDays($days - 1)->startOfDay();

        $rows = (clone $query)
            ->selectRaw("DATE(created_at) as d, COUNT(*) as c")
            ->where('created_at', '>=', $start)
            ->groupBy('d')
            ->orderBy('d')
            ->pluck('c', 'd')
            ->toArray();

        $labels = [];
        $values = [];

        for ($i = 0; $i < $days; $i++) {
            $day = now()->subDays(($days - 1) - $i);
            $key = $day->toDateString();

            // ✅ شكل التاريخ في محور X
            $labels[] = $day->format('M d'); // مثال: Jan 15
            $values[] = (int) ($rows[$key] ?? 0);
        }

        return [$labels, $values];
    }
}
