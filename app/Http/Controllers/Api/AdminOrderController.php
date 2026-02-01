<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Resident;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminOrderController extends Controller
{
    /**
     * عرض جميع طلبات فروع الـ Admin (من المقيمين ومن الـ Admin نفسه)
     */
    public function index(Request $request)
{
    $admin = $request->user('admin-api');

    // جلب IDs الفروع المرتبطة بالـ Admin
    $branchIds = $admin->branches()->pluck('branches.id')->toArray();

    // جلب جميع الطلبات من فروع الـ Admin
    $orders = Order::whereIn('branch_id', $branchIds)
        ->with(['resident', 'branch', 'deliveryApp', 'media'])
        ->orderBy('submitted_at', 'desc')
        ->get();

    return response()->json([
        'success' => true,
        'count' => $orders->count(),
        'orders' => $orders->map(function ($order) {
            // تحديد من أنشأ الطلب
            $isAdminCreated = $order->created_by_type === 'App\Models\Admin';

            $createdBy = null;
            if ($order->created_by_type && $order->created_by_id) {
                if ($isAdminCreated) {
                    $admin = \App\Models\Admin::find($order->created_by_id);
                    $createdBy = $admin ? [
                        'type' => 'admin',
                        'id' => $admin->id,
                        'name' => $admin->name,
                    ] : null;
                } else {
                    $resident = \App\Models\Resident::find($order->created_by_id);
                    $createdBy = $resident ? [
                        'type' => 'resident',
                        'id' => $resident->id,
                        'name' => $resident->name,
                    ] : null;
                }
            }

            return [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'number' => $order->number,
                'notes' => $order->notes,
                'submitted_at' => $order->submitted_at->format('Y-m-d H:i'),
                'created_at' => $order->created_at->format('Y-m-d H:i'),

                // معرّف: هل رفعه Admin أو Resident
                'is_admin_created' => $isAdminCreated,
                'created_by' => $createdBy,

                'resident' => $order->resident ? [
                    'id' => $order->resident->id,
                    'name' => $order->resident->name,
                    'phone' => $order->resident->phone,
                ] : null,

                'branch' => [
                    'id' => $order->branch->id,
                    'name' => $order->branch->name,
                    'location' => $order->branch->location,
                ],

                'delivery_app' => $order->deliveryApp ? [
                    'id' => $order->deliveryApp->id,
                    'name' => $order->deliveryApp->name,
                ] : null,

                'images' => $order->getMedia('images')->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'name' => $media->file_name,
                        'url' => $media->getUrl(),
                        'size' => $media->human_readable_size,
                    ];
                }),

                'videos' => $order->getMedia('videos')->map(function ($media) {
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
     * إنشاء طلب جديد من الـ Admin
     */
    public function store(Request $request)
    {
        $admin = $request->user('admin-api');

        // Validation
        $validator = Validator::make($request->all(), [
            'number' => 'required|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'branch_id' => 'required|exists:branches,id',
            'resident_id' => 'nullable|exists:residents,id',
            'delivery_app_id' => 'nullable|exists:delivery_apps,id',
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp,bmp,svg|max:10240',
            'video' => 'nullable|file|max:102400',
        ], [
            'number.required' => 'رقم الطلب مطلوب',
            'branch_id.required' => 'الفرع مطلوب',
            'branch_id.exists' => 'الفرع المحدد غير موجود',
            'resident_id.exists' => 'المقيم المحدد غير موجود',
            'delivery_app_id.exists' => 'تطبيق التوصيل المحدد غير موجود',
            'images.required' => 'يجب رفع صورة واحدة على الأقل',
            'images.min' => 'يجب رفع صورة واحدة على الأقل',
            'images.*.image' => 'الملف يجب أن يكون صورة',
            'images.*.mimes' => 'الصورة يجب أن تكون من نوع: jpeg, png, jpg, gif, webp, bmp, svg',
            'images.*.max' => 'حجم الصورة يجب ألا يتجاوز 10 ميجابايت',
            'video.max' => 'حجم الفيديو يجب ألا يتجاوز 100 ميجابايت',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في البيانات المدخلة',
                'errors' => $validator->errors(),
            ], 422);
        }

        // التحقق من أن الفرع يتبع للـ Admin
        $branchIds = $admin->branches()->pluck('branches.id')->toArray();

        if (!in_array($request->branch_id, $branchIds)) {
            return response()->json([
                'success' => false,
                'message' => 'الفرع المحدد غير تابع لك',
            ], 403);
        }

        // التحقق من أن المقيم (إذا حُدد) يتبع لأحد فروع الـ Admin
        if ($request->resident_id) {
            $resident = Resident::find($request->resident_id);
            if (!in_array($resident->branch_id, $branchIds)) {
                return response()->json([
                    'success' => false,
                    'message' => 'المقيم المحدد غير تابع لفروعك',
                ], 403);
            }
        }

        // إنشاء الطلب
        $order = Order::create([
            'resident_id' => $request->resident_id, // يمكن أن يكون null
            'branch_id' => $request->branch_id,
            'delivery_app_id' => $request->delivery_app_id,
            'number' => $request->number,
            'notes' => $request->notes,
            'submitted_at' => now(),
            'created_by_type' => Admin::class,
            'created_by_id' => $admin->id,
        ]);

        // رفع الصور
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $order->addMedia($image)
                    ->preservingOriginal()
                    ->toMediaCollection('images');
            }
        }

        // رفع الفيديو
        if ($request->hasFile('video')) {
            $order->addMedia($request->file('video'))
                ->preservingOriginal()
                ->toMediaCollection('videos');
        }

        // إعادة تحميل العلاقات
        $order->load(['branch', 'resident', 'deliveryApp', 'media', 'createdBy']);

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء الطلب بنجاح من قبل الـ Admin',
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'number' => $order->number,
                'notes' => $order->notes,
                'submitted_at' => $order->submitted_at->format('Y-m-d H:i'),
                'is_admin_created' => true,
                'created_by' => [
                    'type' => 'admin',
                    'id' => $admin->id,
                    'name' => $admin->name,
                ],
                'branch' => [
                    'id' => $order->branch->id,
                    'name' => $order->branch->name,
                ],
                'resident' => $order->resident ? [
                    'id' => $order->resident->id,
                    'name' => $order->resident->name,
                ] : null,
                'delivery_app' => $order->deliveryApp ? [
                    'id' => $order->deliveryApp->id,
                    'name' => $order->deliveryApp->name,
                ] : null,
                'images_count' => $order->getMedia('images')->count(),
                'images' => $order->getMedia('images')->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'name' => $media->file_name,
                        'url' => $media->getUrl(),
                        'size' => $media->human_readable_size,
                    ];
                }),
                'video' => $order->getMedia('videos')->first() ? [
                    'id' => $order->getMedia('videos')->first()->id,
                    'name' => $order->getMedia('videos')->first()->file_name,
                    'url' => $order->getMedia('videos')->first()->getUrl(),
                    'size' => $order->getMedia('videos')->first()->human_readable_size,
                ] : null,
            ],
        ], 201);
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
            ->with(['resident', 'branch', 'deliveryApp', 'media', 'createdBy'])
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

                'is_admin_created' => $order->isCreatedByAdmin(),
                'created_by' => $order->createdBy ? [
                    'type' => $order->created_by_type === Admin::class ? 'admin' : 'resident',
                    'id' => $order->createdBy->id,
                    'name' => $order->createdBy->name,
                ] : null,

                'resident' => $order->resident ? [
                    'id' => $order->resident->id,
                    'name' => $order->resident->name,
                    'phone' => $order->resident->phone,
                ] : null,

                'branch' => [
                    'id' => $order->branch->id,
                    'name' => $order->branch->name,
                    'location' => $order->branch->location,
                ],

                'delivery_app' => $order->deliveryApp ? [
                    'id' => $order->deliveryApp->id,
                    'name' => $order->deliveryApp->name,
                ] : null,

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

                'videos' => $order->getMedia('videos')->map(function ($media) {
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
            ->with(['resident', 'branch', 'deliveryApp', 'media', 'createdBy'])
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
                    'is_admin_created' => $order->isCreatedByAdmin(),
                    'resident' => $order->resident ? [
                        'id' => $order->resident->id,
                        'name' => $order->resident->name,
                        'phone' => $order->resident->phone,
                    ] : null,
                    'images_count' => $order->getMedia('images')->count(),
                    'videos_count' => $order->getMedia('videos')->count(),
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
            ->with(['resident', 'branch', 'deliveryApp', 'media'])
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
                    'is_admin_created' => $order->isCreatedByAdmin(),
                    'branch' => [
                        'id' => $order->branch->id,
                        'name' => $order->branch->name,
                    ],
                    'images_count' => $order->getMedia('images')->count(),
                    'videos_count' => $order->getMedia('videos')->count(),
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
            ->whereYear('created_at', now()->year)
            ->count();

        // طلبات الـ Admin vs المقيمين
        $adminCreated = Order::whereIn('branch_id', $branchIds)
            ->where('created_by_type', Admin::class)
            ->count();
        $residentCreated = Order::whereIn('branch_id', $branchIds)
            ->where('created_by_type', Resident::class)
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
                'admin_created' => Order::where('branch_id', $branch->id)
                    ->where('created_by_type', Admin::class)
                    ->count(),
                'resident_created' => Order::where('branch_id', $branch->id)
                    ->where('created_by_type', Resident::class)
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
                'admin_created' => $adminCreated,
                'resident_created' => $residentCreated,
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
            ->with(['resident', 'branch', 'deliveryApp', 'media', 'createdBy'])
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
                    'is_admin_created' => $order->isCreatedByAdmin(),
                    'resident' => $order->resident ? [
                        'id' => $order->resident->id,
                        'name' => $order->resident->name,
                        'phone' => $order->resident->phone,
                    ] : null,
                    'branch' => [
                        'id' => $order->branch->id,
                        'name' => $order->branch->name,
                    ],
                    'submitted_at' => $order->submitted_at->format('Y-m-d H:i'),
                ];
            }),
        ], 200);
    }

    /**
     * الحصول على قائمة المقيمين في فروع الـ Admin
     */
    public function availableResidents(Request $request)
    {
        $admin = $request->user('admin-api');
        $branchIds = $admin->branches()->pluck('branches.id')->toArray();

        $residents = Resident::whereIn('branch_id', $branchIds)
            ->where('is_active', true)
            ->select('id', 'name', 'phone', 'branch_id')
            ->with('branch:id,name')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $residents->count(),
            'residents' => $residents,
        ], 200);
    }
}
