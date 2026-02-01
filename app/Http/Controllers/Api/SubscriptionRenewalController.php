<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\SubscriptionRenewalRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubscriptionRenewalController extends Controller
{
    /**
     * عرض جميع طلبات الأدمن الحالي
     */
    public function index(Request $request)
    {
        $admin = $request->user('admin-api');

        $requests = SubscriptionRenewalRequest::query()
            ->where('admin_id', $admin->id)
            ->orderByRaw("FIELD(status, 'pending', 'approved', 'rejected')")
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($req) {
                return [
                    'id' => $req->id,
                    'transfer_number' => $req->transfer_number,
                    'notes' => $req->notes,
                    'status' => $req->status,
                    'status_text' => match($req->status) {
                        'pending' => 'قيد الانتظار',
                        'approved' => 'تم التجديد',
                        'rejected' => 'مرفوض',
                    },
                    'image_url' => $req->getFirstMediaUrl('transfer_image'),
                    'reviewed_at' => $req->reviewed_at?->format('Y-m-d H:i:s'),
                    'created_at' => $req->created_at->format('Y-m-d H:i:s'),
                ];
            });

        return response()->json([
            'success' => true,
            'data' => $requests,
        ]);
    }

    /**
     * إنشاء طلب تجديد جديد
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transfer_number' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg|max:5120',
            'notes' => 'nullable|string|max:1000',
        ], [
            'transfer_number.required' => 'رقم الحوالة مطلوب',
            'image.image' => 'الملف يجب أن يكون صورة',
            'image.mimes' => 'الصورة يجب أن تكون بصيغة jpeg, png, أو jpg',
            'image.max' => 'حجم الصورة يجب ألا يتجاوز 5 ميجابايت',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'خطأ في البيانات المدخلة',
                'errors' => $validator->errors(),
            ], 422);
        }

        $admin = $request->user('admin-api');

        // التحقق من عدم وجود طلب قيد الانتظار
        $pendingRequest = SubscriptionRenewalRequest::where('admin_id', $admin->id)
            ->where('status', 'pending')
            ->exists();

        if ($pendingRequest) {
            return response()->json([
                'success' => false,
                'message' => 'لديك طلب قيد الانتظار بالفعل',
            ], 400);
        }

        $renewalRequest = SubscriptionRenewalRequest::create([
            'admin_id' => $admin->id,
            'transfer_number' => $request->transfer_number,
            'notes' => $request->notes,
        ]);

        if ($request->hasFile('image')) {
            $renewalRequest->addMedia($request->file('image'))
                ->toMediaCollection('transfer_image');
        }

        return response()->json([
            'success' => true,
            'message' => 'تم إرسال طلب التجديد بنجاح',
            'data' => [
                'id' => $renewalRequest->id,
                'transfer_number' => $renewalRequest->transfer_number,
                'status' => $renewalRequest->status,
                'status_text' => 'قيد الانتظار',
                'created_at' => $renewalRequest->created_at->format('Y-m-d H:i:s'),
            ],
        ], 201);
    }
}
