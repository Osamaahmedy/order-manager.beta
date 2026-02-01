<?php

namespace App\Filament\Widgets;

use App\Models\Admin;
use App\Models\Branch;
use App\Models\Resident;
use App\Models\Order;
use Illuminate\Support\Facades\DB;
use Filament\Widgets\ChartWidget;
use Filament\Widgets\Concerns\InteractsWithPageFilters;

class AdminsPerformanceChart extends ChartWidget
{
    use InteractsWithPageFilters;

    protected static ?string $heading = 'أداء المديرين والمشرفين';
    protected static ?string $description = 'مقارنة شاملة بين الأدمنز من حيث الفروع والمقيمين والطلبات';
    protected int|string|array $columnSpan = 'full';

    protected function getData(): array
    {
        $limit = 7;

        // 1. عدد الفروع لكل أدمن (من جدول admin_branch)
        $branchesCount = DB::table('admin_branch')
            ->selectRaw('admin_id, COUNT(DISTINCT branch_id) as count')
            ->groupBy('admin_id')
            ->pluck('count', 'admin_id');

        // 2. عدد المقيمين لكل أدمن (عبر الفروع)
        $residentsCount = DB::table('residents')
            ->join('admin_branch', 'residents.branch_id', '=', 'admin_branch.branch_id')
            ->selectRaw('admin_branch.admin_id, COUNT(DISTINCT residents.id) as count')
            ->where('residents.is_active', true) // فقط المقيمين النشطين
            ->groupBy('admin_branch.admin_id')
            ->pluck('count', 'admin_id');

        // 3. عدد الطلبات لكل أدمن (عبر الفروع)
        $ordersCount = DB::table('orders')
            ->join('admin_branch', 'orders.branch_id', '=', 'admin_branch.branch_id')
            ->selectRaw('admin_branch.admin_id, COUNT(DISTINCT orders.id) as count')
            ->groupBy('admin_branch.admin_id')
            ->pluck('count', 'admin_id');

        // حساب المجموع لكل أدمن للترتيب
        $adminIds = collect($branchesCount->keys())
            ->merge($residentsCount->keys())
            ->merge($ordersCount->keys())
            ->unique();

        $adminScores = [];
        foreach ($adminIds as $adminId) {
            $adminScores[$adminId] =
                ($branchesCount[$adminId] ?? 0) * 10 +
                ($residentsCount[$adminId] ?? 0) +
                ($ordersCount[$adminId] ?? 0);
        }

        arsort($adminScores);
        $topAdminIds = array_slice(array_keys($adminScores), 0, $limit, true);

        // جلب أسماء الأدمنز
        $admins = Admin::query()
            ->whereIn('id', $topAdminIds)
            ->pluck('name', 'id')
            ->toArray();

        // ترتيب البيانات
        $labels = [];
        $branchesData = [];
        $residentsData = [];
        $ordersData = [];

        foreach ($topAdminIds as $adminId) {
            $labels[] = $admins[$adminId] ?? "مدير #{$adminId}";
            $branchesData[] = $branchesCount[$adminId] ?? 0;
            $residentsData[] = $residentsCount[$adminId] ?? 0;
            $ordersData[] = $ordersCount[$adminId] ?? 0;
        }

        return [
            'datasets' => [
                [
                    'label' => 'عدد الفروع',
                    'data' => $branchesData,
                    'backgroundColor' => 'rgba(99, 102, 241, 0.8)',
                    'borderColor' => '#6366f1',
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                ],
                [
                    'label' => 'عدد المقيمين',
                    'data' => $residentsData,
                    'backgroundColor' => 'rgba(16, 185, 129, 0.8)',
                    'borderColor' => '#10b981',
                    'borderWidth' => 2,
                    'borderRadius' => 8,
                ],
                [
                    'label' => 'عدد الطلبات',
                    'data' => $ordersData,
                    'backgroundColor' => 'rgba(245, 158, 11, 0.8)',
                    'borderColor' => '#f59e0b',
                    'borderWidth' => 2,
                    'borderRadius' => 8,
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
            'animation' => [
                'duration' => 2500,
                'easing' => 'easeOutElastic',
            ],
            'scales' => [
                'x' => [
                    'ticks' => [
                        'font' => ['size' => 13, 'weight' => '600'],
                        'color' => '#475569',
                        'maxRotation' => 45,
                        'minRotation' => 0,
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
                    'position' => 'top',
                    'labels' => [
                        'usePointStyle' => true,
                        'padding' => 20,
                        'font' => ['size' => 14, 'weight' => '600'],
                        'color' => '#475569',
                    ],
                ],
                'tooltip' => [
                    'mode' => 'index',
                    'intersect' => false,
                    'cornerRadius' => 12,
                    'padding' => 15,
                    'backgroundColor' => 'rgba(15, 23, 42, 0.95)',
                    'titleFont' => ['size' => 14, 'weight' => 'bold'],
                    'bodyFont' => ['size' => 13],
                ],
            ],
            'interaction' => [
                'mode' => 'index',
                'intersect' => false,
            ],
        ];
    }

    protected function getExtraAttributes(): array
    {
        return [
            'class' => 'rounded-3xl shadow-xl border-0 bg-white/50 dark:bg-gray-900/50 backdrop-blur-md transition-all duration-500 hover:shadow-2xl',
        ];
    }
}
