<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\DemoUser;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class DemoController extends Controller
{
    /**
     * Demo kayıt formu
     */
    public function showForm()
    {
        return view('web.demo.form');
    }

    /**
     * Demo kayıt işlemi (DB Transaction ile güvenli)
     */
    public function register(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'required|string|max:255',
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email',
            'phone' => 'required|string|max:20',
            'password' => 'required|string|min:8|confirmed',
            'city' => 'nullable|string|max:100',
            'message' => 'nullable|string|max:1000',
            'terms' => 'required|accepted',
        ], [
            'company_name.required' => 'Firma adı gereklidir.',
            'full_name.required' => 'Ad soyad gereklidir.',
            'email.required' => 'E-posta adresi gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'email.unique' => 'Bu e-posta adresi ile zaten bir kayıt bulunmaktadır.',
            'phone.required' => 'Telefon numarası gereklidir.',
            'password.required' => 'Şifre gereklidir.',
            'password.min' => 'Şifre en az 8 karakter olmalıdır.',
            'password.confirmed' => 'Şifreler eşleşmiyor.',
            'terms.required' => 'Kullanım koşullarını kabul etmelisiniz.',
            'terms.accepted' => 'Kullanım koşullarını kabul etmelisiniz.',
        ]);

        DB::beginTransaction();

        try {
            // 1. User oluştur
            $user = User::create([
                'name' => $validated['full_name'],
                'email' => $validated['email'],
                'password' => Hash::make($validated['password']),
                'role' => 'admin',
            ]);

            // 2. Demo user kaydı oluştur - 14 GÜN DENEME
            $demoUser = DemoUser::create([
                'company_name' => $validated['company_name'],
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'],
                'city' => $validated['city'] ?? null,
                'message' => $validated['message'] ?? null,
                'user_id' => $user->id,
                'trial_ends_at' => now()->addDays(14),
                'ip_address' => $request->ip(),
            ]);

            // 3. Transaction'ı başarılı olarak tamamla
            DB::commit();

            // 4. Otomatik giriş yap
            Auth::login($user);

            // TODO: E-posta gönder (hoş geldin mesajı)
            // try {
            //     Mail::to($user->email)->send(new DemoWelcomeMail($user));
            // } catch (\Exception $mailException) {
            //     Log::warning('Demo welcome email failed: ' . $mailException->getMessage());
            // }

            // 5. Dashboard'a yönlendir
            return redirect()->route('dashboard')
                ->with('success', 'Hoş geldiniz! Demo hesabınız başarıyla oluşturuldu. 14 gün boyunca tüm özellikleri ücretsiz kullanabilirsiniz.');

        } catch (\Exception $e) {
            // Transaction'ı geri al
            DB::rollBack();

            // Hatayı logla
            Log::error('Demo registration error: ' . $e->getMessage(), [
                'email' => $validated['email'] ?? null,
                'trace' => $e->getTraceAsString(),
            ]);

            // Kullanıcıya genel hata mesajı göster
            return back()
                ->withInput($request->except('password', 'password_confirmation'))
                ->with('error', 'Kayıt oluşturulurken bir hata oluştu. Lütfen tekrar deneyin veya destek ekibiyle iletişime geçin.');
        }
    }

    /**
     * Demo süresi doldu sayfası
     */
    public function expired()
    {
        $user = Auth::user();
        $demoUser = DemoUser::where('user_id', $user->id)->first();

        // İstatistikler (örnek - TODO: Gerçek veriyi al)
        $stats = [
            'customers' => 0,
            'policies' => 0,
            'payments' => 0,
            'days_used' => $demoUser ? now()->diffInDays($demoUser->created_at) : 14,
        ];

        return view('web.demo.expired', compact('stats'));
    }
}
