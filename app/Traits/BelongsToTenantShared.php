<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

/**
 * BelongsToTenantShared Trait
 * 
 * Acente geneli paylaşımlı veriler için (master data).
 * Tüm tenant kullanıcıları aynı verileri görür.
 * 
 * Kullanım Alanları:
 * - Sigorta Şirketleri
 * - Poliçe Tipleri
 * - Ödeme Yöntemleri
 * - Bankalar
 * - Settings
 */
trait BelongsToTenantShared
{
    /**
     * Boot the trait
     */
    protected static function bootBelongsToTenantShared(): void
    {
        // Creating Event - Sadece tenant_id ata
        static::creating(function ($model) {
            if (!Auth::check()) {
                return;
            }

            // Tenant ID
            if (!$model->tenant_id && !Auth::user()->isAdmin()) {
                $model->tenant_id = Auth::user()->tenant_id;
            }

            // created_by ata (kim ekledi bilgisi için - ama filtreleme YOK)
            if (!$model->created_by) {
                $model->created_by = Auth::id();
            }
        });

        // Global Scope - SADECE tenant_id filtresi (created_by YOK!)
        static::addGlobalScope('tenantSharedScope', function (Builder $builder) {
            if (!Auth::check()) {
                return $builder->whereNull($builder->getModel()->getTable() . '.id');
            }

            $user = Auth::user();
            $table = $builder->getModel()->getTable();

            // Admin tüm verileri görür
            if ($user->isAdmin()) {
                return;
            }

            // Owner, Manager, Agent → Hepsi aynı tenant verilerini görür
            $builder->where($table . '.tenant_id', $user->tenant_id);
            // ✅ created_by filtresi YOK!
        });
    }

    /**
     * Tenant ilişkisi
     */
    public function tenant()
    {
        return $this->belongsTo(\App\Models\User::class, 'tenant_id');
    }

    /**
     * Oluşturan kullanıcı (sadece bilgi amaçlı)
     */
    public function creator()
    {
        return $this->belongsTo(\App\Models\User::class, 'created_by');
    }

    /**
     * Scope: Global scope'u devre dışı bırak
     */
    public function scopeWithAllTenants($query)
    {
        return $query->withoutGlobalScope('tenantSharedScope');
    }

    /**
     * Scope: Belirli bir tenant
     */
    public function scopeForTenant($query, int $tenantId)
    {
        return $query->withoutGlobalScope('tenantSharedScope')
                     ->where($query->getModel()->getTable() . '.tenant_id', $tenantId);
    }
}