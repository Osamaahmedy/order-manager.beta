<?php

namespace App\Filament\Widgets;

use App\Models\User;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class CustomersGrowthChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'نمو قاعدة العملاء';
    protected static ?string $description = 'تحليل تطور عدد العملاء ومعدل النمو خلال آخر 12 شهر.';
    protected int|string|array $columnSpan = 'full';
    protected static ?string $maxHeight = '460px'; // ⬅️ تكبير الارتفاع

    protected function getData(): array
    {
        [$labels, $cumulative, $monthly, $growth] = $this->usersStats(12);

        return [
            'datasets' => [
                // إجمالي العملاء
                [
                    'label' => 'إجمالي العملاء',
                    'data' => $cumulative,
                    'type' => 'line',
                    'borderColor' => '#6366f1',
                    'borderWidth' => 3.5,
                    'tension' => 0.45,
                    'pointRadius' => 2,
                    'pointBackgroundColor' => '#6366f1',
                    'fill' => true,
                    'backgroundColor' => 'rgba(99,102,241,0.15)',
                    'yAxisID' => 'y',
                ],

                // العملاء الجدد
                [
                    'label' => 'عملاء جدد',
                    'data' => $monthly,
                    'type' => 'bar',
                    'backgroundColor' => 'rgba(16,185,129,0.35)',
                    'borderRadius' => 8,
                    'yAxisID' => 'y',
                ],

                // معدل النمو %
                [
                    'label' => 'معدل النمو (%)',
                    'data' => $growth,
                    'type' => 'line',
                    'borderColor' => '#f59e0b',
                    'borderWidth' => 2.5,
                    'borderDash' => [4, 6],
                    'tension' => 0.35,
                    'pointRadius' => 3,
                    'pointBackgroundColor' => '#f59e0b',
                    'yAxisID' => 'y1',
                ],

                // خط متوسط النمو (Moving Average)
                [
                    'label' => 'متوسط النمو',
                    'data' => $this->movingAverage($growth, 3),
                    'type' => 'line',
                    'borderColor' => '#ef4444',
                    'borderWidth' => 2,
                    'tension' => 0.4,
                    'pointRadius' => 0,
                    'yAxisID' => 'y1',
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
                'legend' => [
                    'position' => 'top',
                    'labels' => [
                        'color' => '#475569',
                        'font' => [
                            'size' => 13,
                            'weight' => '600',
                        ],
                    ],
                ],
                'tooltip' => [
                    'backgroundColor' => 'rgba(15,23,42,0.95)',
                    'padding' => 14,
                    'borderRadius' => 12,
                ],
            ],

            'scales' => [
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(148,163,184,0.08)',
                        'drawBorder' => false,
                    ],
                    'ticks' => [
                        'color' => '#475569',
                    ],
                ],
                'y1' => [
                    'beginAtZero' => true,
                    'position' => 'right',
                    'grid' => [
                        'drawOnChartArea' => false,
                    ],
                    'ticks' => [
                        'callback' => "function(value){return value + '%'}",
                        'color' => '#475569',
                    ],
                ],
                'x' => [
                    'grid' => ['display' => false],
                    'ticks' => [
                        'color' => '#475569',
                    ],
                ],
            ],

            'animation' => [
                'duration' => 1700,
                'easing' => 'easeOutQuart',
            ],
        ];
    }

    private function usersStats(int $months = 12): array
    {
        $start = now()->subMonths($months - 1)->startOfMonth();

        $rows = User::query()
            ->selectRaw("DATE_FORMAT(created_at, '%Y-%m') as m, COUNT(*) as c")
            ->where('created_at', '>=', $start)
            ->groupBy('m')
            ->orderBy('m')
            ->pluck('c', 'm')
            ->toArray();

        $labels = [];
        $cumulative = [];
        $monthly = [];
        $growth = [];
        $prev = null;
        $running = 0;

        for ($i = 0; $i < $months; $i++) {
            $m = now()->subMonths(($months - 1) - $i);
            $key = $m->format('Y-m');

            $count = (int) ($rows[$key] ?? 0);
            $running += $count;

            $labels[] = $m->format('M');
            $monthly[] = $count;
            $cumulative[] = $running;

            if ($prev === null || $prev == 0) {
                $growth[] = 0;
            } else {
                $growth[] = round(($count - $prev) / $prev * 100, 1);
            }

            $prev = $count;
        }

        return [$labels, $cumulative, $monthly, $growth];
    }

    private function movingAverage(array $data, int $period): array
    {
        $result = [];

        foreach ($data as $i => $value) {
            if ($i < $period - 1) {
                $result[] = null;
                continue;
            }

            $slice = array_slice($data, $i - $period + 1, $period);
            $result[] = round(array_sum($slice) / $period, 1);
        }

        return $result;
    }

    protected function getExtraAttributes(): array
    {
        return [
            'class' => 'rounded-3xl bg-white dark:bg-gray-900 border border-gray-100 dark:border-gray-800 shadow-sm hover:shadow-lg transition-all p-5',
        ];
    }
}
