<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InsuranceCompany extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'name',
    //     'code',
    //     'logo',
    //     'phone',
    //     'email',
    //     'website',
    //     'default_commission_kasko',
    //     'default_commission_trafik',
    //     'default_commission_konut',
    //     'default_commission_dask',
    //     'default_commission_saglik',
    //     'default_commission_hayat',
    //     'default_commission_tss',
    //     'is_active',
    //     'display_order',
    // ];

    protected $guarded = [];

    protected $casts = [
        'is_active' => 'boolean',
        'default_commission_kasko' => 'decimal:2',
        'default_commission_trafik' => 'decimal:2',
        'default_commission_konut' => 'decimal:2',
        'default_commission_dask' => 'decimal:2',
        'default_commission_saglik' => 'decimal:2',
        'default_commission_hayat' => 'decimal:2',
        'default_commission_tss' => 'decimal:2',
    ];

    /**
     * İlişkiler
     */
    public function policies()
    {
        return $this->hasMany(Policy::class);
    }

    public function quotationItems()
    {
        return $this->hasMany(QuotationItem::class);
    }

    /**
     * Aktif şirketler
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('display_order');
    }

    /**
     * Poliçe türüne göre komisyon oranı
     */
    public function getCommissionRate(string $policyType): float
    {
        $field = "default_commission_{$policyType}";
        return $this->$field ?? 0;
    }

    /**
     * Logo URL
     */
    public function getLogoUrlAttribute(): ?string
    {
        return $this->logo ? asset('storage/' . $this->logo) : null;
    }
}
