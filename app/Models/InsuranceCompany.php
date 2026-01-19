<?php

namespace App\Models;
use App\Traits\BelongsToTenantShared;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class InsuranceCompany extends Model
{
    use HasFactory, BelongsToTenantShared;

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'display_order' => 'integer',
        'default_commission_kasko' => 'decimal:2',
        'default_commission_trafik' => 'decimal:2',
        'default_commission_konut' => 'decimal:2',
        'default_commission_dask' => 'decimal:2',
        'default_commission_saglik' => 'decimal:2',
        'default_commission_hayat' => 'decimal:2',
        'default_commission_tss' => 'decimal:2',
    ];

    // İlişkiler
    public function policies()
    {
        return $this->hasMany(Policy::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    /**
     * Cari hesap ilişkisi
     */
    public function cariHesap()
    {
        return $this->hasOne(CariHesap::class, 'referans_id')
                    ->where('tip', 'sirket');
    }

    // Scope'lar
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('is_active', false);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order')->orderBy('name');
    }

    // Accessor'lar
    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return Storage::url($this->logo);
        }
        return asset('images/default-company-logo.png');
    }

    public function getStatusLabelAttribute()
    {
        return $this->is_active ? 'Aktif' : 'Pasif';
    }

    public function getStatusColorAttribute()
    {
        return $this->is_active ? 'success' : 'secondary';
    }

    // Komisyon oranı getir
    public function getCommissionRate($policyType)
    {
        $field = 'default_commission_' . $policyType;
        return $this->$field ?? 0;
    }

    // Yardımcı metodlar
    public function isActive(): bool
    {
        return $this->is_active;
    }

    public function activate(): bool
    {
        return $this->update(['is_active' => true]);
    }

    public function deactivate(): bool
    {
        return $this->update(['is_active' => false]);
    }
}
