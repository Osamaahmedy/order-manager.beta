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
        $branchId = $this->filters['branch_id'] ?? null;

        $query = User::query();
        // لو Resident:
        // $query = \App\Models\Resident::query()->when($branchId, fn($q)=>$q->where('branch_id',$branchId));

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
}
