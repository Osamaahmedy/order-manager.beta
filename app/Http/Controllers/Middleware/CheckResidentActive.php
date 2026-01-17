<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckResidentActive
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth('api')->user();

        if ($user instanceof \App\Models\Resident && !$user->is_active) {
            return response()->json([
                'success' => false,
                'message' => 'حسابك معطل. يرجى التواصل مع الإدارة.'
            ], 403);
        }

        return $next($request);
    }
}
