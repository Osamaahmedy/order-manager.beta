<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
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
            ->with(['branch', 'media'])
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
     * عرض طلب واحد
     */
    public function show(Request $request, $id)
    {
        $resident = $request->user('resident-api');

        $order = Order::where('resident_id', $resident->id)
            ->with(['branch', 'media'])
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
     * إنشاء طلب جديد مع صور
     */
    public function store(Request $request)
    {
        $resident = $request->user('resident-api');

        // Validation
        $validator = Validator::make($request->all(), [
            'number' => 'required|string|max:50',
            'notes' => 'nullable|string|max:1000',
            'images' => 'required|array|min:1',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,gif,webp,bmp,svg',
        ], [
            'number.required' => 'رقم الطلب مطلوب',
            'images.required' => 'يجب رفع صورة واحدة على الأقل',
            'images.min' => 'يجب رفع صورة واحدة على الأقل',
            'images.*.image' => 'الملف يجب أن يكون صورة',
            'images.*.mimes' => 'الصورة يجب أن تكون من نوع: jpeg, png, jpg, gif, webp, bmp, svg',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في البيانات المدخلة',
                'errors' => $validator->errors(),
            ], 422);
        }

        // إنشاء الطلب
        $order = Order::create([
            'resident_id' => $resident->id,
            'branch_id' => $resident->branch_id,
            'number' => $request->number,
            'notes' => $request->notes,
            'submitted_at' => now(),
        ]);

        // رفع الصور بالجودة الأصلية
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $order->addMedia($image)
                    ->preservingOriginal()
                    ->toMediaCollection('images');
            }
        }

        // إعادة تحميل العلاقات
        $order->load(['branch', 'media']);

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
                    'type' => $order->branch->type,
                ],
                'images_count' => $order->getMedia('images')->count(),
                'images' => $order->getMedia('images')->map(function ($media) {
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
}
