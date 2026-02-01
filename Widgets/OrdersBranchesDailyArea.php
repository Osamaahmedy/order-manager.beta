<?php

namespace App\Filament\Widgets;

use App\Models\Branch;
use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class OrdersBranchesDailyArea extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'Top branches (Last 14 days)';
    protected int|string|array $columnSpan = 1;
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

            // 3 فروع وهمية
            $fakeBranches = [
                ['id' => 1, 'name' => 'Aden - Main Branch'],
                ['id' => 2, 'name' => 'Sana’a - Al-Zubairi'],
                ['id' => 3, 'name' => 'Taiz - Jamal St'],
            ];

            // بيانات يومية "شكلها طبيعي": موجة + ضوضاء بسيطة
            $datasets = [];

            // كل فرع له نمط مختلف
            $patterns = [
                ['base' => 35, 'variance' => 18, 'trend' => 'up'],
                ['base' => 28, 'variance' => 15, 'trend' => 'steady'],
                ['base' => 18, 'variance' => 12, 'trend' => 'up'],
            ];

            foreach ($fakeBranches as $i => $b) {
                $values = $this->demoDailySeries(
                    days: $days,
                    base: $patterns[$i]['base'],
                    variance: $patterns[$i]['variance'],
                    trend: $patterns[$i]['trend'],
                );

                $datasets[] = [
                    'label' => $b['name'],
                    'data' => $values,
                    'fill' => false,
                    'tension' => 0.4,
                    'borderWidth' => 2,
                    'pointRadius' => 0,
                    'pointHoverRadius' => 6,
                    'pointHitRadius' => 20,
                ];
            }

            return [
                'datasets' => $datasets,
                'labels' => $labels,
            ];
        }

        // =========================
        // ✅ وضع الإنتاج (داتا حقيقية)
        // =========================
        $days = 14;
        $start = now()->subDays($days - 1)->startOfDay();

        // ✅ أعلى 3 فروع في الفترة (لجراف نظيف)
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

        $datasets = [];
        foreach ($topBranchIds as $branchId) {
            $values = $this->countPerDay(
                Order::query()->where('branch_id', $branchId),
                $days
            )[1];

            $datasets[] = [
                'label' => $branchNames[$branchId] ?? "Branch #{$branchId}",
                'data' => $values,
                'fill' => false,
                'tension' => 0.4,
                'borderWidth' => 2,
                'pointRadius' => 0,
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
                'legend' => ['position' => 'bottom'],
                'tooltip' => [
                    'enabled' => true,
                    'mode' => 'index',
                    'intersect' => false,
                    'padding' => 12,
                ],
            ],
            'interaction' => ['mode' => 'index', 'intersect' => false],
            'hover' => ['mode' => 'index', 'intersect' => false],
            'scales' => [
                'x' => ['grid' => ['display' => false]],
                'y' => ['beginAtZero' => true, 'ticks' => ['precision' => 0]],
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

    /**
     * ✅ داتا وهمية يومية "شكلها طبيعي": موجة + ضوضاء + ميل بسيط
     */
    private function demoDailySeries(int $days = 14, int $base = 25, int $variance = 12, string $trend = 'steady'): array
    {
        $out = [];
        $value = $base;

        $trendStep = match ($trend) {
            'up' => 1,
            'down' => -1,
            default => 0,
        };

        for ($i = 0; $i < $days; $i++) {
            // موجة بسيطة (ذروة منتصف الأسبوع مثلاً)
            $wave = (int) round(6 * sin(($i / max(1, $days - 1)) * 3.14159 * 2));

            // ضوضاء خفيفة
            $noise = random_int(-$variance, $variance);

            $value = $base + $wave + $trendStep * $i + (int) round($noise / 3);

            if ($value < 0) $value = 0;

            $out[] = $value;
        }

        return $out;
    }
}
