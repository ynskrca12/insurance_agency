<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\DemoUser;

class CheckDemoExpiry
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (auth()->check()) {
            $user = auth()->user();
            $demoUser = DemoUser::where('user_id', $user->id)->first();

            // Demo kullanıcı ise kontrol et
            if ($demoUser) {
                // Demo süresi dolmuşsa
                if ($demoUser->isExpired()) {
                    // Logout ve expired sayfası hariç her yere yönlendir
                    if (!$request->routeIs('demo.expired') && !$request->routeIs('logout')) {
                        return redirect()->route('demo.expired');
                    }
                }
            }
        }

        return $next($request);
    }
}
