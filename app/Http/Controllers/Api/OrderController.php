<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\DeliveryApp;
use App\Models\Resident; // أضف هذا
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class OrderController extends Controller
{
    /**
     * عرض طلبات المقيم (طلباته فقط)
     */
    public function index(Request $request)
    {
        $resident = $request->user('resident-api');

        $orders = Order::where('resident_id', $resident->id)
            ->with(['branch', 'deliveryApp', 'media'])
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
                            'mime_type' => $media->mime_type,
                        ];
                    }),
                ];
            }),
        ], 200);
    }

    /**
     * عرض طلب واحد
     */
    public function show(Request $request, $id)
    {
        $resident = $request->user('resident-api');

        $order = Order::where('resident_id', $resident->id)
            ->with(['branch', 'deliveryApp', 'media'])
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
     * إنشاء طلب جديد مع صور وفيديو
     */
    public function store(Request $request)
    {
        $resident = $request->user('resident-api');

        // Validation
        $validator = Validator::make($request->all(), [
            'number' => 'required|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'branch_id' => 'required|exists:branches,id',
            'delivery_app_id' => 'nullable|exists:delivery_apps,id',
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp,bmp,svg|max:10240',
            'videos' => 'nullable|array',
            'videos.*' => 'required|file|mimetypes:video/mp4,video/quicktime,video/x-msvideo,video/x-ms-wmv,video/webm,video/mpeg|max:102400',
        ], [
            'number.required' => 'رقم الطلب مطلوب',
            'branch_id.required' => 'الفرع مطلوب',
            'branch_id.exists' => 'الفرع المحدد غير موجود',
            'delivery_app_id.exists' => 'تطبيق التوصيل المحدد غير موجود',
            'images.required' => 'يجب رفع صورة واحدة على الأقل',
            'images.min' => 'يجب رفع صورة واحدة على الأقل',
            'images.*.image' => 'الملف يجب أن يكون صورة',
            'images.*.mimes' => 'الصورة يجب أن تكون من نوع: jpeg, png, jpg, gif, webp, bmp, svg',
            'images.*.max' => 'حجم الصورة يجب ألا يتجاوز 10 ميجابايت',
            'videos.*.mimes' => 'الفيديو يجب أن يكون من نوع: mp4, mov, avi, wmv, flv, webm, mpeg',
            'videos.*.max' => 'حجم الفيديو يجب ألا يتجاوز 100 ميجابايت',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في البيانات المدخلة',
                'errors' => $validator->errors(),
            ], 422);
        }

        // التحقق من أن الفرع المحدد يتبع لأحد الـ Admins المرتبطين بالمقيم
        $branch = $resident->branch; // الفرع الأصلي للمقيم
        $adminIds = $branch->admins()->pluck('admins.id')->toArray();

        // التحقق من أن الفرع المطلوب يتبع لأحد هؤلاء الـ Admins
        $targetBranchExists = \DB::table('admin_branch')
            ->whereIn('admin_id', $adminIds)
            ->where('branch_id', $request->branch_id)
            ->exists();

        if (!$targetBranchExists) {
            return response()->json([
                'success' => false,
                'message' => 'الفرع المحدد غير تابع للمسؤولين المرتبطين بك',
            ], 403);
        }

        // إنشاء الطلب - أضف السطرين التاليين
        $order = Order::create([
            'resident_id' => $resident->id,
            'branch_id' => $request->branch_id,
            'delivery_app_id' => $request->delivery_app_id,
            'number' => $request->number,
            'notes' => $request->notes,
            'submitted_at' => now(),
            'created_by_type' => Resident::class, // ✅ إضافة
            'created_by_id' => $resident->id,     // ✅ إضافة
        ]);

        // رفع الصور بالجودة الأصلية
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $order->addMedia($image)
                    ->preservingOriginal()
                    ->toMediaCollection('images');
            }
        }

        // رفع الفيديو
        if ($request->hasFile('videos')) {
            foreach ($request->file('videos') as $video) {
                $order->addMedia($video)
                    ->preservingOriginal()
                    ->toMediaCollection('videos');
            }
        }

        // إعادة تحميل العلاقات
        $order->load(['branch', 'deliveryApp', 'media']);

        return response()->json([
            'success' => true,
            'message' => 'تم إنشاء الطلب بنجاح',
            'order' => [
                'id' => $order->id,
                'order_number' => $order->order_number,
                'number' => $order->number,
                'notes' => $order->notes,
                'submitted_at' => $order->submitted_at->format('Y-m-d H:i'),
                'branch' => [
                    'id' => $order->branch->id,
                    'name' => $order->branch->name,
                    'location' => $order->branch->location,
                ],
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
                'videos' => $order->getMedia('videos')->map(function ($media) {
                    return [
                        'id' => $media->id,
                        'name' => $media->file_name,
                        'url' => $media->getUrl(),
                        'size' => $media->human_readable_size,
                    ];
                }),
            ],
        ], 201);
    }

    /**
     * حذف طلب
     */
    public function destroy(Request $request, $id)
    {
        $resident = $request->user('resident-api');

        $order = Order::where('resident_id', $resident->id)->find($id);

        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'الطلب غير موجود',
            ], 404);
        }

        $order->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم حذف الطلب بنجاح',
        ], 200);
    }

    /**
     * إحصائيات الطلبات للمقيم
     */
    public function statistics(Request $request)
    {
        $resident = $request->user('resident-api');

        $total = Order::where('resident_id', $resident->id)->count();
        $thisMonth = Order::where('resident_id', $resident->id)
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();
        $today = Order::where('resident_id', $resident->id)
            ->whereDate('created_at', today())
            ->count();

        return response()->json([
            'success' => true,
            'statistics' => [
                'total' => $total,
                'this_month' => $thisMonth,
                'today' => $today,
            ],
        ], 200);
    }

    /**
     * الحصول على قائمة الفروع المتاحة للمقيم
     * (الفروع التابعة لنفس الـ Admins)
     */
    public function availableBranches(Request $request)
    {
        $resident = $request->user('resident-api');

        // الحصول على فرع المقيم
        $residentBranch = $resident->branch;

        // الحصول على IDs الـ Admins المرتبطين بفرع المقيم
        $adminIds = $residentBranch->admins()->pluck('admins.id')->toArray();

        // الحصول على جميع الفروع التابعة لهؤلاء الـ Admins
        $branches = \DB::table('branches')
            ->join('admin_branch', 'branches.id', '=', 'admin_branch.branch_id')
            ->whereIn('admin_branch.admin_id', $adminIds)
            ->where('branches.is_active', true)
            ->select('branches.id', 'branches.name', 'branches.location')
            ->distinct()
            ->get();

        return response()->json([
            'success' => true,
            'count' => $branches->count(),
            'branches' => $branches,
        ], 200);
    }

    /**
     * الحصول على قائمة تطبيقات التوصيل المتاحة
     */
    public function availableDeliveryApps(Request $request)
    {
        $deliveryApps = DeliveryApp::select('id', 'name')
            ->orderBy('name')
            ->get();

        return response()->json([
            'success' => true,
            'count' => $deliveryApps->count(),
            'delivery_apps' => $deliveryApps,
        ], 200);
    }
}
