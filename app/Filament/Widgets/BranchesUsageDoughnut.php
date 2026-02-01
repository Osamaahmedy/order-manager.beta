<?php

namespace App\Filament\Widgets;

use App\Models\Branch;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class BranchesUsageDoughnut extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'أداء الفروع الرئيسية';
    protected static ?string $description = 'تحليل حيوي لتوزيع الطلبات والنسب المئوية لكل فرع.';
    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $rows = Order::query()
            ->selectRaw('branch_id, COUNT(*) as c')
            ->groupBy('branch_id')
            ->orderByDesc('c')
            ->limit(5) // تقليل العدد لـ 5 يجعل التصميم أنظف وأوسع
            ->pluck('c', 'branch_id')
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
                    'data' => $values,
                    'backgroundColor' => [
                        '#6366f1', // Indigo
                        '#10b981', // Emerald
                        '#f59e0b', // Amber
                        '#3b82f6', // Blue
                        '#f43f5e', // Rose
                    ],
                    'hoverOffset' => 25,
                    'borderRadius' => 20, // زيادة الانحناء لجعلها "Organic"
                    'spacing' => 8,      // مسافة أكبر بين القطع لزيادة الفخامة
                    'borderWidth' => 0,  // إلغاء الحدود تماماً لتركيز الرؤية على اللون
                ],
            ],
            'labels' => $labels,
        ];
    }

    protected function getType(): string
    {
        return 'doughnut';
    }

    protected function getOptions(): array
    {
        return [
            'cutout' => '50%', // زيادة عرض "لحم" الحلقة كما طلبت (سماكة أكبر)
            'radius' => '90%',
            'animation' => [
                'animateRotate' => true,
                'animateScale' => true,
                'duration' => 2500, // أنيميشن طويل وناعم
                'easing' => 'easeOutElastic', // تأثير مطاطي حيوي جداً عند الظهور
            ],
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                        'padding' => 30,
                        'font' => ['size' => 14, 'weight' => '600'],
                        'color' => '#94a3b8',
                    ],
                ],
                'tooltip' => [
                    'cornerRadius' => 12,
                    'padding' => 15,
                    'backgroundColor' => 'rgba(15, 23, 42, 0.9)', // Dark Slate
                ],
            ],
        ];
    }

    protected function getExtraAttributes(): array
    {
        return [
            // إضافة تأثير زجاجي (Glassmorphism) بسيط ودعم الدارك مود
            'class' => 'rounded-3xl shadow-xl border-0 bg-white/50 dark:bg-gray-900/50 backdrop-blur-md transition-all duration-500 hover:shadow-2xl hover:-translate-y-1',
        ];
    }
}
