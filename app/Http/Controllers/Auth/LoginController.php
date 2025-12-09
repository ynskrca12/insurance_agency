<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /**
     * Login formunu göster
     */
    public function showLoginForm()
    {
        return view('auth.login');
    }

    /**
     * Login işlemini yap
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required|min:6',
        ], [
            'email.required' => 'E-posta adresi gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'password.required' => 'Şifre gereklidir.',
            'password.min' => 'Şifre en az 6 karakter olmalıdır.',
        ]);

        $credentials = $request->only('email', 'password');
        $remember = $request->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $request->session()->regenerate();

            // Son giriş bilgisini güncelle
            auth()->user()->update([
                'last_login_at' => now(),
                'last_login_ip' => $request->ip(),
            ]);

            return redirect()->intended(route('dashboard'))
                ->with('success', 'Hoş geldiniz, ' . auth()->user()->name);
        }

        return back()->withErrors([
            'email' => 'E-posta veya şifre hatalı.',
        ])->withInput($request->only('email'));
    }
}
