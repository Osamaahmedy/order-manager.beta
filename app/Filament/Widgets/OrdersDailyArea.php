<?php

namespace App\Filament\Widgets;

use App\Models\Order;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class OrdersDailyArea extends ChartWidget
{
    use InteractsWithPageFilters;

    // العنوان بالعربي
    protected static ?string $heading = 'إحصائيات الطلبات (آخر 14 يوم)';
    protected int|string|array $columnSpan = 1;
    protected static ?string $maxHeight = '400px';

    protected function getData(): array
    {
        $branchId = $this->filters['branch_id'] ?? null;

        [$labels, $values] = $this->countPerDay(
            Order::query()->when($branchId, fn($q) => $q->where('branch_id', $branchId)),
            14
        );

        return [
            'datasets' => [
                [
                    'label' => 'الطلبات',
                    'data' => $values,
                    'fill' => 'start',
                    'tension' => 0.5, // لزيادة انسيابية الخط (حركات!)
                    'borderColor' => '#0ea5e9', // لون أزرق سماوي حيوي (Sky 500)
                    'borderWidth' => 4,
                    'pointBackgroundColor' => '#ffffff', // نقطة بيضاء تبرز فوق الخط
                    'pointBorderColor' => '#0ea5e9',
                    'pointBorderWidth' => 2,
                    'pointRadius' => 4,
                    'pointHoverRadius' => 8, // تكبر النقطة عند التمرير عليها
                    'pointHoverBackgroundColor' => '#0ea5e9',
                    'pointHoverBorderColor' => '#ffffff',
                    'pointHoverBorderWidth' => 3,
                    'backgroundColor' => 'rgba(14, 165, 233, 0.15)', // تظليل أزرق شفاف نابض
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
                    'backgroundColor' => '#0f172a',
                    'titleAlign' => 'right', // متناسب مع العربي
                    'bodyAlign' => 'right',
                    'padding' => 12,
                    'displayColors' => true,
                    'borderColor' => '#0ea5e9',
                    'borderWidth' => 1,
                ],
            ],
            'scales' => [
                'x' => [
                    'grid' => ['display' => false],
                    'ticks' => [
                        'font' => ['size' => 11, 'weight' => '500'],
                        'color' => '#94a3b8',
                    ],
                ],
                'y' => [
                    'beginAtZero' => true,
                    'grid' => [
                        'color' => 'rgba(226, 232, 240, 0.3)',
                        'borderDash' => [5, 5], // خطوط شبكة متقطعة لشكل أكثر حداثة
                    ],
                    'ticks' => [
                        'precision' => 0,
                        'color' => '#94a3b8',
                    ],
                ],
            ],
            'animation' => [
                'duration' => 2000, // حركة دخول بطيئة واحترافية
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
            $labels[] = $day->translatedFormat('d M'); // تنسيق تاريخ يدعم العربية
            $values[] = (int) ($rows[$key] ?? 0);
        }

        return [$labels, $values];
    }
}
