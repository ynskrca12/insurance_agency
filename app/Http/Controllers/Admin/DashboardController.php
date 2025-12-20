<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DemoUser;
use App\Models\Post;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Dashboard ana sayfası
     */
    public function index()
    {
        // İstatistikler
        // $stats = [
        //     'total_demo_users' => DemoUser::count(),
        //     'active_demo_users' => DemoUser::whereHas('user')
        //         ->where('trial_ends_at', '>', now())
        //         ->count(),
        //     // 'unread_messages' => ContactMessage::where('is_read', false)->count() ?? 0,
        //     'today_registrations' => DemoUser::whereDate('created_at', today())->count(),
        //     // 'today_messages' => ContactMessage::whereDate('created_at', today())->count() ?? 0,
        //     'expired_demos' => DemoUser::where('trial_ends_at', '<', now())->count(),
        // ];

            $stats = [
                'total_demo_users' => DemoUser::count(),
                'active_demo_users' => DemoUser::whereHas('user')
                    ->where('trial_ends_at', '>', now())
                    ->count(),
                'total_posts' => \App\Models\Blog::count(),
                // 'unread_messages' => ContactMessage::where('is_read', false)->count() ?? 0,
                'today_registrations' => DemoUser::whereDate('created_at', today())->count(),
                'published_today' => \App\Models\Blog::whereDate('published_at', today())->count(),
                // 'today_messages' => ContactMessage::whereDate('created_at', today())->count() ?? 0,
                'expired_demos' => DemoUser::where('trial_ends_at', '<', now())->count(),
            ];

        // Son demo kullanıcılar
        $recentDemoUsers = DemoUser::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Chart verileri (son 7 gün)
        $chartLabels = [];
        $chartData = [];

        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i);
            $chartLabels[] = $date->format('d.m');
            $chartData[] = DemoUser::whereDate('created_at', $date)->count();
        }

        return view('admin.dashboard', [
            'stats' => $stats,
            'recentDemoUsers' => $recentDemoUsers,
            'chartData' => [
                'labels' => $chartLabels,
                'data' => $chartData,
            ],
        ]);
    }
}
