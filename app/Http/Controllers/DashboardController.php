<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Policy;
use App\Models\Task;
use Illuminate\Http\Request;

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
        $todayTasks = Task::with(['assignedTo', 'related'])
            ->dueToday()
            ->orderBy('priority', 'desc')
            ->get();

        return view('dashboard', compact(
            'stats',
            'recentCustomers',
            'expiringPolicies',
            'todayTasks'
        ));
    }
}
