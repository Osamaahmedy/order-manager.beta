<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class OrdersPerMonthChart extends ChartWidget
{
    use InteractsWithPageFilters;

    // العنوان بالعربي
    protected static ?string $heading = 'إجمالي الطلبات شهرياً';

    protected int|string|array $columnSpan = 'full';

    protected static ?string $maxHeight = '420px';

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
                    'label' => 'الطلبات',
                    'data' => $values,
                    'fill' => 'start',
                    'tension' => 0.4, // انسيابية عالية للخط
                    'borderWidth' => 4,
                    'borderColor' => '#6366f1', // Indigo 500
                    'backgroundColor' => 'rgba(99, 102, 241, 0.1)', // تظليل بنفسجي خفيف جداً
                    'pointRadius' => 4,
                    'pointBackgroundColor' => '#ffffff',
                    'pointBorderColor' => '#6366f1',
                    'pointBorderWidth' => 2,
                    'pointHoverRadius' => 7,
                    'pointHoverBackgroundColor' => '#6366f1',
                    'pointHoverBorderColor' => '#ffffff',
                    'pointHoverBorderWidth' => 3,
                ],
            ],
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
                'legend' => ['display' => false],
                'tooltip' => [
                    'enabled' => true,
                    'backgroundColor' => '#1e1b4b', // لون Indigo داكن جداً للـ Tooltip
                    'padding' => 12,
                    'borderRadius' => 12,
                    'titleAlign' => 'right',
                    'bodyAlign' => 'right',
                    'displayColors' => true,
                    'borderColor' => 'rgba(99, 102, 241, 0.5)',
                    'borderWidth' => 1,
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => ['display' => false],
                    'ticks' => [
                        'color' => '#94a3b8',
                        'font' => ['size' => 12, 'weight' => '600'],
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(148, 163, 184, 0.1)',
                        'borderDash' => [4, 4], // خطوط شبكة منقطة
                        'drawBorder' => false,
                    ],
                    'ticks' => [
                        'precision' => 0,
                        'color' => '#94a3b8',
                        'padding' => 10,
                    ],
                ],
            ],
            'animation' => [
                'duration' => 1500,
                'easing' => 'easeOutQuart',
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

            $labels[] = $m->translatedFormat('F'); // اسم الشهر بالعربي (يناير، فبراير...)
            $values[] = (int) ($rows[$key] ?? 0);
        }

        return [$labels, $values];
    }

    // تنسيق الحاوية الخارجية (بدون ظل أسود ومع حواف دائرية فخمة)
    protected function getExtraAttributes(): array
    {
        return [
            'class' => 'rounded-[2rem] shadow-sm border-0 bg-white dark:bg-gray-900 ring-1 ring-gray-100 dark:ring-gray-800 transition-all hover:ring-indigo-500/50',
        ];
    }
}
