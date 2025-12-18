<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;

trait BelongsToTenant
{
    /**
     * Boot the trait
     */
    protected static function bootBelongsToTenant()
    {
        // Model oluşturulurken otomatik tenant_id ata
        static::creating(function ($model) {
            if (Auth::check() && !$model->tenant_id) {
                $model->tenant_id = Auth::id();
            }
        });

        // Tüm sorgulara otomatik tenant_id filtresi ekle
        static::addGlobalScope('tenant', function (Builder $builder) {
            if (Auth::check()) {
                $builder->where($builder->getModel()->getTable() . '.tenant_id', Auth::id());
            }
        });
    }

    /**
     * Tenant (User) ilişkisi
     */
    public function tenant()
    {
        return $this->belongsTo(\App\Models\User::class, 'tenant_id');
    }

    /**
     * Global scope'u devre dışı bırak (admin veya raporlama için)
     */
    public function scopeWithAllTenants($query)
    {
        return $query->withoutGlobalScope('tenant');
    }

    /**
     * Belirli bir tenant'a ait kayıtları getir
     */
    public function scopeForTenant($query, $tenantId)
    {
        return $query->withoutGlobalScope('tenant')->where('tenant_id', $tenantId);
    }
}
