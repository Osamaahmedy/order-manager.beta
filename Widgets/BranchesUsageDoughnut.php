<?php

namespace App\Filament\Widgets;

use App\Models\Branch;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class BranchesUsageDoughnut extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Top branches (Orders)';
    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        // ✅ شغّل الديمو من .env
        // DEMO_MODE=true
        $demo = (bool) env('DEMO_MODE', false);

        if ($demo) {
            // =========================
            // ✅ بيانات وهمية للعرض للعميل
            // =========================
            $labels = [
                'Aden - Main Branch',
                'Sana’a - Al-Zubairi',
                'Taiz - Jamal St',
                'Mukalla - Center',
                'Ibb - Downtown',
                'Hodeidah - Port',
            ];

            $values = [180, 140, 120, 95, 80, 65];

            return [
                'datasets' => [
                    [
                        'label' => 'Orders',
                        'data' => $values,
                        'hoverOffset' => 10,
                    ],
                ],
                'labels' => $labels,
            ];
        }

        // =========================
        // ✅ داتا حقيقية من الداتا بيس (نفس كودك)
        // =========================
        $branchId = $this->filters['branch_id'] ?? null;

        // لو فلترت بفرع، ما له معنى “Top branches”، فخليه يرجع نفس الفرع فقط
        // (أو تجاهل الفلتر هنا). أنا هنا بخليه “يتجاهل الفلتر” عشان يظل Top.
        $rows = Order::query()
            ->selectRaw('branch_id, COUNT(*) as c')
            ->groupBy('branch_id')
            ->orderByDesc('c')
            ->limit(6)
            ->pluck('c', 'branch_id')
            ->toArray();

        $names = Branch::query()
            ->whereIn('id', array_keys($rows))
            ->pluck('name', 'id')
            ->toArray();

        $labels = [];
        $values = [];

        foreach ($rows as $bid => $count) {
            $labels[] = $names[$bid] ?? "Branch #{$bid}";
            $values[] = (int) $count;
        }

        return [
            'datasets' => [
                [
                    'label' => 'Orders',
                    'data' => $values,
                    'hoverOffset' => 10, // ✅ Hover pop
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
            'cutout' => '68%',
            'plugins' => [
                'legend' => [
                    'position' => 'bottom',
                    'labels' => [
                        'usePointStyle' => true,
                    ],
                ],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'nearest',
                    'intersect' => true,
                ],
            ],
        ];
    }
}
