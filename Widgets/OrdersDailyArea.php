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
        $demo = (bool) env('DEMO_MODE', false);

        // =========================
        // ✅ وضع الديمو (بيانات وهمية)
        // =========================
        if ($demo) {
            $days = 14;

            $labels = [];
            for ($i = 0; $i < $days; $i++) {
                $labels[] = now()->subDays(($days - 1) - $i)->format('M d');
            }

            // شكل بيانات “طبيعي”: موجة + ضوضاء بسيطة + ميل خفيف
            $values = $this->demoDailySeries(days: $days, base: 55, variance: 22, trend: 'up');

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
                'labels' => $labels,
            ];
        }

        // =========================
        // ✅ وضع الإنتاج (داتا حقيقية)
        // =========================
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

            // ✅ Area gradient (نفس كودك)
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
                            g.addColorStop(1, 'rgba(245,158,11,0.02)';
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

            $labels[] = $day->format('M d'); // مثال: Jan 15
            $values[] = (int) ($rows[$key] ?? 0);
        }

        return [$labels, $values];
    }

    /**
     * ✅ داتا وهمية يومية “شكلها طبيعي”: موجة + ضوضاء + ميل بسيط
     */
    private function demoDailySeries(int $days = 14, int $base = 50, int $variance = 20, string $trend = 'steady'): array
    {
        $out = [];

        $trendStep = match ($trend) {
            'up' => 1,
            'down' => -1,
            default => 0,
        };

        for ($i = 0; $i < $days; $i++) {
            // موجة بسيطة لذروة وسط الفترة
            $wave = (int) round(8 * sin(($i / max(1, $days - 1)) * 3.14159 * 2));

            // ضوضاء خفيفة
            $noise = random_int(-$variance, $variance);

            $v = $base + $wave + $trendStep * $i + (int) round($noise / 3);

            if ($v < 0) $v = 0;

            $out[] = $v;
        }

        return $out;
    }
}
