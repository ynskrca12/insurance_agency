<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Controller;
use App\Models\DemoUser;
use App\Models\User;
use Illuminate\Http\Request;

class DemoUserController extends Controller
{
    /**
     * Demo kullanıcı listesi
     */
    public function index(Request $request)
    {
        $query = DemoUser::with('user');

        // Arama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('company_name', 'LIKE', "%{$search}%")
                  ->orWhere('full_name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('phone', 'LIKE', "%{$search}%");
            });
        }

        // Durum filtresi
        if ($request->filled('status')) {
            if ($request->status === 'active') {
                $query->where('trial_ends_at', '>', now());
            } elseif ($request->status === 'expired') {
                $query->where('trial_ends_at', '<=', now());
            }
        }

        // Sıralama
        $query->latest();

        $demoUsers = $query->paginate(20);

        // İstatistikler
        $stats = [
            'total' => DemoUser::count(),
            'active' => DemoUser::where('trial_ends_at', '>', now())->count(),
            'expired' => DemoUser::where('trial_ends_at', '<=', now())->count(),
            'today' => DemoUser::whereDate('created_at', today())->count(),
        ];

        return view('admin.demo-users.index', compact('demoUsers', 'stats'));
    }

    /**
     * Demo kullanıcı detay
     */
    public function show(DemoUser $demoUser)
    {
        $demoUser->load('user');

        // Kullanıcı istatistikleri
        if ($demoUser->user) {
            $stats = [
                'customers' => \App\Models\Customer::where('tenant_id', $demoUser->user_id)->count(),
                'policies' => \App\Models\Policy::where('tenant_id', $demoUser->user_id)->count() ?? 0,
                'quotations' => \App\Models\Quotation::where('tenant_id', $demoUser->user_id)->count() ?? 0,
                'payments' => \App\Models\Payment::where('tenant_id', $demoUser->user_id)->count() ?? 0,
            ];
        } else {
            $stats = [
                'customers' => 0,
                'policies' => 0,
                'quotations' => 0,
                'payments' => 0,
            ];
        }

        return view('admin.demo-users.show', compact('demoUser', 'stats'));
    }

    /**
     * Demo süre uzatma/kısaltma
     */
    public function updateTrial(Request $request, DemoUser $demoUser)
    {
        $validated = $request->validate([
            'trial_ends_at' => 'required|date|after:now',
        ], [
            'trial_ends_at.required' => 'Süre bitiş tarihi gereklidir.',
            'trial_ends_at.date' => 'Geçerli bir tarih giriniz.',
            'trial_ends_at.after' => 'Bitiş tarihi gelecekte olmalıdır.',
        ]);

        $demoUser->update([
            'trial_ends_at' => $validated['trial_ends_at'],
        ]);

        return back()->with('success', 'Demo süresi başarıyla güncellendi.');
    }

    /**
     * Demo kullanıcı silme
     */
    public function destroy(DemoUser $demoUser)
    {
        // Önce user'ı sil (cascade ile tüm veriler silinir)
        if ($demoUser->user) {
            $demoUser->user->delete();
        }

        $demoUser->delete();

        return redirect()->route('admin.demo-users.index')
            ->with('success', 'Demo kullanıcı ve tüm verileri başarıyla silindi.');
    }

    /**
     * User'ı deaktif et
     */
    public function deactivate(DemoUser $demoUser)
    {
        if ($demoUser->user) {
            // Demo süresini şimdi yap (süresi dolmuş olsun)
            $demoUser->update([
                'trial_ends_at' => now()->subDay(),
            ]);
        }

        return back()->with('success', 'Demo hesabı deaktif edildi.');
    }

    /**
     * User'ı aktif et
     */
    public function activate(DemoUser $demoUser)
    {
        if ($demoUser->user) {
            // Demo süresini 14 gün uzat
            $demoUser->update([
                'trial_ends_at' => now()->addDays(14),
            ]);
        }

        return back()->with('success', 'Demo hesabı aktif edildi (14 gün uzatıldı).');
    }
}
