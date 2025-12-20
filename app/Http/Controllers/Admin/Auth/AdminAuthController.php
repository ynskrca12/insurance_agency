<?php

namespace App\Http\Controllers\Admin\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

class AdminAuthController extends Controller
{
    /**
     * Admin login formunu göster
     */
    public function showLoginForm()
    {
        // Zaten admin olarak giriş yapmışsa dashboard'a yönlendir
        if (Auth::check() && Auth::user()->is_admin) {
            return redirect()->route('admin.dashboard');
        }

        return view('admin.auth.login');
    }

    /**
     * Admin login işlemi
     */
    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'E-posta adresi gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'password.required' => 'Şifre gereklidir.',
        ]);

        $remember = $request->filled('remember');

        // Önce normal authentication
        if (Auth::attempt($credentials, $remember)) {
            // Kullanıcı admin mi kontrol et
            if (!Auth::user()->is_admin) {
                Auth::logout();

                throw ValidationException::withMessages([
                    'email' => 'Bu hesabın admin yetkisi bulunmamaktadır.',
                ]);
            }

            $request->session()->regenerate();

            return redirect()->intended(route('admin.dashboard'))
                ->with('success', 'Hoş geldiniz, ' . Auth::user()->name . '!');
        }

        throw ValidationException::withMessages([
            'email' => 'Girdiğiniz bilgiler hatalı. Lütfen tekrar deneyin.',
        ]);
    }

    /**
     * Admin logout işlemi
     */
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('admin.login')
            ->with('success', 'Başarıyla çıkış yaptınız.');
    }
}
