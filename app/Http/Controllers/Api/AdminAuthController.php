<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * تسجيل دخول المشرف
     * يحذف كل الـ Tokens القديمة ويصدر token جديد
     */
public function login(Request $request)
{
    $request->validate([
        'phone' => 'required|string',
        'password' => 'required|string|min:6',
    ]);

    $admin = Admin::where('phone', $request->phone)->first();

    if (!$admin || !Hash::check($request->password, $admin->password)) {
        return response()->json([
            'success' => false,
            'message' => 'رقم الهاتف أو كلمة المرور غير صحيحة',
        ], 401);
    }

    // حذف كل التوكنات القديمة
    $admin->tokens()->delete();

    // إنشاء توكن جديد
    $token = $admin->createToken('admin-token')->accessToken;

    return response()->json([
        'success' => true,
        'message' => 'تم تسجيل الدخول بنجاح',
        'token' => $token,
        'token_type' => 'Bearer',
        'admin' => [
            'id' => $admin->id,
            'name' => $admin->name,
            'email' => $admin->email,
            'phone' => $admin->phone,
            'branches' => $admin->branches,
        ],
    ], 200);
}



    /**
     * تسجيل خروج المشرف
     * يحذف الـ Token الحالي
     */
    public function logout(Request $request)
    {
        $request->user('admin-api')->token()->revoke();

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
        $admin = $request->user('admin-api');
        $admin->tokens()->delete();

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل الخروج من جميع الأجهزة بنجاح',
        ], 200);
    }

    /**
     * عرض بيانات المشرف (Profile)
     */
    public function profile(Request $request)
    {
        $admin = $request->user('admin-api')->load('branches');

        return response()->json([
            'success' => true,
            'admin' => [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'phone' => $admin->phone,
                'created_at' => $admin->created_at->format('Y-m-d H:i:s'),
                'branches' => $admin->branches->map(function ($branch) {
                    return [
                        'id' => $branch->id,
                        'name' => $branch->name,
                        'type' => $branch->type,
                    ];
                }),
            ],
        ], 200);
    }

    /**
     * تحديث بيانات المشرف
     */
    public function updateProfile(Request $request)
    {
        $admin = $request->user('admin-api');

        $validated = $request->validate([
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|email|unique:admins,email,' . $admin->id,
            'phone' => 'sometimes|string|max:255',
            'password' => 'sometimes|string|min:8|confirmed',
        ]);

        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $admin->update($validated);

        return response()->json([
            'success' => true,
            'message' => 'تم تحديث البيانات بنجاح',
            'admin' => [
                'id' => $admin->id,
                'name' => $admin->name,
                'email' => $admin->email,
                'phone' => $admin->phone,
            ],
        ], 200);
    }

    /**
     * عرض الأقسام المرتبطة بالمشرف
     */
   public function branches(Request $request)
{
    $admin = $request->user('admin-api');

    $branches = $admin->branches()
        ->where('is_active', true)
        ->withCount('residents')
        ->orderBy('name')
        ->get();

    return response()->json([
        'success' => true,
        'count' => $branches->count(),
        'branches' => $branches->map(function ($branch) {
            return [
                'id' => $branch->id,
                'name' => $branch->name,
                'type' => $branch->type,
                'location' => $branch->location,
                'residents_count' => $branch->residents_count,
                'created_at' => $branch->created_at->format('Y-m-d'),
            ];
        }),
    ], 200);
}

}
