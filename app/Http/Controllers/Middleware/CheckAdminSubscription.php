<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAdminSubscription
{
    public function handle(Request $request, Closure $next)
    {
        $user = auth()->user();

        if (!$user instanceof \App\Models\Admin) {
            return $next($request);
        }

        if (!$user->subscribed()) {
            auth()->logout();

            return redirect()
                ->route('filament.admin.auth.login')
                ->with('error', 'انتهى اشتراكك. يرجى تجديد الاشتراك للمتابعة.');
        }

        return $next($request);
    }
}
