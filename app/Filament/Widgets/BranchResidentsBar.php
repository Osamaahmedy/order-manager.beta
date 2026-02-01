<?php

namespace App\Filament\Widgets;

use App\Models\Branch;
use App\Models\Resident; // أو User أو أي موديل عندك للمقيمين
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class BranchResidentsBar extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'المقيمين حسب الفروع';
    protected static ?string $description = 'عرض أكثر الفروع من حيث عدد المقيمين';
    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        // افترض عندك جدول residents أو users فيه branch_id
        // غير اسم الموديل حسب نظامك
        $rows = Resident::query()
            ->selectRaw('branch_id, COUNT(*) as residents_count')
            ->groupBy('branch_id')
            ->orderByDesc('residents_count')
            ->limit(5) // أفضل 5 فروع
            ->pluck('residents_count', 'branch_id')
            ->toArray();

        $names = Branch::query()
            ->whereIn('id', array_keys($rows))
            ->pluck('name', 'id')
            ->toArray();

        $labels = [];
        $values = [];
        foreach ($rows as $bid => $count) {
            $labels[] = $names[$bid] ?? "فرع #{$bid}";
            $values[] = (int) $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'عدد المقيمين',
                    'data' => $values,
                    'backgroundColor' => [
                        'rgba(99, 102, 241, 0.8)',   // Indigo
                        'rgba(16, 185, 129, 0.8)',   // Emerald
                        'rgba(245, 158, 11, 0.8)',   // Amber
                        'rgba(59, 130, 246, 0.8)',   // Blue
                        'rgba(244, 63, 94, 0.8)',    // Rose
                    ],
                    'borderColor' => [
                        '#6366f1',
                        '#10b981',
                        '#f59e0b',
                        '#3b82f6',
                        '#f43f5e',
                    ],
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                    'borderSkipped' => false,
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'bar';
    }

    protected function getOptions(): array
{
    return [
        // احذف 'indexAxis' => 'y' عشان يكون عمودي
        'animation' => [
            'duration' => 2500,
            'easing' => 'easeOutElastic',
        ],
        'scales' => [
            'x' => [
                'ticks' => [
                    'font' => ['size' => 13, 'weight' => '600'],
                    'color' => '#475569',
                ],
                'grid' => [
                    'display' => false,
                ],
            ],
            'y' => [
                'beginAtZero' => true,
                'ticks' => [
                    'font' => ['size' => 12, 'weight' => '600'],
                    'color' => '#94a3b8',
                ],
                'grid' => [
                    'color' => 'rgba(148, 163, 184, 0.1)',
                ],
            ],
        ],
        'plugins' => [
            'legend' => [
                'display' => false,
            ],
            'tooltip' => [
                'cornerRadius' => 12,
                'padding' => 15,
                'backgroundColor' => 'rgba(15, 23, 42, 0.9)',
                'titleFont' => ['size' => 14, 'weight' => 'bold'],
                'bodyFont' => ['size' => 13],
            ],
        ],
    ];
}


    protected function getExtraAttributes(): array
    {
        return [
            'class' => 'rounded-3xl shadow-xl border-0 bg-white/50 dark:bg-gray-900/50 backdrop-blur-md transition-all duration-500 hover:shadow-2xl hover:-translate-y-1',
        ];
    }
}
