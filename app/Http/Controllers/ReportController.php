<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\Customer;
use App\Models\Payment;
use App\Models\PolicyRenewal;
use App\Models\InsuranceCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

        return view('reports.sales', compact(
            'stats',
            'policyTypeDistribution',
            'companyDistribution',
            'timeSeriesData',
            'topPolicyTypes',
            'startDate',
            'endDate',
            'groupBy'
        ))->with([
            'displayStartDate' => $displayStartDate,
            'displayEndDate' => $displayEndDate,
        ]);
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
     * Komisyon raporları
     */
    public function commission(Request $request)
    {
        // Varsayılan olarak TÜM VERİLER (filtresiz)
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
            'total_commission' => $statsQuery->sum('commission_amount') ?? 0,
            'total_policies' => $statsQuery->count(),
            'average_commission' => $statsQuery->avg('commission_amount') ?? 0,
            'commission_rate' => 0,
        ];

        // Komisyon oranı hesapla
        $totalPremiumQuery = clone $query;
        $totalPremium = $totalPremiumQuery->sum('premium_amount') ?? 0;
        if ($totalPremium > 0) {
            $stats['commission_rate'] = ($stats['total_commission'] / $totalPremium) * 100;
        }

        // Sigorta şirketine göre komisyon
        $companyQuery = clone $query;
        $commissionByCompany = $companyQuery
            ->with('insuranceCompany')
            ->select(
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
                $item->month_label = $months[$parts[1]] . ' ' . $parts[0];
                return $item;
            });

        return view('reports.commission', compact(
            'stats',
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
}
