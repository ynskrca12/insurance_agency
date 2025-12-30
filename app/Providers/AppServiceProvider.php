<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use App\Models\{
    Customer, Policy, Quotation,
    PolicyRenewal, Payment, Task,
    Campaign, InsuranceCompany
};

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
   public function boot(): void
    {
        View::composer('layouts.app', function ($view) {

            if (!Auth::check()) {
                return;
            }

            $user = Auth::user();
            $isAdmin = in_array($user->role, ['owner', 'manager']);

            $cacheKey = 'sidebar-counts-user-'.$user->id;

            $counts = Cache::remember($cacheKey, 300, function () use ($user, $isAdmin) {

                $byUser = fn ($q) =>
                    $isAdmin ? $q : $q->where('created_by', $user->id);

                return [
                    'customers' => Customer::where(fn($q) => $byUser($q))->count(),
                    'policies'  => Policy::where(fn($q) => $byUser($q))->count(),
                    'quotations'=> Quotation::where(fn($q) => $byUser($q))->count(),

                    'renewals'  => PolicyRenewal::critical()->count(),
                    'payments'  => Payment::completed()->count(),

                    'tasks'     => Task::where('assigned_to', $user->id)
                                        ->whereNotIn('status', ['completed','cancelled'])
                                        ->count(),

                    'campaigns' => Campaign::where('status','draft')->count(),
                    'companies' => InsuranceCompany::where('is_active', true)->count(),
                ];
            });

            $view->with('sidebarCounts', $counts);
        });
    }
}
