<?php

namespace App\Models;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationItem extends Model
{
    use HasFactory, BelongsToTenant;

    // protected $fillable = [
    //     'quotation_id',
    //     'insurance_company_id',
    //     'premium_amount',
    //     'coverage_summary',
    //     'is_recommended',
    //     'rank',
    //     'notes',
    // ];

    protected $guarded = [];

    protected $casts = [
        'premium_amount' => 'decimal:2',
        'is_recommended' => 'boolean',
    ];

    /**
     * İlişkiler
     */
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function insuranceCompany()
    {
        return $this->belongsTo(InsuranceCompany::class);
    }

    /**
     * Scope'lar
     */
    public function scopeRecommended($query)
    {
        return $query->where('is_recommended', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('rank')->orderBy('premium_amount');
    }
}
