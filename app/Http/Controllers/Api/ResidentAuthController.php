<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class ResidentAuthController extends Controller
{
    /**
     * تسجيل دخول المقيم
     * يحذف كل الـ Tokens القديمة ويصدر token جديد
     */
    public function login(Request $request)
    {
        $request->validate([
            'phone' => 'required|string',
            'password' => 'required|string|min:6',
        ]);

        $resident = Resident::where('phone', $request->phone)->first();

        // ✅ التحقق من صحة البيانات
        if (!$resident || !Hash::check($request->password, $resident->password)) {
           return response()->json([
    'success' => false,
    'message' => 'رقم الهاتف أو كلمة المرور غير صحيحة',
], 401);

        }

        // ✅ التحقق من أن المقيم نشط
        if (!$resident->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'حسابك معطل. يرجى التواصل مع الإدارة.',
            ], 403);
        }

        // ✅ التحقق من أن الفرع نشط
        if (!$resident->branch || !$resident->branch->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'الفرع التابع لك معطل حالياً. يرجى التواصل مع الإدارة.',
            ], 403);
        }

        // ✅ التحقق من اشتراك المسؤول
        $admin = $resident->getAdmin();
        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'لا يوجد مسؤول مرتبط بهذا الفرع.',
            ], 403);
        }

        if (!$admin->subscribed()) {
            return response()->json([
                'success' => false,
                'message' => 'انتهى اشتراك المسؤول. يرجى التواصل مع الإدارة لتجديد الاشتراك.',
            ], 403);
        }

        $subscription = $admin->subscription();

        // ✅ التحقق من حالة الاشتراك
        if ($subscription && in_array($subscription->status, ['expired', 'canceled', 'suspended'])) {
            return response()->json([
                'success' => false,
                'message' => 'اشتراك المسؤول ' . match($subscription->status) {
                    'expired' => 'منتهي',
                    'canceled' => 'ملغي',
                    'suspended' => 'معلق',
                    default => 'غير نشط'
                } . '. يرجى التواصل مع الإدارة.',
            ], 403);
        }

        // حذف كل الـ Tokens القديمة
        $resident->tokens()->delete();

        // إنشاء Token جديد
        $token = $resident->createToken('resident-token')->accessToken;

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الدخول بنجاح',
            'token' => $token,
            'token_type' => 'Bearer',
            'resident' => [
                'id' => $resident->id,
                'name' => $resident->name,
                'phone' => $resident->phone,
                'is_active' => $resident->is_active,
                'branch' => [
                    'id' => $resident->branch->id,
                    'name' => $resident->branch->name,
                    'location' => $resident->branch->location,
                    'is_active' => $resident->branch->is_active,
                ],
            ],
        ], 200);
    }

    /**
     * تسجيل خروج المقيم
     * يحذف الـ Token الحالي
     */
    public function logout(Request $request)
    {
        $request->user('api')->token()->revoke();

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الخروج بنجاح',
        ], 200);
    }

    /**
     * حذف كل الـ Tokens (تسجيل خروج من كل الأجهزة)
     */
    public function logoutAll(Request $request)
    {
        $resident = $request->user('api');
        $resident->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الخروج من جميع الأجهزة بنجاح',
        ], 200);
    }

    /**
     * عرض بيانات المقيم (Profile)
     */
    public function profile(Request $request)
    {
        $resident = $request->user('api')->load('branch');

        // ✅ التحقق من حالة المقيم والاشتراك
        if (!$resident->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'حسابك معطل حالياً',
            ], 403);
        }

        $admin = $resident->getAdmin();
        $subscription = $admin ? $admin->subscription() : null;

        return response()->json([
            'success' => true,
            'resident' => [
                'id' => $resident->id,
                'name' => $resident->name,
                'phone' => $resident->phone,
                'is_active' => $resident->is_active,
                'created_at' => $resident->created_at->format('Y-m-d H:i:s'),
                'branch' => $resident->branch ? [
                    'id' => $resident->branch->id,
                    'name' => $resident->branch->name,
                    'location' => $resident->branch->location,
                    'is_active' => $resident->branch->is_active,
                ] : null,
                'subscription_status' => $subscription ? [
                    'is_active' => $subscription->isActive(),
                    'status' => $subscription->status,
                    'plan_name' => $subscription->plan->name,
                    'ends_at' => $subscription->ends_at ? $subscription->ends_at->format('Y-m-d') : null,
                    'days_remaining' => $subscription->daysRemaining(),
                    'on_trial' => $subscription->onTrial(),
                ] : null,
            ],
        ], 200);
    }

    /**
     * تحديث بيانات المقيم
     */
    public function updateProfile(Request $request)
    {
        $resident = $request->user('api');

        // ✅ التحقق من حالة المقيم
        if (!$resident->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'حسابك معطل. لا يمكنك تحديث البيانات.',
            ], 403);
        }

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'phone' => 'sometimes|string|unique:residents,phone,' . $resident->id,
            'password' => 'sometimes|string|min:6|confirmed',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $resident->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث البيانات بنجاح',
            'resident' => [
                'id' => $resident->id,
                'name' => $resident->name,
                'phone' => $resident->phone,
            ],
        ], 200);
    }

    /**
     * عرض بيانات القسم المرتبط بالمقيم
     */
    public function branch(Request $request)
    {
        $resident = $request->user('api');
        $branch = $resident->branch()->with('admins')->first();

        if (!$branch) {
            return response()->json([
                'success' => false,
                'message' => 'لا يوجد قسم مرتبط بهذا المقيم',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'branch' => [
                'id' => $branch->id,
                'name' => $branch->name,
                'location' => $branch->location,
                'is_active' => $branch->is_active,
                'created_at' => $branch->created_at->format('Y-m-d'),
                'admins' => $branch->admins->map(function ($admin) {
                    return [
                        'id' => $admin->id,
                        'name' => $admin->name,
                        'email' => $admin->email,
                        'phone' => $admin->phone,
                    ];
                }),
            ],
        ], 200);
    }

    /**
     * ✅ جديد: التحقق من حالة الاشتراك
     */
    public function checkSubscription(Request $request)
    {
        $resident = $request->user('api');
        $admin = $resident->getAdmin();

        if (!$admin) {
            return response()->json([
                'success' => false,
                'message' => 'لا يوجد مسؤول مرتبط',
            ], 404);
        }

        $subscription = $admin->subscription();

        if (!$subscription) {
            return response()->json([
                'success' => false,
                'message' => 'لا يوجد اشتراك نشط',
                'subscription' => null,
            ], 200);
        }

        return response()->json([
            'success' => true,
            'subscription' => [
                'is_active' => $subscription->isActive(),
                'status' => $subscription->status,
                'plan_name' => $subscription->plan->name,
                'plan_price' => $subscription->plan->price,
                'plan_interval' => $subscription->plan->getIntervalInArabic(),
                'starts_at' => $subscription->starts_at->format('Y-m-d'),
                'ends_at' => $subscription->ends_at ? $subscription->ends_at->format('Y-m-d') : null,
                'days_remaining' => $subscription->daysRemaining(),
                'on_trial' => $subscription->onTrial(),
                'trial_ends_at' => $subscription->trial_ends_at ? $subscription->trial_ends_at->format('Y-m-d') : null,
            ],
        ], 200);
    }
    /**
 * عرض كل الفروع المرتبطة بالأدمن التابع للمقيم
 */
public function adminBranches(Request $request)
{
    $resident = $request->user('api');

    // الحصول على الأدمن المرتبط بالمقيم
    $admin = $resident->getAdmin();

    if (!$admin) {
        return response()->json([
            'success' => false,
            'message' => 'لا يوجد مسؤول مرتبط بهذا المقيم',
        ], 404);
    }

    // جلب كل الفروع المرتبطة بالأدمن
    $branches = $admin->branches()->get();

    // أو إذا تبي الفروع النشطة فقط:
    // $branches = $admin->activeBranches()->get();

    if ($branches->isEmpty()) {
        return response()->json([
            'success' => false,
            'message' => 'لا توجد فروع مرتبطة بالمسؤول',
        ], 404);
    }

    return response()->json([
        'success' => true,
        'total' => $branches->count(),
        'branches' => $branches->map(function ($branch) {
            return [
                'id' => $branch->id,
                'name' => $branch->name,
                'location' => $branch->location,
                'is_active' => $branch->is_active,
                'created_at' => $branch->created_at->format('Y-m-d'),
            ];
        }),
    ], 200);
}

}
