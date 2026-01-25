<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\PolicyRenewal;
use App\Models\InsuranceCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class ReportController extends Controller
{
    /**
     * Rapor ana sayfa
     */
    public function index()
    {
        return view('reports.index');
    }

   /**
 * Satış raporları
 */
public function sales(Request $request)
{
    // Varsayılan olarak TÜM VERİLER (filtresiz)
    $startDate = $request->get('start_date', null);
    $endDate = $request->get('end_date', null);
    $groupBy = $request->get('group_by', 'month'); // Varsayılan aylık

    // Eğer tarih belirtilmemişse, tüm zamanlar
    $query = Policy::query();

    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    } elseif ($startDate) {
        $query->where('created_at', '>=', $startDate);
    } elseif ($endDate) {
        $query->where('created_at', '<=', $endDate);
    }

    // Display için tarih formatı
    if (!$startDate || !$endDate) {
        // İlk ve son poliçe tarihlerini al
        $firstPolicy = Policy::orderBy('created_at', 'asc')->first();
        $lastPolicy = Policy::orderBy('created_at', 'desc')->first();

        $displayStartDate = $firstPolicy ? $firstPolicy->created_at->format('Y-m-d') : now()->subYear()->format('Y-m-d');
        $displayEndDate = $lastPolicy ? $lastPolicy->created_at->format('Y-m-d') : now()->format('Y-m-d');
    } else {
        $displayStartDate = $startDate;
        $displayEndDate = $endDate;
    }

    // Genel İstatistikler
    $statsQuery = clone $query;
    $stats = [
        'total_policies' => $statsQuery->count(),
        'total_premium' => $statsQuery->sum('premium_amount') ?? 0,
        'total_commission' => $statsQuery->sum('commission_amount') ?? 0,
        'average_premium' => $statsQuery->avg('premium_amount') ?? 0,
    ];

    // Poliçe türüne göre dağılım
    $policyTypeQuery = clone $query;
    $policyTypeDistribution = $policyTypeQuery
        ->select('policy_type', DB::raw('COUNT(*) as count'), DB::raw('SUM(premium_amount) as total_premium'))
        ->groupBy('policy_type')
        ->orderByDesc('count')
        ->get();

    // Sigorta şirketine göre dağılım
    $companyQuery = clone $query;
    $companyDistribution = $companyQuery
        ->with('insuranceCompany')
        ->select('insurance_company_id', DB::raw('COUNT(*) as count'), DB::raw('SUM(premium_amount) as total_premium'))
        ->groupBy('insurance_company_id')
        ->orderByDesc('total_premium')
        ->get();

    // Zaman serisi verileri (Grafik için)
    $timeSeriesData = $this->getTimeSeriesData(
        $startDate ?? $displayStartDate,
        $endDate ?? $displayEndDate,
        $groupBy
    );

    // En iyi performans gösteren poliçe türleri
    $topPolicyTypesQuery = clone $query;
    $topPolicyTypes = $topPolicyTypesQuery
        ->select('policy_type', DB::raw('COUNT(*) as count'), DB::raw('SUM(premium_amount) as total_premium'))
        ->groupBy('policy_type')
        ->orderByDesc('total_premium')
        ->limit(6)
        ->get();

    //  Satış temsilcisi performansı
    $salesRepPerformance = $this->getSalesRepPerformance($startDate, $endDate);

    //  Branş bazlı detaylı analiz
    $branchAnalysis = $this->getBranchAnalysis($startDate, $endDate);

    return view('reports.sales', compact(
        'stats',
        'policyTypeDistribution',
        'companyDistribution',
        'timeSeriesData',
        'topPolicyTypes',
        'salesRepPerformance',
        'branchAnalysis',
        'startDate',
        'endDate',
        'groupBy'
    ))->with([
        'displayStartDate' => $displayStartDate,
        'displayEndDate' => $displayEndDate,
    ]);
}

/**
 * Satış temsilcisi performans analizi
 */
private function getSalesRepPerformance($startDate, $endDate)
{
    $query = Policy::with('creator');

    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    } elseif ($startDate) {
        $query->where('created_at', '>=', $startDate);
    } elseif ($endDate) {
        $query->where('created_at', '<=', $endDate);
    }

    return $query->select(
            'created_by',
            DB::raw('COUNT(*) as policy_count'),
            DB::raw('SUM(premium_amount) as total_premium'),
            DB::raw('SUM(commission_amount) as total_commission'),
            DB::raw('AVG(premium_amount) as avg_premium')
        )
        ->groupBy('created_by')
        ->orderByDesc('total_premium')
        ->limit(10)
        ->get();
}

/**
 * Branş bazlı detaylı analiz
 */
private function getBranchAnalysis($startDate, $endDate)
{
    $query = Policy::query();

    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    } elseif ($startDate) {
        $query->where('created_at', '>=', $startDate);
    } elseif ($endDate) {
        $query->where('created_at', '<=', $endDate);
    }

    return $query->select(
            'policy_type',
            DB::raw('COUNT(*) as policy_count'),
            DB::raw('SUM(premium_amount) as total_premium'),
            DB::raw('SUM(commission_amount) as total_commission'),
            DB::raw('AVG(premium_amount) as avg_premium'),
            DB::raw('AVG(commission_rate) as avg_commission_rate')
        )
        ->groupBy('policy_type')
        ->orderByDesc('total_premium')
        ->get();
}

    /**
     * Zaman serisi verilerini hazırla
     */
    private function getTimeSeriesData($startDate, $endDate, $groupBy)
    {
        $query = Policy::whereBetween('created_at', [$startDate, $endDate]);

        switch ($groupBy) {
            case 'day':
                $data = $query->selectRaw('DATE(created_at) as period, COUNT(*) as policy_count, SUM(premium_amount) as total_premium')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get()
                    ->map(function($item) {
                        $item->period = \Carbon\Carbon::parse($item->period)->format('d.m.Y');
                        return $item;
                    });
                break;

            case 'week':
                $data = $query->selectRaw('YEARWEEK(created_at, 1) as yearweek, MIN(DATE(created_at)) as period, COUNT(*) as policy_count, SUM(premium_amount) as total_premium')
                    ->groupBy('yearweek')
                    ->orderBy('yearweek')
                    ->get()
                    ->map(function($item) {
                        $item->period = \Carbon\Carbon::parse($item->period)->format('d.m.Y') . ' - Hafta';
                        return $item;
                    });
                break;

            case 'month':
                $data = $query->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as period, COUNT(*) as policy_count, SUM(premium_amount) as total_premium')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get()
                    ->map(function($item) {
                        $months = [
                            '01' => 'Oca', '02' => 'Şub', '03' => 'Mar', '04' => 'Nis',
                            '05' => 'May', '06' => 'Haz', '07' => 'Tem', '08' => 'Ağu',
                            '09' => 'Eyl', '10' => 'Eki', '11' => 'Kas', '12' => 'Ara'
                        ];
                        $parts = explode('-', $item->period);
                        $item->period = $months[$parts[1]] . ' ' . $parts[0];
                        return $item;
                    });
                break;

            case 'year':
                $data = $query->selectRaw('YEAR(created_at) as period, COUNT(*) as policy_count, SUM(premium_amount) as total_premium')
                    ->groupBy('period')
                    ->orderBy('period')
                    ->get();
                break;

            default:
                $data = collect();
        }

        return $data;
    }

/**
 * Komisyon raporları (CARİ ENTEGRASYONLU)
 */
public function commission(Request $request)
{
    $startDate = $request->get('start_date', null);
    $endDate = $request->get('end_date', null);

    // Ana sorgu
    $query = Policy::query();

    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    } elseif ($startDate) {
        $query->where('created_at', '>=', $startDate);
    } elseif ($endDate) {
        $query->where('created_at', '<=', $endDate);
    }

    // Display için tarih formatı
    if (!$startDate || !$endDate) {
        $firstPolicy = Policy::orderBy('created_at', 'asc')->first();
        $lastPolicy = Policy::orderBy('created_at', 'desc')->first();

        $displayStartDate = $firstPolicy ? $firstPolicy->created_at->format('Y-m-d') : now()->subYear()->format('Y-m-d');
        $displayEndDate = $lastPolicy ? $lastPolicy->created_at->format('Y-m-d') : now()->format('Y-m-d');
    } else {
        $displayStartDate = $startDate;
        $displayEndDate = $endDate;
    }

    // Genel İstatistikler
    $statsQuery = clone $query;
    $totalCommission = $statsQuery->sum('commission_amount') ?? 0;
    $totalPolicies = $statsQuery->count();
    $averageCommission = $statsQuery->avg('commission_amount') ?? 0;

    // Tahsil edilen komisyon
    $collectedCommission = $this->getCollectedCommission($startDate, $endDate);
    $pendingCommission = max(0, $totalCommission - $collectedCommission);
    $collectionRate = $totalCommission > 0 ? ($collectedCommission / $totalCommission) * 100 : 0;

    // Komisyon oranı hesapla
    $totalPremiumQuery = clone $query;
    $totalPremium = $totalPremiumQuery->sum('premium_amount') ?? 0;
    $commissionRate = $totalPremium > 0 ? ($totalCommission / $totalPremium) * 100 : 0;

    $stats = [
        'total_commission' => $totalCommission,
        'collected_commission' => $collectedCommission,
        'pending_commission' => $pendingCommission,
        'collection_rate' => $collectionRate,
        'total_policies' => $totalPolicies,
        'average_commission' => $averageCommission,
        'commission_rate' => $commissionRate,
    ];

    // Satış temsilcisi komisyon performansı
    $salesRepCommission = $this->getSalesRepCommission($startDate, $endDate);

    // Sigorta şirketine göre komisyon
    $commissionByCompany = $this->getCommissionByCompany($startDate, $endDate);

    // Poliçe türüne göre komisyon
    $typeQuery = clone $query;
    $commissionByType = $typeQuery
        ->select(
            'policy_type',
            DB::raw('COUNT(*) as policy_count'),
            DB::raw('SUM(premium_amount) as total_premium'),
            DB::raw('SUM(commission_amount) as total_commission')
        )
        ->groupBy('policy_type')
        ->orderByDesc('total_commission')
        ->get();

    // Aylık komisyon trendi
    $monthlyQuery = clone $query;
    $monthlyCommission = $monthlyQuery
        ->select(
            DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
            DB::raw('SUM(commission_amount) as total_commission'),
            DB::raw('COUNT(*) as policy_count')
        )
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->map(function($item) {
            $months = [
                '01' => 'Oca', '02' => 'Şub', '03' => 'Mar', '04' => 'Nis',
                '05' => 'May', '06' => 'Haz', '07' => 'Tem', '08' => 'Ağu',
                '09' => 'Eyl', '10' => 'Eki', '11' => 'Kas', '12' => 'Ara'
            ];
            $parts = explode('-', $item->month);
            $item->month = $months[$parts[1]] . ' ' . $parts[0];
            return $item;
        });

    return view('reports.commission', compact(
        'stats',
        'salesRepCommission',
        'commissionByCompany',
        'commissionByType',
        'monthlyCommission',
        'startDate',
        'endDate'
    ))->with([
        'displayStartDate' => $displayStartDate,
        'displayEndDate' => $displayEndDate,
    ]);
}

/**
 *  Tahsil edilen komisyon hesapla
 */
private function getCollectedCommission($startDate, $endDate)
{
    $query = \App\Models\Tahsilat::query();

    if ($startDate && $endDate) {
        $query->whereBetween('tahsilat_tarihi', [$startDate, $endDate]);
    } elseif ($startDate) {
        $query->where('tahsilat_tarihi', '>=', $startDate);
    } elseif ($endDate) {
        $query->where('tahsilat_tarihi', '<=', $endDate);
    }

    // Poliçelere yapılan tahsilatları topla
    return $query->whereNotNull('policy_id')
                 ->with('policy')
                 ->get()
                 ->sum(function($tahsilat) {
                     if (!$tahsilat->policy) return 0;

                     // Tahsilat oranına göre komisyon hesapla
                     $policyPremium = $tahsilat->policy->premium_amount;
                     $policyCommission = $tahsilat->policy->commission_amount;

                     if ($policyPremium > 0) {
                         $tahsilatOrani = $tahsilat->tutar / $policyPremium;
                         return $policyCommission * $tahsilatOrani;
                     }

                     return 0;
                 });
}



/**
 *  Satış temsilcisi komisyon performansı
 */
private function getSalesRepCommission($startDate, $endDate)
{
    $query = Policy::with('creator');

    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    } elseif ($startDate) {
        $query->where('created_at', '>=', $startDate);
    } elseif ($endDate) {
        $query->where('created_at', '<=', $endDate);
    }

    $salesReps = $query->select(
            'created_by',
            DB::raw('COUNT(*) as policy_count'),
            DB::raw('SUM(commission_amount) as total_commission'),
            DB::raw('AVG(commission_rate) as avg_commission_rate')
        )
        ->groupBy('created_by')
        ->orderByDesc('total_commission')
        ->limit(10)
        ->get();

    // Her temsilci için tahsilat oranını hesapla
    foreach ($salesReps as $rep) {
        $repPolicies = Policy::where('created_by', $rep->created_by);

        if ($startDate && $endDate) {
            $repPolicies->whereBetween('created_at', [$startDate, $endDate]);
        }

        $policyIds = $repPolicies->pluck('id');

        $collectedAmount = \App\Models\Tahsilat::whereIn('policy_id', $policyIds)
            ->sum('tutar');

        $totalPremium = $repPolicies->sum('premium_amount');

        $rep->collection_rate = $totalPremium > 0
            ? ($collectedAmount / $totalPremium) * 100
            : 0;
    }

    return $salesReps;
}

/**
 * Şirket bazlı genişletilmiş komisyon analizi
 */
private function getCommissionByCompany($startDate, $endDate)
{
    $query = Policy::with('insuranceCompany');

    if ($startDate && $endDate) {
        $query->whereBetween('created_at', [$startDate, $endDate]);
    } elseif ($startDate) {
        $query->where('created_at', '>=', $startDate);
    } elseif ($endDate) {
        $query->where('created_at', '<=', $endDate);
    }

    return $query->select(
            'insurance_company_id',
            DB::raw('COUNT(*) as policy_count'),
            DB::raw('SUM(premium_amount) as total_premium'),
            DB::raw('SUM(commission_amount) as total_commission'),
            DB::raw('CASE
                WHEN SUM(premium_amount) > 0
                THEN (SUM(commission_amount) / SUM(premium_amount)) * 100
                ELSE 0
            END as avg_commission_rate')
        )
        ->groupBy('insurance_company_id')
        ->orderByDesc('total_commission')
        ->get();
}

    /**
     * Müşteri analizleri
     */
    public function customers()
    {
        $stats = [
            'total_customers' => Customer::count(),
            'active_customers' => Customer::where('status', 'active')->count(),
            'potential_customers' => Customer::where('status', 'potential')->count(),
            'customers_with_policies' => Customer::has('policies')->count(),
        ];

        $customersByCity = Customer::select('city', DB::raw('COUNT(*) as count'))
            ->whereNotNull('city')
            ->where('city', '!=', '')
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        $totalCustomers = Customer::count();
        $totalPolicies = Policy::count();
        $avgPoliciesPerCustomer = $totalCustomers > 0 ? $totalPolicies / $totalCustomers : 0;

        $topCustomers = Customer::select(
                'customers.id',
                'customers.name',
                'customers.phone',
                'customers.email',
                'customers.city'
            )
            ->join('policies', 'customers.id', '=', 'policies.customer_id')
            ->selectRaw('SUM(policies.premium_amount) as total_premium')
            ->selectRaw('COUNT(policies.id) as policy_count')
            ->groupBy('customers.id', 'customers.name', 'customers.phone', 'customers.email', 'customers.city')
            ->orderByDesc('total_premium')
            ->limit(10)
            ->get();

        return view('reports.customers', compact(
            'stats',
            'customersByCity',
            'avgPoliciesPerCustomer',
            'topCustomers'
        ));
    }

    /**
     * Yenileme raporları
     */
    public function renewals(Request $request)
    {
        $startDate = $request->get('start_date', now()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->addDays(90)->format('Y-m-d'));

        // Genel İstatistikler
        $stats = [
            'total_renewals' => PolicyRenewal::whereBetween('renewal_date', [$startDate, $endDate])->count(),
            'pending_renewals' => PolicyRenewal::whereBetween('renewal_date', [$startDate, $endDate])
                ->whereIn('status', ['pending', 'contacted'])->count(),
            'renewed' => PolicyRenewal::whereBetween('renewal_date', [$startDate, $endDate])
                ->where('status', 'renewed')->count(),
            'lost' => PolicyRenewal::whereBetween('renewal_date', [$startDate, $endDate])
                ->where('status', 'lost')->count(),
        ];

        // Başarı oranı hesapla
        $totalCompleted = $stats['renewed'] + $stats['lost'];
        $stats['success_rate'] = $totalCompleted > 0 ? ($stats['renewed'] / $totalCompleted) * 100 : 0;

        // Önceliğe göre dağılım
        $renewalsByPriority = PolicyRenewal::whereBetween('renewal_date', [$startDate, $endDate])
            ->select('priority', DB::raw('COUNT(*) as count'))
            ->groupBy('priority')
            ->get();

        // Duruma göre dağılım
        $renewalsByStatus = PolicyRenewal::whereBetween('renewal_date', [$startDate, $endDate])
            ->select('status', DB::raw('COUNT(*) as count'))
            ->groupBy('status')
            ->get();

        // Kayıp nedenleri
        $lostReasons = PolicyRenewal::whereBetween('renewal_date', [$startDate, $endDate])
            ->where('status', 'lost')
            ->whereNotNull('lost_reason')
            ->select('lost_reason', DB::raw('COUNT(*) as count'))
            ->groupBy('lost_reason')
            ->orderByDesc('count')
            ->get();

        // Haftalık yenileme trendi
        $weeklyRenewals = PolicyRenewal::whereBetween('renewal_date', [$startDate, $endDate])
            ->select(
                DB::raw('YEARWEEK(renewal_date) as week'),
                DB::raw('COUNT(*) as total'),
                DB::raw('SUM(CASE WHEN status = "renewed" THEN 1 ELSE 0 END) as renewed'),
                DB::raw('SUM(CASE WHEN status = "lost" THEN 1 ELSE 0 END) as lost')
            )
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        return view('reports.renewals', compact(
            'stats',
            'renewalsByPriority',
            'renewalsByStatus',
            'lostReasons',
            'weeklyRenewals',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Ödeme raporları
     */
    public function payments(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Genel İstatistikler
        $stats = [
            'total_collected' => Payment::whereBetween('payment_date', [$startDate, $endDate])
                ->where('status', 'completed')->sum('amount'),
            'total_payments' => Payment::whereBetween('payment_date', [$startDate, $endDate])->count(),
            'cash_payments' => Payment::whereBetween('payment_date', [$startDate, $endDate])
                ->where('payment_method', 'cash')->sum('amount'),
            'card_payments' => Payment::whereBetween('payment_date', [$startDate, $endDate])
                ->whereIn('payment_method', ['credit_card', 'pos'])->sum('amount'),
        ];

        // Ödeme yöntemine göre dağılım
        $paymentsByMethod = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select(
                'payment_method',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(amount) as total_amount')
            )
            ->groupBy('payment_method')
            ->get();

        // Günlük tahsilat trendi
        $dailyCollections = Payment::whereBetween('payment_date', [$startDate, $endDate])
            ->where('status', 'completed')
            ->select(
                DB::raw('DATE(payment_date) as date'),
                DB::raw('SUM(amount) as total_amount'),
                DB::raw('COUNT(*) as payment_count')
            )
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Bekleyen ve gecikmiş ödemeler
        $pendingPayments = DB::table('installments')
            ->where('status', 'pending')
            ->sum('amount');

        $overduePayments = DB::table('installments')
            ->where('status', 'pending')
            ->where('due_date', '<', now())
            ->sum('amount');

        return view('reports.payments', compact(
            'stats',
            'paymentsByMethod',
            'dailyCollections',
            'pendingPayments',
            'overduePayments',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Excel export
     */
    public function export(Request $request)
    {
        $reportType = $request->get('type');
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // TODO: Excel export implementation
        // Maatwebsite/Excel paketi kullanılabilir

        return back()->with('info', 'Excel export özelliği yakında eklenecek.');
    }

    /**
     * Cari işlemler raporları
     */
    public function cari(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // 1. GENEL DURUM İSTATİSTİKLERİ
        $stats = $this->getCariStats();

        // 2. CARİ TİPLERİNE GÖRE DAĞILIM
        $cariByType = $this->getCariByType();

        // 3. TAHSİLAT ANALİZİ
        $tahsilatStats = $this->getTahsilatStats($startDate, $endDate);
        $tahsilatByMonth = $this->getTahsilatByMonth($startDate, $endDate);
        $tahsilatByMethod = $this->getTahsilatByMethod($startDate, $endDate);

        // 4. YAŞLANDIRMA RAPORU (En kritik!)
        $yaslandirma = $this->getYaslandirmaRaporu();

        // 5. EN YÜKSEK BORÇLU MÜŞTERİLER
        $topDebtors = $this->getTopDebtors(10);

        // 6. VADE AŞIMI OLAN MÜŞTERİLER
        $overdueCustomers = $this->getOverdueCustomers();

        // 7. ŞİRKET ÖDEMELERİ ÖZETİ
        $sirketOdemeleri = $this->getSirketOdemeleriOzet($startDate, $endDate);

        // 8. KASA/BANKA HAREKETLERİ
        $kasaBankaHareketler = $this->getKasaBankaHareketler($startDate, $endDate);

        return view('reports.cari', compact(
            'stats',
            'cariByType',
            'tahsilatStats',
            'tahsilatByMonth',
            'tahsilatByMethod',
            'yaslandirma',
            'topDebtors',
            'overdueCustomers',
            'sirketOdemeleri',
            'kasaBankaHareketler',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Genel cari istatistikleri
     */
    private function getCariStats()
    {
        // Toplam alacak (pozitif bakiyeler)
        $toplamAlacak = \App\Models\CariHesap::where('bakiye', '>', 0)->sum('bakiye');

        // Toplam borç (negatif bakiyeler - mutlak değer)
        $toplamBorc = abs(\App\Models\CariHesap::where('bakiye', '<', 0)->sum('bakiye'));

        // Net durum
        $netDurum = $toplamAlacak - $toplamBorc;

        // Kasa/Banka toplam
        $kasaBankaBakiye = \App\Models\CariHesap::whereIn('tip', ['kasa', 'banka'])
            ->where('aktif', true)
            ->sum('bakiye');

        return [
            'toplam_alacak' => $toplamAlacak,
            'toplam_borc' => $toplamBorc,
            'net_durum' => $netDurum,
            'kasa_banka_bakiye' => $kasaBankaBakiye,
        ];
    }

    /**
     * Cari tipine göre dağılım
     */
    private function getCariByType()
    {
        $types = ['musteri', 'sirket', 'kasa', 'banka'];
        $result = [];

        foreach ($types as $type) {
            $carilar = \App\Models\CariHesap::where('tip', $type)->where('aktif', true)->get();

            $result[$type] = [
                'adet' => $carilar->count(),
                'toplam_alacak' => $carilar->where('bakiye', '>', 0)->sum('bakiye'),
                'toplam_borc' => abs($carilar->where('bakiye', '<', 0)->sum('bakiye')),
                'net' => $carilar->sum('bakiye'),
            ];
        }

        return $result;
    }

    /**
     * Tahsilat genel istatistikleri
     */
    private function getTahsilatStats($startDate, $endDate)
    {
        $tahsilatlar = \App\Models\Tahsilat::whereBetween('tahsilat_tarihi', [$startDate, $endDate])->get();

        return [
            'toplam_tahsilat' => $tahsilatlar->sum('tutar'),
            'tahsilat_sayisi' => $tahsilatlar->count(),
            'ortalama_tahsilat' => $tahsilatlar->avg('tutar') ?? 0,
        ];
    }

    /**
     * Aylık tahsilat trendi
     */
    private function getTahsilatByMonth($startDate, $endDate)
    {
        return \App\Models\Tahsilat::whereBetween('tahsilat_tarihi', [$startDate, $endDate])
            ->selectRaw('DATE_FORMAT(tahsilat_tarihi, "%Y-%m") as month, SUM(tutar) as total, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->map(function($item) {
                $months = [
                    '01' => 'Oca', '02' => 'Şub', '03' => 'Mar', '04' => 'Nis',
                    '05' => 'May', '06' => 'Haz', '07' => 'Tem', '08' => 'Ağu',
                    '09' => 'Eyl', '10' => 'Eki', '11' => 'Kas', '12' => 'Ara'
                ];
                $parts = explode('-', $item->month);
                $item->month_label = $months[$parts[1]] . ' ' . $parts[0];
                return $item;
            });
    }

    /**
     * Ödeme yöntemine göre tahsilat
     */
    private function getTahsilatByMethod($startDate, $endDate)
    {
        return \App\Models\Tahsilat::whereBetween('tahsilat_tarihi', [$startDate, $endDate])
            ->select('odeme_yontemi', DB::raw('SUM(tutar) as total'), DB::raw('COUNT(*) as count'))
            ->groupBy('odeme_yontemi')
            ->orderByDesc('total')
            ->get();
    }

    /**
     * YAŞLANDIRMA RAPORU - EN KRİTİK RAPOR
     */
    private function getYaslandirmaRaporu()
    {
        $today = now();

        $yaslandirma = [
            '0_30' => ['tutar' => 0, 'adet' => 0],
            '31_60' => ['tutar' => 0, 'adet' => 0],
            '61_90' => ['tutar' => 0, 'adet' => 0],
            '90_plus' => ['tutar' => 0, 'adet' => 0],
        ];

        // Müşteri carisi olan ve alacağı olan hareketler
        $alacakHareketler = \App\Models\CariHareket::whereHas('cariHesap', function($q) {
                $q->where('tip', 'musteri')->where('aktif', true);
            })
            ->where('islem_tipi', 'alacak')
            ->whereNotNull('vade_tarihi')
            ->get();

        foreach ($alacakHareketler as $hareket) {
            $gunFarki = $today->diffInDays($hareket->vade_tarihi, false);
            $gunFarkiAbs = abs($gunFarki);

            if ($gunFarkiAbs <= 30) {
                $yaslandirma['0_30']['tutar'] += $hareket->tutar;
                $yaslandirma['0_30']['adet']++;
            } elseif ($gunFarkiAbs <= 60) {
                $yaslandirma['31_60']['tutar'] += $hareket->tutar;
                $yaslandirma['31_60']['adet']++;
            } elseif ($gunFarkiAbs <= 90) {
                $yaslandirma['61_90']['tutar'] += $hareket->tutar;
                $yaslandirma['61_90']['adet']++;
            } else {
                $yaslandirma['90_plus']['tutar'] += $hareket->tutar;
                $yaslandirma['90_plus']['adet']++;
            }
        }

        return $yaslandirma;
    }

    /**
     * En yüksek borçlu müşteriler
     */
    private function getTopDebtors($limit = 10)
    {
        return \App\Models\CariHesap::where('tip', 'musteri')
            ->where('bakiye', '>', 0)
            ->where('aktif', true)
            ->orderByDesc('bakiye')
            ->limit($limit)
            ->get();
    }

    /**
     * Vade aşımı olan müşteriler
     */
    private function getOverdueCustomers()
    {
        $today = now();

        return \App\Models\CariHareket::where('islem_tipi', 'alacak')
            ->whereNotNull('vade_tarihi')
            ->where('vade_tarihi', '<', $today)
            ->whereHas('cariHesap', function($q) {
                $q->where('tip', 'musteri')->where('aktif', true);
            })
            ->with('cariHesap')
            ->select('cari_hesap_id',
                    DB::raw('SUM(tutar) as toplam_vade_asimi'),
                    DB::raw('MIN(vade_tarihi) as en_eski_vade'))
            ->groupBy('cari_hesap_id')
            ->orderByDesc('toplam_vade_asimi')
            ->limit(10)
            ->get()
            ->filter(function($item) {
                return $item->cariHesap !== null;
            });
    }

    /**
     * Şirket ödemeleri özeti
     */
    private function getSirketOdemeleriOzet($startDate, $endDate)
    {
        return \App\Models\SirketOdeme::whereBetween('odeme_tarihi', [$startDate, $endDate])
            ->with('sirketCari')
            ->select('sirket_cari_id',
                    DB::raw('SUM(tutar) as toplam'),
                    DB::raw('COUNT(*) as adet'))
            ->groupBy('sirket_cari_id')
            ->orderByDesc('toplam')
            ->limit(10)
            ->get();
    }

    /**
     * Kasa/Banka hareketleri
     */
    private function getKasaBankaHareketler($startDate, $endDate)
    {
        return \App\Models\CariHareket::whereHas('cariHesap', function($q) {
                $q->whereIn('tip', ['kasa', 'banka'])->where('aktif', true);
            })
            ->whereBetween('islem_tarihi', [$startDate, $endDate])
            ->with('cariHesap')
            ->select('cari_hesap_id',
                    DB::raw('SUM(CASE WHEN islem_tipi = "borc" THEN tutar ELSE 0 END) as toplam_giris'),
                    DB::raw('SUM(CASE WHEN islem_tipi = "alacak" THEN tutar ELSE 0 END) as toplam_cikis'))
            ->groupBy('cari_hesap_id')
            ->get();
    }

    /**
     * 🏆 SATIŞ TEMSİLCİSİ PERFORMANS RAPORU
     */
    public function salesPerformance(Request $request)
    {
        $user = Auth::user();
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->format('Y-m-d'));
        $selectedRepId = $request->get('rep_id', null);

        // YETKİ KONTROLÜ
        // Agent sadece kendini görebilir
        // Owner/Manager tüm temsilcileri görebilir
        if ($user->canSeeOnlyOwn()) {
            $selectedRepId = $user->id;
            $viewMode = 'personal'; // Kişisel dashboard
        } else {
            $viewMode = 'manager'; // Yönetici görünümü
        }

        // Temsilci listesi (dropdown için)
        $salesReps = collect();
        if ($viewMode === 'manager') {
            $salesReps = \App\Models\User::where('tenant_id', $user->tenant_id)
                ->whereIn('role', ['agent', 'manager','owner'])
                ->orderBy('name')
                ->get();

            // Hiç seçilmemişse ilk temsilciyi seç
            if (!$selectedRepId && $salesReps->isNotEmpty()) {
                $selectedRepId = $salesReps->first()->id;
            }
        }

        // Seçili temsilci bilgileri
        $selectedRep = \App\Models\User::find($selectedRepId);

        // 1. KİŞİSEL METRİKLER
        $personalMetrics = $this->getPersonalMetrics($selectedRepId, $startDate, $endDate);

        // 2. MÜŞTERİ PORTFÖY ANALİZİ
        $customerPortfolio = $this->getCustomerPortfolio($selectedRepId);

        // 3. AYLIK PERFORMANS TRENDİ (Son 6 ay)
        $monthlyTrend = $this->getMonthlyPerformanceTrend($selectedRepId);

        // 4. LEADERBOARD (Sadece manager görünümünde)
        $leaderboard = collect();
        if ($viewMode === 'manager') {
            $leaderboard = $this->getLeaderboard($startDate, $endDate);
        }

        // 5. BRANŞ BAZLI PERFORMANS
        $branchPerformance = $this->getBranchPerformance($selectedRepId, $startDate, $endDate);

        // 6. HEDEF vs GERÇEKLEŞME
        $targetVsActual = $this->getTargetVsActual($selectedRepId, $startDate, $endDate);

        return view('reports.sales-performance', compact(
            'viewMode',
            'selectedRep',
            'salesReps',
            'personalMetrics',
            'customerPortfolio',
            'monthlyTrend',
            'leaderboard',
            'branchPerformance',
            'targetVsActual',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Kişisel metrikler
     */
    private function getPersonalMetrics($userId, $startDate, $endDate)
    {
        $policies = Policy::where('created_by', $userId)
            ->whereBetween('created_at', [$startDate, $endDate]);

        $totalPolicies = $policies->count();
        $totalPremium = $policies->sum('premium_amount');
        $totalCommission = $policies->sum('commission_amount');
        $avgCommissionRate = $policies->avg('commission_rate') ?? 0;

        // Tahsilat oranı
        $policyIds = $policies->pluck('id');
        $collectedAmount = \App\Models\Tahsilat::whereIn('policy_id', $policyIds)
            ->sum('tutar');

        $collectionRate = $totalPremium > 0
            ? ($collectedAmount / $totalPremium) * 100
            : 0;

        // Önceki dönem karşılaştırması (bir önceki ay)
        $previousStart = \Carbon\Carbon::parse($startDate)->subMonth()->startOfMonth()->format('Y-m-d');
        $previousEnd = \Carbon\Carbon::parse($startDate)->subMonth()->endOfMonth()->format('Y-m-d');

        $previousPolicies = Policy::where('created_by', $userId)
            ->whereBetween('created_at', [$previousStart, $previousEnd])
            ->count();

        $policyGrowth = $previousPolicies > 0
            ? (($totalPolicies - $previousPolicies) / $previousPolicies) * 100
            : 0;

        return [
            'total_policies' => $totalPolicies,
            'total_premium' => $totalPremium,
            'total_commission' => $totalCommission,
            'avg_commission_rate' => $avgCommissionRate,
            'collection_rate' => $collectionRate,
            'policy_growth' => $policyGrowth,
            'avg_policy_value' => $totalPolicies > 0 ? $totalPremium / $totalPolicies : 0,
        ];
    }

/**
 * Müşteri portföy analizi
 */
private function getCustomerPortfolio($userId)
{
    $totalCustomers = Customer::where('created_by', $userId)->count();
    $activeCustomers = Customer::where('created_by', $userId)
        ->where('status', 'active')
        ->count();

    // Poliçesi olan müşteriler
    $customersWithPolicies = Customer::where('created_by', $userId)
        ->has('policies')
        ->count();

    // ✅ DÜZELTME: Tablo adını belirt
    $avgLTV = Customer::where('customers.created_by', $userId) // ✅ customers. eklendi
        ->join('policies', 'customers.id', '=', 'policies.customer_id')
        ->groupBy('customers.id')
        ->selectRaw('AVG(policies.premium_amount) as avg_premium')
        ->get()
        ->avg('avg_premium') ?? 0;

    // Yeni müşteriler (son 30 gün)
    $newCustomers = Customer::where('created_by', $userId)
        ->where('created_at', '>=', now()->subDays(30))
        ->count();

    return [
        'total_customers' => $totalCustomers,
        'active_customers' => $activeCustomers,
        'customers_with_policies' => $customersWithPolicies,
        'avg_ltv' => $avgLTV,
        'new_customers_30d' => $newCustomers,
        'retention_rate' => $totalCustomers > 0
            ? ($activeCustomers / $totalCustomers) * 100
            : 0,
    ];
}

    /**
     * Aylık performans trendi (Son 6 ay)
     */
    private function getMonthlyPerformanceTrend($userId)
    {
        $months = [];
        for ($i = 5; $i >= 0; $i--) {
            $months[] = now()->subMonths($i)->format('Y-m');
        }

        $trend = collect($months)->map(function($month) use ($userId) {
            $startOfMonth = \Carbon\Carbon::parse($month)->startOfMonth();
            $endOfMonth = \Carbon\Carbon::parse($month)->endOfMonth();

            $policies = Policy::where('created_by', $userId)
                ->whereBetween('created_at', [$startOfMonth, $endOfMonth]);

            $monthNames = [
                '01' => 'Oca', '02' => 'Şub', '03' => 'Mar', '04' => 'Nis',
                '05' => 'May', '06' => 'Haz', '07' => 'Tem', '08' => 'Ağu',
                '09' => 'Eyl', '10' => 'Eki', '11' => 'Kas', '12' => 'Ara'
            ];

            $parts = explode('-', $month);
            $monthLabel = $monthNames[$parts[1]] . ' ' . $parts[0];

            return [
                'month' => $monthLabel,
                'policies' => $policies->count(),
                'premium' => $policies->sum('premium_amount'),
                'commission' => $policies->sum('commission_amount'),
            ];
        });

        return $trend;
    }

    /**
     * Leaderboard (Top 10)
     */
    private function getLeaderboard($startDate, $endDate)
    {
        $leaderboard = Policy::whereBetween('created_at', [$startDate, $endDate])
            ->with('creator')
            ->select(
                'created_by',
                DB::raw('COUNT(*) as policy_count'),
                DB::raw('SUM(premium_amount) as total_premium'),
                DB::raw('SUM(commission_amount) as total_commission')
            )
            ->groupBy('created_by')
            ->orderByDesc('total_commission')
            ->limit(10)
            ->get();

        // Her temsilci için tahsilat oranı ekle
        foreach ($leaderboard as $rep) {
            $policyIds = Policy::where('created_by', $rep->created_by)
                ->whereBetween('created_at', [$startDate, $endDate])
                ->pluck('id');

            $collected = \App\Models\Tahsilat::whereIn('policy_id', $policyIds)
                ->sum('tutar');

            $rep->collection_rate = $rep->total_premium > 0
                ? ($collected / $rep->total_premium) * 100
                : 0;
        }

        return $leaderboard;
    }

    /**
     * Branş bazlı performans
     */
    private function getBranchPerformance($userId, $startDate, $endDate)
    {
        return Policy::where('created_by', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->select(
                'policy_type',
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(premium_amount) as total_premium'),
                DB::raw('SUM(commission_amount) as total_commission')
            )
            ->groupBy('policy_type')
            ->orderByDesc('total_commission')
            ->get();
    }

    /**
     * Hedef vs Gerçekleşme
     */
    private function getTargetVsActual($userId, $startDate, $endDate)
    {
        // Şimdilik basit hedefler - ileride users tablosuna hedef kolonları eklenebilir
        $monthlyTarget = 50000; // Aylık 50.000₺ prim hedefi

        $actual = Policy::where('created_by', $userId)
            ->whereBetween('created_at', [$startDate, $endDate])
            ->sum('premium_amount');

        $achievementRate = $monthlyTarget > 0
            ? ($actual / $monthlyTarget) * 100
            : 0;

        return [
            'target_premium' => $monthlyTarget,
            'actual_premium' => $actual,
            'achievement_rate' => $achievementRate,
            'remaining' => max(0, $monthlyTarget - $actual),
        ];
    }
}
