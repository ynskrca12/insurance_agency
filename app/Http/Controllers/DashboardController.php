<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Policy;
use App\Models\Task;
use App\Models\Payment;
use App\Models\Installment;
use App\Models\Tahsilat;
use App\Models\CariHesap;
use App\Models\PolicyRenewal;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Dashboard sayfası
     */
    public function index()
    {
        $user = auth()->user();

        // İstatistikler
        $stats = [
            'total_customers' => Customer::count(),
            'total_policies' => Policy::count(),
            'active_policies' => Policy::active()->count(),
            'expiring_soon' => Policy::expiringSoon()->count(),
            'pending_tasks' => Task::pending()->count(),
            'overdue_tasks' => Task::overdue()->count(),
        ];

        // 📊 Bugünün Özeti
        $todaySummary = $this->getTodaySummary();

        // 📈 Aylık Performans
        $monthlyPerformance = $this->getMonthlyPerformance();

        // 📊 Son 7 Gün Trendi
        $weeklyTrend = $this->getWeeklyTrend();

        // 🔔 Kritik Uyarılar
        $criticalAlerts = $this->getCriticalAlerts();

        // 📞 Bugün Aranacaklar
        $todayCallList = $this->getTodayCallList();

        // Son müşteriler
        $recentCustomers = Customer::with('createdBy')
            ->latest()
            ->take(5)
            ->get();

        // Süresi yaklaşan poliçeler
        $expiringPolicies = Policy::with(['customer', 'insuranceCompany'])
            ->expiringSoon()
            ->orderBy('end_date')
            ->take(10)
            ->get();

        // Bugünkü görevler
        $todayTasks = Task::with(['assignedTo'])
            ->dueToday()
            ->orderBy('priority', 'desc')
            ->get();

        // Ödeme İstatistikleri
        $paymentStats = [
            'today_payments' => $this->safeSum(Payment::class, 'today', 'completed'),
            'month_payments' => $this->safeSum(Payment::class, 'thisMonth', 'completed'),
        ];

        // Cari Durum
        $cariDurum = $this->getCariDurum();

        return view('dashboard', compact(
            'stats',
            'todaySummary',
            'monthlyPerformance',
            'weeklyTrend',
            'criticalAlerts',
            'todayCallList',
            'recentCustomers',
            'expiringPolicies',
            'todayTasks',
            'paymentStats',
            'cariDurum',
            'user'
        ));
    }

    /**
     * 📊 Bugünün Özeti
     */
    private function getTodaySummary()
    {
        $today = now()->format('Y-m-d');

        // Bugünkü yeni poliçeler
        $todayPolicies = Policy::whereDate('created_at', $today)->count();
        $todayPremium = Policy::whereDate('created_at', $today)->sum('premium_amount');

        // Bugünkü tahsilatlar
        $todayCollections = Tahsilat::whereDate('tahsilat_tarihi', $today)->sum('tutar');

        // Bugünkü yeni müşteriler
        $todayCustomers = Customer::whereDate('created_at', $today)->count();

        // Bugün biten poliçeler
        $expiresToday = Policy::whereDate('end_date', $today)->count();

        // Günlük hedef (örnek - kullanıcı bazlı hedef sistemi eklenebilir)
        $dailyTarget = 10000; // 10.000₺ günlük hedef
        $targetProgress = $dailyTarget > 0 ? ($todayPremium / $dailyTarget) * 100 : 0;

        return [
            'policies' => $todayPolicies,
            'premium' => $todayPremium,
            'collections' => $todayCollections,
            'customers' => $todayCustomers,
            'expires_today' => $expiresToday,
            'daily_target' => $dailyTarget,
            'target_progress' => min(100, $targetProgress),
        ];
    }

    /**
     * 📈 Aylık Performans
     */
    private function getMonthlyPerformance()
    {
        $startOfMonth = now()->startOfMonth();
        $endOfMonth = now();

        // Bu ay
        $thisMonthPolicies = Policy::whereBetween('created_at', [$startOfMonth, $endOfMonth])->count();
        $thisMonthPremium = Policy::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('premium_amount');
        $thisMonthCommission = Policy::whereBetween('created_at', [$startOfMonth, $endOfMonth])->sum('commission_amount');
        $thisMonthCollections = Tahsilat::whereBetween('tahsilat_tarihi', [$startOfMonth, $endOfMonth])->sum('tutar');

        // Geçen ay
        $lastMonthStart = now()->subMonth()->startOfMonth();
        $lastMonthEnd = now()->subMonth()->endOfMonth();

        $lastMonthPolicies = Policy::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->count();
        $lastMonthPremium = Policy::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->sum('premium_amount');

        // Hedefler (örnek - kullanıcı bazlı hedef sistemi eklenebilir)
        $monthlyPolicyTarget = 50; // 50 poliçe hedefi
        $monthlyPremiumTarget = 200000; // 200.000₺ prim hedefi

        return [
            'policies' => $thisMonthPolicies,
            'policy_target' => $monthlyPolicyTarget,
            'policy_progress' => $monthlyPolicyTarget > 0 ? ($thisMonthPolicies / $monthlyPolicyTarget) * 100 : 0,

            'premium' => $thisMonthPremium,
            'premium_target' => $monthlyPremiumTarget,
            'premium_progress' => $monthlyPremiumTarget > 0 ? ($thisMonthPremium / $monthlyPremiumTarget) * 100 : 0,

            'commission' => $thisMonthCommission,
            'collections' => $thisMonthCollections,

            'policy_change' => $lastMonthPolicies > 0 ? (($thisMonthPolicies - $lastMonthPolicies) / $lastMonthPolicies) * 100 : 0,
            'premium_change' => $lastMonthPremium > 0 ? (($thisMonthPremium - $lastMonthPremium) / $lastMonthPremium) * 100 : 0,
        ];
    }

    /**
     * 📊 Son 7 Gün Trendi
     */
    private function getWeeklyTrend()
    {
        $days = [];
        for ($i = 6; $i >= 0; $i--) {
            $days[] = now()->subDays($i)->format('Y-m-d');
        }

        return collect($days)->map(function($day) {
            $date = \Carbon\Carbon::parse($day);

            return [
                'date' => $date->format('d M'),
                'policies' => Policy::whereDate('created_at', $day)->count(),
                'premium' => Policy::whereDate('created_at', $day)->sum('premium_amount'),
                'collections' => Tahsilat::whereDate('tahsilat_tarihi', $day)->sum('tutar'),
            ];
        });
    }

    /**
     * 🔔 Kritik Uyarılar
     */
    private function getCriticalAlerts()
    {
        $alerts = [];

        // Bugün biten poliçeler
        $expiresToday = Policy::whereDate('end_date', now())
            ->with('customer')
            ->get();

        if ($expiresToday->count() > 0) {
            $alerts[] = [
                'type' => 'danger',
                'icon' => 'bi-exclamation-triangle-fill',
                'title' => 'Bugün Biten Poliçeler',
                'message' => $expiresToday->count() . ' poliçe bugün sona eriyor!',
                'link' => '#',
                'count' => $expiresToday->count(),
            ];
        }

        // 7 gün içinde bitenler
        $expiringWeek = Policy::whereBetween('end_date', [now(), now()->addDays(7)])
            ->count();

        if ($expiringWeek > 0) {
            $alerts[] = [
                'type' => 'warning',
                'icon' => 'bi-clock-history',
                'title' => '7 Gün İçinde Biten Poliçeler',
                'message' => $expiringWeek . ' poliçe 7 gün içinde bitiyor',
                'link' => route('policies.index', ['status' => 'expiring_soon']),
                'count' => $expiringWeek,
            ];
        }

        // Vade geçmiş alacaklar
        $overdueReceivables = \App\Models\CariHareket::where('islem_tipi', 'borc')
            ->where('vade_tarihi', '<', now())
            ->whereNull('karsi_cari_hesap_id')
            ->whereHas('cariHesap', function($q) {
                $q->where('tip', 'musteri');
            })
            ->sum('tutar');

        if ($overdueReceivables > 0) {
            $alerts[] = [
                'type' => 'danger',
                'icon' => 'bi-credit-card-2-front',
                'title' => 'Vade Geçmiş Alacaklar',
                'message' => number_format($overdueReceivables, 2) . '₺ vadesi geçmiş borç',
                'link' => route('cari-hesaplar.yasilandirma', ['tip' => 'musteri']),
                'count' => null,
            ];
        }

        // Bekleyen yenilemeler
        $pendingRenewals = PolicyRenewal::where('status', 'pending')
            ->where('renewal_date', '<=', now()->addDays(30))
            ->count();

        if ($pendingRenewals > 0) {
            $alerts[] = [
                'type' => 'info',
                'icon' => 'bi-arrow-repeat',
                'title' => 'Bekleyen Yenilemeler',
                'message' => $pendingRenewals . ' poliçe yenileme bekliyor',
                'link' => route('renewals.index', ['status' => 'pending']),
                'count' => $pendingRenewals,
            ];
        }

        return collect($alerts);
    }

    /**
     * 📞 Bugün Aranacaklar
     */
    private function getTodayCallList()
    {
        // Bugün süresi bitenler
        $expiringToday = Policy::whereDate('end_date', now())
            ->with('customer')
            ->limit(5)
            ->get()
            ->map(function($policy) {
                return [
                    'customer' => $policy->customer,
                    'reason' => 'Poliçe bugün bitiyor',
                    'priority' => 'high',
                    'policy' => $policy,
                ];
            });

        // 7 gün içinde bitenler
        $expiringSoon = Policy::whereBetween('end_date', [now()->addDay(), now()->addDays(7)])
            ->with('customer')
            ->limit(5)
            ->get()
            ->map(function($policy) {
                return [
                    'customer' => $policy->customer,
                    'reason' => 'Poliçe ' . $policy->end_date->diffForHumans() . ' bitiyor',
                    'priority' => 'medium',
                    'policy' => $policy,
                ];
            });

        return $expiringToday->merge($expiringSoon)->take(10);
    }

    /**
     * Cari Durum
     */
    private function getCariDurum()
    {
        $musteriCariToplam = CariHesap::where('tip', 'musteri')
            ->sum('bakiye');

        $sirketCariToplam = CariHesap::where('tip', 'sirket')
            ->sum('bakiye');

        $kasaBankaToplam = CariHesap::whereIn('tip', ['kasa', 'banka'])
            ->sum('bakiye');

        $vadeGecmisMusteriler = \App\Models\CariHareket::where('islem_tipi', 'borc')
            ->where('vade_tarihi', '<', now())
            ->whereNull('karsi_cari_hesap_id')
            ->whereHas('cariHesap', function($q) {
                $q->where('tip', 'musteri');
            })
            ->sum('tutar');

        $bugunTahsilatlar = Tahsilat::whereDate('tahsilat_tarihi', today())
            ->sum('tutar');

        $bugunOdemeler = \App\Models\SirketOdeme::whereDate('odeme_tarihi', today())
            ->sum('tutar');

        return [
            'musteri_alacak' => $musteriCariToplam,
            'sirket_borc' => $sirketCariToplam,
            'kasa_banka' => $kasaBankaToplam,
            'vade_gecmis' => $vadeGecmisMusteriler,
            'bugun_tahsilat' => $bugunTahsilatlar,
            'bugun_odeme' => $bugunOdemeler,
        ];
    }

    /**
     * Güvenli sum hesaplama
     */
    private function safeSum($model, $scope, $status = null)
    {
        try {
            $query = $model::$scope();

            if ($status && Schema::hasColumn((new $model)->getTable(), 'status')) {
                $query->where('status', $status);
            }

            return $query->sum('amount') ?? 0;
        } catch (\Exception $e) {
            return 0;
        }
    }
}
