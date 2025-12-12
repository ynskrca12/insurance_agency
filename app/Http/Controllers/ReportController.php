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
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));
        $groupBy = $request->get('group_by', 'day'); // day, week, month, year
        $policyType = $request->get('policy_type', 'all');

        // Genel İstatistikler
        $stats = [
            'total_policies' => Policy::whereBetween('created_at', [$startDate, $endDate])->count(),
            'total_premium' => Policy::whereBetween('created_at', [$startDate, $endDate])->sum('premium_amount'),
            'total_commission' => Policy::whereBetween('created_at', [$startDate, $endDate])->sum('commission_amount'),
            'average_premium' => Policy::whereBetween('created_at', [$startDate, $endDate])->avg('premium_amount'),
        ];

        // Poliçe türüne göre dağılım
        $policyTypeDistribution = Policy::whereBetween('created_at', [$startDate, $endDate])
            ->select('policy_type', DB::raw('COUNT(*) as count'), DB::raw('SUM(premium_amount) as total_premium'))
            ->groupBy('policy_type')
            ->get();

        // Sigorta şirketine göre dağılım
        $companyDistribution = Policy::whereBetween('created_at', [$startDate, $endDate])
            ->with('insuranceCompany')
            ->select('insurance_company_id', DB::raw('COUNT(*) as count'), DB::raw('SUM(premium_amount) as total_premium'))
            ->groupBy('insurance_company_id')
            ->get();

        // Zaman serisi verileri (Grafik için)
        $timeSeriesData = $this->getTimeSeriesData($startDate, $endDate, $groupBy);

        // En iyi performans gösteren poliçe türleri
        $topPolicyTypes = Policy::whereBetween('created_at', [$startDate, $endDate])
            ->select('policy_type', DB::raw('COUNT(*) as count'), DB::raw('SUM(premium_amount) as total_premium'))
            ->groupBy('policy_type')
            ->orderByDesc('total_premium')
            ->limit(5)
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
        ));
    }

    /**
     * Komisyon raporları
     */
    public function commission(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfMonth()->format('Y-m-d'));

        // Genel İstatistikler
        $stats = [
            'total_commission' => Policy::whereBetween('created_at', [$startDate, $endDate])->sum('commission_amount'),
            'total_policies' => Policy::whereBetween('created_at', [$startDate, $endDate])->count(),
            'average_commission' => Policy::whereBetween('created_at', [$startDate, $endDate])->avg('commission_amount'),
            'commission_rate' => 0,
        ];

        // Komisyon oranı hesapla
        $totalPremium = Policy::whereBetween('created_at', [$startDate, $endDate])->sum('premium_amount');
        if ($totalPremium > 0) {
            $stats['commission_rate'] = ($stats['total_commission'] / $totalPremium) * 100;
        }

        // Sigorta şirketine göre komisyon
        $commissionByCompany = Policy::whereBetween('created_at', [$startDate, $endDate])
            ->with('insuranceCompany')
            ->select(
                'insurance_company_id',
                DB::raw('COUNT(*) as policy_count'),
                DB::raw('SUM(premium_amount) as total_premium'),
                DB::raw('SUM(commission_amount) as total_commission'),
                DB::raw('AVG((commission_amount / premium_amount) * 100) as avg_commission_rate')
            )
            ->groupBy('insurance_company_id')
            ->orderByDesc('total_commission')
            ->get();

        // Poliçe türüne göre komisyon
        $commissionByType = Policy::whereBetween('created_at', [$startDate, $endDate])
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
        $monthlyCommission = Policy::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('SUM(commission_amount) as total_commission'),
                DB::raw('COUNT(*) as policy_count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('reports.commission', compact(
            'stats',
            'commissionByCompany',
            'commissionByType',
            'monthlyCommission',
            'startDate',
            'endDate'
        ));
    }

    /**
     * Müşteri analizleri
     */
    public function customers(Request $request)
    {
        $startDate = $request->get('start_date', now()->startOfYear()->format('Y-m-d'));
        $endDate = $request->get('end_date', now()->endOfYear()->format('Y-m-d'));

        $stats = [
            'total_customers' => Customer::count(),
            'active_customers' => Customer::where('status', 'active')->count(),
            'new_customers' => Customer::whereBetween('created_at', [$startDate, $endDate])->count(),
            'customers_with_policies' => Customer::has('policies')->count(),
        ];

        $customersByCity = Customer::select('city', DB::raw('COUNT(*) as count'))
            ->whereNotNull('city')
            ->groupBy('city')
            ->orderByDesc('count')
            ->limit(10)
            ->get();

        // Müşteri başına ortalama poliçe sayısı
        $avgPoliciesPerCustomer = Policy::count() / max(Customer::count(), 1);

        // En değerli müşteriler
        $topCustomers = Customer::select('customers.id', 'customers.name', 'customers.phone', 'customers.email', 'customers.city')
            ->join('policies', 'customers.id', '=', 'policies.customer_id')
            ->selectRaw('SUM(policies.premium_amount) as total_premium')
            ->groupBy('customers.id', 'customers.name', 'customers.phone', 'customers.email', 'customers.city')
            ->orderByDesc('total_premium')
            ->limit(10)
            ->get();

        // Poliçe sayısını ayrıca çek
        foreach ($topCustomers as $customer) {
            $customer->policy_count = Policy::where('customer_id', $customer->id)->count();
        }

        // Aylık yeni müşteri trendi
        $monthlyNewCustomers = Customer::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw('DATE_FORMAT(created_at, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // $customersByAge = Customer::whereNotNull('date_of_birth')
        //     ->selectRaw('
        //         CASE
        //             WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) < 25 THEN "18-24"
        //             WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 25 AND 34 THEN "25-34"
        //             WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 35 AND 44 THEN "35-44"
        //             WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 45 AND 54 THEN "45-54"
        //             WHEN TIMESTAMPDIFF(YEAR, date_of_birth, CURDATE()) BETWEEN 55 AND 64 THEN "55-64"
        //             ELSE "65+"
        //         END as age_group,
        //         COUNT(*) as count
        //     ')
        //     ->groupBy('age_group')
        //     ->get();

        return view('reports.customers', compact(
            'stats',
            'customersByCity',
            'avgPoliciesPerCustomer',
            'topCustomers',
            'monthlyNewCustomers',
            // 'customersByAge',
            'startDate',
            'endDate'
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
     * Zaman serisi verileri oluştur
     */
    private function getTimeSeriesData($startDate, $endDate, $groupBy)
    {
        $dateFormat = match($groupBy) {
            'day' => '%Y-%m-%d',
            'week' => '%Y-%u',
            'month' => '%Y-%m',
            'year' => '%Y',
            default => '%Y-%m-%d',
        };

        return Policy::whereBetween('created_at', [$startDate, $endDate])
            ->select(
                DB::raw("DATE_FORMAT(created_at, '{$dateFormat}') as period"),
                DB::raw('COUNT(*) as policy_count'),
                DB::raw('SUM(premium_amount) as total_premium'),
                DB::raw('SUM(commission_amount) as total_commission')
            )
            ->groupBy('period')
            ->orderBy('period')
            ->get();
    }
}
