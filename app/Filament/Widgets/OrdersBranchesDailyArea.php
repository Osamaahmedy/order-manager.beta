<?php

namespace App\Filament\Widgets;

use App\Models\Branch;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class OrdersBranchesDailyArea extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'أداء أفضل الفروع خلال آخر 14 يوم';
    protected int|string|array $columnSpan = 1;
    protected static ?string $maxHeight = '420px'; // تكبير الارتفاع

    protected function getData(): array
    {
        $days = 14;
        $start = now()->subDays($days - 1)->startOfDay();

        // أعلى 3 فروع
        $topBranchIds = Order::query()
            ->where('created_at', '>=', $start)
            ->selectRaw('branch_id, COUNT(*) as c')
            ->groupBy('branch_id')
            ->orderByDesc('c')
            ->limit(3)
            ->pluck('branch_id')
            ->toArray();

        $labels = [];
        for ($i = 0; $i < $days; $i++) {
            $labels[] = now()->subDays(($days - 1) - $i)->format('M d');
        }

        $branchNames = Branch::query()
            ->whereIn('id', $topBranchIds)
            ->pluck('name', 'id')
            ->toArray();

        // Palette ألوان احترافية
        $colors = [
            ['line' => '#6366f1', 'bg' => 'rgba(99,102,241,0.18)'], // Indigo
            ['line' => '#10b981', 'bg' => 'rgba(16,185,129,0.18)'], // Emerald
            ['line' => '#f59e0b', 'bg' => 'rgba(245,158,11,0.18)'], // Amber
        ];

        $datasets = [];
        foreach ($topBranchIds as $index => $branchId) {
            $values = $this->countPerDay(
                Order::query()->where('branch_id', $branchId),
                $days
            )[1];

            $color = $colors[$index] ?? ['line' => '#64748b', 'bg' => 'rgba(100,116,139,0.15)'];

            $datasets[] = [
                'label' => $branchNames[$branchId] ?? "Branch #{$branchId}",
                'data' => $values,
                'type' => 'line',
                'fill' => true, // Area chart
                'tension' => 0.45,
                'borderColor' => $color['line'],
                'backgroundColor' => $color['bg'],
                'borderWidth' => 3,
                'pointRadius' => 2,
                'pointBackgroundColor' => $color['line'],
                'pointHoverRadius' => 6,
                'pointHitRadius' => 20,
            ];
        }

        return [
            'datasets' => $datasets,
            'labels' => $labels,
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
                'legend' => [
                    'position' => 'top',
                    'labels' => [
                        'usePointStyle' => true,
                        'color' => '#64748b',
                        'font' => [
                            'size' => 12,
                            'weight' => '600',
                        ],
                    ],
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                    'backgroundColor' => 'rgba(15,23,42,0.95)',
                    'padding' => 12,
                    'borderRadius' => 10,
                ],
            ],

            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],

            'scales' => [
                'x' => [
                    'grid' => ['display' => false],
                    'ticks' => [
                        'color' => '#64748b',
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(148,163,184,0.08)',
                        'drawBorder' => false,
                    ],
                    'ticks' => [
                        'precision' => 0,
                        'color' => '#64748b',
                    ],
                ],
            ],

            'animation' => [
                'duration' => 1600,
                'easing' => 'easeOutQuart',
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

            $labels[] = $day->format('M d');
            $values[] = (int) ($rows[$key] ?? 0);
        }

        return [$labels, $values];
    }

    protected function getExtraAttributes(): array
    {
        return [
            'class' => 'rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-md transition-all p-4',
        ];
    }
}
