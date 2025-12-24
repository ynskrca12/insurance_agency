<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * Davranış:
 * - Admin: Tüm tenant'ları görür (filtre yok)
 * - Owner/Manager: Aynı tenant'taki TÜM verileri görür
 * - Agent: Aynı tenant'taki sadece KENDİ verilerini görür
 */
trait BelongsToTenant
{
    /**
     * Boot the trait
     */
    protected static function bootBelongsToTenant(): void
    {
        // Creating Event - Otomatik tenant_id ve created_by atama
        static::creating(function ($model) {
            if (!Auth::check()) {
                return;
            }

            // Tenant ID henüz atanmamışsa
            if (!$model->tenant_id && !Auth::user()->isAdmin()) {
                $model->tenant_id = Auth::user()->tenant_id;
            }

            // Created By henüz atanmamışsa
            if (!$model->created_by) {
                $model->created_by = Auth::id();
            }
        });

        // Global Scope - Akıllı Filtreleme
        static::addGlobalScope('tenantScope', function (Builder $builder) {
            if (!Auth::check()) {
                // Giriş yapılmamışsa hiçbir şey gösterme
                return $builder->whereNull($builder->getModel()->getTable() . '.id');
            }

            $user = Auth::user();

            // Admin tüm verileri görür
            if ($user->isAdmin()) {
                return;
            }

            // Owner ve Manager: Tüm tenant verilerini görür
            if ($user->canSeeAll()) {
                $builder->where($builder->getModel()->getTable() . '.tenant_id', $user->tenant_id);
                return;
            }

            // Agent: Sadece kendi verilerini görür
            if ($user->canSeeOnlyOwn()) {
                $builder->where($builder->getModel()->getTable() . '.tenant_id', $user->tenant_id)
                        ->where($builder->getModel()->getTable() . '.created_by', $user->id);
                return;
            }
        });
    }

    /**
     * Tenant (Owner User) ilişkisi
     */
    public function tenant()
    {
        return $this->belongsTo(\App\Models\User::class, 'tenant_id');
    }

    /**
     * Oluşturan kullanıcı ilişkisi
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * Scope: Global scope'u devre dışı bırak (raporlama için)
     *
     * Kullanım: Customer::withAllTenants()->get()
     */
    public function scopeWithAllTenants($query)
    {
        return $query->withoutGlobalScope('tenantScope');
    }

    /**
     * Scope: Belirli bir tenant'a ait kayıtları getir
     *
     * Kullanım: Customer::forTenant(1)->get()
     */
    public function scopeForTenant($query, int $tenantId)
    {
        return $query->withoutGlobalScope('tenantScope')
                     ->where($query->getModel()->getTable() . '.tenant_id', $tenantId);
    }

    /**
     * Scope: Tüm tenant verileri (owner/manager için)
     *
     * Owner/Manager kendi tenant'ının TÜM verilerini görmek için.
     * Agent için de çalışır ama sadece kendi verilerini döner.
     *
     * Kullanım: Customer::allTenantData()->get()
     */
    public function scopeAllTenantData($query)
    {
        if (!Auth::check()) {
            return $query->whereNull($query->getModel()->getTable() . '.id');
        }

        $user = Auth::user();

        if ($user->isAdmin()) {
            return $query->withoutGlobalScope('tenantScope');
        }

        return $query->withoutGlobalScope('tenantScope')
                     ->where($query->getModel()->getTable() . '.tenant_id', $user->tenant_id);
    }

    /**
     * Scope: Sadece kendi verileri
     *
     * Kullanım: Customer::ownData()->get()
     */
    public function scopeOwnData($query)
    {
        if (!Auth::check()) {
            return $query->whereNull($query->getModel()->getTable() . '.id');
        }

        return $query->withoutGlobalScope('tenantScope')
                     ->where($query->getModel()->getTable() . '.tenant_id', Auth::user()->tenant_id)
                     ->where($query->getModel()->getTable() . '.created_by', Auth::id());
    }
}
