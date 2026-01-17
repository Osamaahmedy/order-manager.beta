<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class AdminOrderController extends Controller
{
    /**
     * عرض طلبات فروع الـ Admin فقط
     */
    public function index(Request $request)
    {
        $admin = $request->user('admin-api');

        // جلب IDs الفروع المرتبطة بالـ Admin
        $branchIds = $admin->branches()->pluck('branches.id')->toArray();

        // جلب الطلبات من فروع الـ Admin فقط
        $orders = Order::whereIn('branch_id', $branchIds)
            ->with(['resident', 'branch', 'media'])
            ->orderBy('submitted_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $orders->count(),
            'orders' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'number' => $order->number,
                    'notes' => $order->notes,
                    'submitted_at' => $order->submitted_at->format('Y-m-d H:i'),
                    'created_at' => $order->created_at->format('Y-m-d H:i'),
                    'resident' => [
                        'id' => $order->resident->id,
                        'name' => $order->resident->name,
                        'phone' => $order->resident->phone,
                    ],
                    'branch' => [
                        'id' => $order->branch->id,
                        'name' => $order->branch->name,
                        'type' => $order->branch->type,
                    ],
                    'images' => $order->getMedia('images')->map(function ($media) {
                        return [
                            'id' => $media->id,
                            'name' => $media->file_name,
                            'url' => $media->getUrl(),
                            'size' => $media->human_readable_size,
                        ];
                    }),
                ];
            }),
        ], 200);
    }

    /**
     * عرض طلب واحد (من فروع الـ Admin فقط)
     */
    public function show(Request $request, $id)
    {
        $admin = $request->user('admin-api');

        // جلب IDs الفروع المرتبطة بالـ Admin
        $branchIds = $admin->branches()->pluck('branches.id')->toArray();

        // جلب الطلب إذا كان من فروع الـ Admin
        $order = Order::whereIn('branch_id', $branchIds)
            ->with(['resident', 'branch', 'media'])
            ->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود أو ليس لديك صلاحية للوصول إليه',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'number' => $order->number,
                'notes' => $order->notes,
                'submitted_at' => $order->submitted_at->format('Y-m-d H:i'),
                'created_at' => $order->created_at->format('Y-m-d H:i'),
                'resident' => [
                    'id' => $order->resident->id,
                    'name' => $order->resident->name,
                    'phone' => $order->resident->phone,
                ],
                'branch' => [
                    'id' => $order->branch->id,
                    'name' => $order->branch->name,
                    'type' => $order->branch->type,
                ],
                'images' => $order->getMedia('images')->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'name' => $media->file_name,
                        'url' => $media->getUrl(),
                        'size' => $media->human_readable_size,
                        'mime_type' => $media->mime_type,
                        'created_at' => $media->created_at->format('Y-m-d H:i'),
                    ];
                }),
            ],
        ], 200);
    }

    /**
     * عرض طلبات فرع معين (من فروع الـ Admin)
     */
    public function byBranch(Request $request, $branchId)
    {
        $admin = $request->user('admin-api');

        // جلب IDs الفروع المرتبطة بالـ Admin
        $branchIds = $admin->branches()->pluck('branches.id')->toArray();

        // التحقق من أن الفرع من فروع الـ Admin
        if (!in_array($branchId, $branchIds)) {
            return response()->json([
                'success' => false,
                'message' => 'ليس لديك صلاحية للوصول إلى طلبات هذا الفرع',
            ], 403);
        }

        // جلب الطلبات
        $orders = Order::where('branch_id', $branchId)
            ->with(['resident', 'branch', 'media'])
            ->orderBy('submitted_at', 'desc')
            ->get();

        return response()->json([
            'success' => true,
            'branch_id' => $branchId,
            'count' => $orders->count(),
            'orders' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'number' => $order->number,
                    'notes' => $order->notes,
                    'submitted_at' => $order->submitted_at->format('Y-m-d H:i'),
                    'resident' => [
                        'id' => $order->resident->id,
                        'name' => $order->resident->name,
                        'phone' => $order->resident->phone,
                    ],
                    'images_count' => $order->getMedia('images')->count(),
                ];
            }),
        ], 200);
    }

    /**
     * عرض طلبات مقيم معين (من فروع الـ Admin)
     */
    public function byResident(Request $request, $residentId)
    {
        $admin = $request->user('admin-api');

        // جلب IDs الفروع المرتبطة بالـ Admin
        $branchIds = $admin->branches()->pluck('branches.id')->toArray();

        // جلب الطلبات
        $orders = Order::whereIn('branch_id', $branchIds)
            ->where('resident_id', $residentId)
            ->with(['resident', 'branch', 'media'])
            ->orderBy('submitted_at', 'desc')
            ->get();

        if ($orders->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'لا توجد طلبات لهذا المقيم أو ليس من فروعك',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'resident_id' => $residentId,
            'count' => $orders->count(),
            'orders' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'number' => $order->number,
                    'notes' => $order->notes,
                    'submitted_at' => $order->submitted_at->format('Y-m-d H:i'),
                    'branch' => [
                        'id' => $order->branch->id,
                        'name' => $order->branch->name,
                    ],
                    'images_count' => $order->getMedia('images')->count(),
                ];
            }),
        ], 200);
    }

    /**
     * إحصائيات طلبات فروع الـ Admin
     */
    public function statistics(Request $request)
    {
        $admin = $request->user('admin-api');

        // جلب IDs الفروع المرتبطة بالـ Admin
        $branchIds = $admin->branches()->pluck('branches.id')->toArray();

        $total = Order::whereIn('branch_id', $branchIds)->count();
        $today = Order::whereIn('branch_id', $branchIds)
            ->whereDate('created_at', today())
            ->count();
        $thisWeek = Order::whereIn('branch_id', $branchIds)
            ->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->count();
        $thisMonth = Order::whereIn('branch_id', $branchIds)
            ->whereMonth('created_at', now()->month)
            ->count();

        // إحصائيات لكل فرع
        $branchesStats = $admin->branches->map(function ($branch) {
            return [
                'branch_id' => $branch->id,
                'branch_name' => $branch->name,
                'orders_count' => Order::where('branch_id', $branch->id)->count(),
                'today' => Order::where('branch_id', $branch->id)
                    ->whereDate('created_at', today())
                    ->count(),
            ];
        });

        return response()->json([
            'success' => true,
            'statistics' => [
                'total' => $total,
                'today' => $today,
                'this_week' => $thisWeek,
                'this_month' => $thisMonth,
                'branches' => $branchesStats,
            ],
        ], 200);
    }

    /**
     * البحث في الطلبات (فروع الـ Admin فقط)
     */
    public function search(Request $request)
    {
        $admin = $request->user('admin-api');
        $searchTerm = $request->input('search');

        if (empty($searchTerm)) {
            return response()->json([
                'success' => false,
                'message' => 'يرجى إدخال كلمة البحث',
            ], 400);
        }

        // جلب IDs الفروع المرتبطة بالـ Admin
        $branchIds = $admin->branches()->pluck('branches.id')->toArray();

        // البحث
        $orders = Order::whereIn('branch_id', $branchIds)
            ->where(function ($query) use ($searchTerm) {
                $query->where('order_number', 'like', "%{$searchTerm}%")
                    ->orWhere('number', 'like', "%{$searchTerm}%")
                    ->orWhereHas('resident', function ($q) use ($searchTerm) {
                        $q->where('name', 'like', "%{$searchTerm}%")
                          ->orWhere('phone', 'like', "%{$searchTerm}%");
                    });
            })
            ->with(['resident', 'branch', 'media'])
            ->orderBy('submitted_at', 'desc')
            ->limit(50)
            ->get();

        return response()->json([
            'success' => true,
            'search_term' => $searchTerm,
            'count' => $orders->count(),
            'orders' => $orders->map(function ($order) {
                return [
                    'id' => $order->id,
                    'order_number' => $order->order_number,
                    'number' => $order->number,
                    'resident' => [
                        'id' => $order->resident->id,
                        'name' => $order->resident->name,
                        'phone' => $order->resident->phone,
                    ],
                    'branch' => [
                        'id' => $order->branch->id,
                        'name' => $order->branch->name,
                    ],
                    'submitted_at' => $order->submitted_at->format('Y-m-d H:i'),
                ];
            }),
        ], 200);
    }
}
