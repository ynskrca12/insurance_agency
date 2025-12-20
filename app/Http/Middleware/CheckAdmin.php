<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckAdmin
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kullanıcı giriş yapmış mı?
        if (!Auth::check()) {
            return redirect()->route('admin.login')
                ->with('error', 'Lütfen önce giriş yapın.');
        }

        // Kullanıcı admin mi?
        if (!Auth::user()->is_admin) {
            abort(403, 'Bu sayfaya erişim yetkiniz yok.');
        }

        return $next($request);
    }
}
