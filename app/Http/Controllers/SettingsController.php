<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Artisan;

class SettingsController extends Controller
{
    /**
     * Genel ayarlar ana sayfa
     */
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('settings.index', compact('settings'));
    }

    /**
     * Genel ayarları kaydet
     */
    public function updateGeneral(Request $request)
    {
        $validated = $request->validate([
            'company_name' => 'nullable|string|max:255',
            'company_address' => 'nullable|string|max:500',
            'company_phone' => 'nullable|string|max:20',
            'company_email' => 'nullable|email|max:255',
            'company_tax_office' => 'nullable|string|max:100',
            'company_tax_number' => 'nullable|string|max:20',
            'timezone' => 'nullable|string|max:50',
            'date_format' => 'nullable|string|max:20',
            'currency' => 'nullable|string|max:10',
        ]);

        try {
            foreach ($validated as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value]
                );
            }

            return back()->with('success', 'Genel ayarlar başarıyla güncellendi.');

        } catch (\Exception $e) {
            return back()->with('error', 'Ayarlar güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Kullanıcı yönetimi
     */
    public function users()
    {
        $users = User::orderBy('name')->paginate(20);

        return view('settings.users', compact('users'));
    }

    /**
     * Yeni kullanıcı oluştur
     */
    public function storeUser(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => ['required', 'confirmed', Password::min(8)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,manager,agent',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            $validated['password'] = Hash::make($validated['password']);
            $validated['is_active'] = $request->boolean('is_active', true);

            User::create($validated);

            return back()->with('success', 'Kullanıcı başarıyla eklendi.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Kullanıcı eklenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Kullanıcı güncelle
     */
    public function updateUser(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => ['nullable', 'confirmed', Password::min(8)],
            'phone' => 'nullable|string|max:20',
            'role' => 'required|in:admin,manager,agent',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            if ($request->filled('password')) {
                $validated['password'] = Hash::make($validated['password']);
            } else {
                unset($validated['password']);
            }

            $validated['is_active'] = $request->boolean('is_active', true);

            $user->update($validated);

            return back()->with('success', 'Kullanıcı başarıyla güncellendi.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Kullanıcı güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Kullanıcı sil
     */
    public function destroyUser(User $user)
    {
        // Kendi hesabını silemesin
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Kendi hesabınızı silemezsiniz.');
        }

        try {
            $user->delete();

            return back()->with('success', 'Kullanıcı başarıyla silindi.');

        } catch (\Exception $e) {
            return back()->with('error', 'Kullanıcı silinirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Profil ayarları
     */
    public function profile()
    {
        $user = auth()->user();

        return view('settings.profile', compact('user'));
    }

    /**
     * Profil güncelle
     */
    public function updateProfile(Request $request)
    {
        $user = auth()->user();

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
            'avatar' => 'nullable|image|mimes:jpeg,jpg,png,gif|max:2048',
        ]);

        try {
            // Avatar yükleme
            if ($request->hasFile('avatar')) {
                // Eski avatar'ı sil
                if ($user->avatar) {
                    Storage::disk('public')->delete($user->avatar);
                }

                $avatarPath = $request->file('avatar')->store('avatars', 'public');
                $validated['avatar'] = $avatarPath;
            }

            $user->update($validated);

            return back()->with('success', 'Profil bilgileri başarıyla güncellendi.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Profil güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Şifre değiştir
     */
    public function updatePassword(Request $request)
    {
        $validated = $request->validate([
            'current_password' => 'required',
            'password' => ['required', 'confirmed', Password::min(8)],
        ]);

        try {
            $user = auth()->user();

            // Mevcut şifreyi kontrol et
            if (!Hash::check($validated['current_password'], $user->password)) {
                return back()->with('error', 'Mevcut şifre hatalı.');
            }

            $user->update([
                'password' => Hash::make($validated['password'])
            ]);

            return back()->with('success', 'Şifre başarıyla değiştirildi.');

        } catch (\Exception $e) {
            return back()->with('error', 'Şifre değiştirilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Güvenlik ayarları
     */
    public function security()
    {
        $settings = Setting::pluck('value', 'key')->toArray();

        return view('settings.security', compact('settings'));
    }

    /**
     * Güvenlik ayarlarını kaydet
     */
    public function updateSecurity(Request $request)
    {
        $validated = $request->validate([
            'session_timeout' => 'nullable|integer|min:5|max:1440',
            'password_expiry_days' => 'nullable|integer|min:0|max:365',
            'max_login_attempts' => 'nullable|integer|min:3|max:10',
            'two_factor_enabled' => 'nullable|boolean',
            'force_password_change' => 'nullable|boolean',
        ]);

        try {
            foreach ($validated as $key => $value) {
                Setting::updateOrCreate(
                    ['key' => $key],
                    ['value' => $value ?? 0]
                );
            }

            return back()->with('success', 'Güvenlik ayarları başarıyla güncellendi.');

        } catch (\Exception $e) {
            return back()->with('error', 'Ayarlar güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Önbellek temizle
     */
    public function clearCache()
    {
        try {
            Artisan::call('cache:clear');
            Artisan::call('config:clear');
            Artisan::call('route:clear');
            Artisan::call('view:clear');

            return back()->with('success', 'Önbellek başarıyla temizlendi.');

        } catch (\Exception $e) {
            return back()->with('error', 'Önbellek temizlenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Veritabanı yedekleme (placeholder)
     */
    public function backup()
    {
        try {
            // TODO: Veritabanı yedekleme işlemi
            // spatie/laravel-backup paketi kullanılabilir

            return back()->with('info', 'Yedekleme özelliği yakında eklenecek.');

        } catch (\Exception $e) {
            return back()->with('error', 'Yedekleme sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }
}
