<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Policy;
use App\Models\Task;
use App\Models\Payment;
use App\Models\Installment;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Carbon\CarbonPeriod;
use Carbon\CarbonInterval;
use Carbon\CarbonImmutable;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    /**
     * Dashboard sayfası
     */
    public function index()
    {
        // İstatistikler
        $stats = [
            'total_customers' => Customer::count(),
            'total_policies' => Policy::count(),
            'active_policies' => Policy::active()->count(),
            'expiring_soon' => Policy::expiringSoon()->count(),
            'pending_tasks' => Task::pending()->count(),
            'overdue_tasks' => Task::overdue()->count(),
        ];

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
            'overdue_count' => Installment::overdue()->count(),
            'overdue_amount' => Installment::overdue()->sum('amount'),
            'due_today_count' => Installment::dueToday()->count(),
        ];

        return view('dashboard', compact(
            'stats',
            'recentCustomers',
            'expiringPolicies',
            'todayTasks',
            'paymentStats'
        ));
    }

        /**
     * Güvenli sum hesaplama (kolonlar yoksa 0 döndür)
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
