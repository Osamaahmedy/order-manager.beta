<?php

namespace App\Filament\Widgets;

use App\Models\User; // لو Resident: بدّلها
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class CustomersGrowthChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Total customers';
    protected int|string|array $columnSpan = 1;

    protected function getData(): array
    {
        $demo = (bool) env('DEMO_MODE', false);

        // =========================
        // ✅ وضع الديمو (بيانات وهمية)
        // =========================
        if ($demo) {
            [$labels, $values] = $this->demoCumulativePerMonth(12);

            return [
                'datasets' => [
                    [
                        'label' => 'Customers',
                        'data' => $values,
                        'fill' => true,
                        'tension' => 0.35,
                        'borderWidth' => 2,
                        'pointRadius' => 0,
                        'pointHoverRadius' => 5,
                    ],
                ],
                'labels' => $labels,
            ];
        }

        // =========================
        // ✅ وضع الإنتاج (داتا حقيقية)
        // =========================
        $branchId = $this->filters['branch_id'] ?? null;

        $query = User::query();

        // لو Resident:
        // $query = \App\Models\Resident::query()
        //     ->when($branchId, fn($q) => $q->where('branch_id', $branchId));

        // لو User وما له branch، خليه بدون فلترة
        // (إذا عندك user مرتبط بفرع، قلّي العلاقة وأعدل)

        [$labels, $values] = $this->cumulativePerMonth($query, 12);

        return [
            'datasets' => [
                [
                    'label' => 'Customers',
                    'data' => $values,
                    'fill' => true,
                    'tension' => 0.35,
                    'borderWidth' => 2,
                    'pointRadius' => 0,
                    'pointHoverRadius' => 5,
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
            'plugins' => [
                'legend' => ['display' => false],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
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
                'y' => ['beginAtZero' => true],
            ],
        ];
    }

    private function cumulativePerMonth($query, int $months = 12): array
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
        $running = 0;

        for ($i = 0; $i < $months; $i++) {
            $m = now()->subMonths(($months - 1) - $i);
            $key = $m->format('Y-m');

            $running += (int) ($rows[$key] ?? 0);

            $labels[] = $m->format('M');
            $values[] = $running;
        }

        return [$labels, $values];
    }

    /**
     * ✅ داتا وهمية: نمو تراكمي طبيعي (كل شهر يزيد)
     */
    private function demoCumulativePerMonth(int $months = 12): array
    {
        $labels = [];
        $values = [];

        // بداية وهمية (مثلاً: 900 عميل)
        $running = 900;

        // زيادات شهرية وهمية (تقدر تغيرها)
        $increments = [35, 42, 28, 50, 46, 58, 40, 33, 55, 49, 37, 60];

        for ($i = 0; $i < $months; $i++) {
            $m = now()->subMonths(($months - 1) - $i);
            $labels[] = $m->format('M');

            $running += $increments[$i] ?? 40;
            $values[] = $running;
        }

        return [$labels, $values];
    }
}
