<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Quotation extends Model
{
    use HasFactory, SoftDeletes;

    // protected $fillable = [
    //     'customer_id',
    //     'quotation_number',
    //     'quotation_type',
    //     'vehicle_info',
    //     'property_info',
    //     'coverage_details',
    //     'valid_until',
    //     'status',
    //     'shared_link_token',
    //     'view_count',
    //     'customer_response',
    //     'selected_company_id',
    //     'converted_policy_id',
    //     'converted_at',
    //     'created_by',
    // ];

    protected $guarded = [];

    protected $casts = [
        'vehicle_info' => 'array',
        'property_info' => 'array',
        'coverage_details' => 'array',
        'valid_until' => 'date',
        'converted_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quotation) {
            if (!$quotation->shared_link_token) {
                $quotation->shared_link_token = Str::random(32);
            }
        });
    }

    /**
     * İlişkiler
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(QuotationItem::class);
    }

    public function views()
    {
        return $this->hasMany(QuotationView::class);
    }

    public function selectedCompany()
    {
        return $this->belongsTo(InsuranceCompany::class, 'selected_company_id');
    }

    public function convertedPolicy()
    {
        return $this->belongsTo(Policy::class, 'converted_policy_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Scope'lar
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeConverted($query)
    {
        return $query->where('status', 'converted');
    }

    /**
     * Paylaşım URL'i
     */
    public function getShareUrlAttribute(): string
    {
        return url("/quotation/view/{$this->shared_link_token}");
    }

    /**
     * Geçerli mi?
     */
    public function isValid(): bool
    {
        return $this->valid_until->isFuture();
    }

    /**
     * Süresi dolmuş mu?
     */
    public function isExpired(): bool
    {
        return $this->valid_until->isPast() && $this->status !== 'converted';
    }

    /**
     * Görüntüleme sayısını artır
     */
    public function incrementViewCount(): void
    {
        $this->increment('view_count');

        if ($this->status === 'sent') {
            $this->update(['status' => 'viewed']);
        }
    }

    /**
     * Poliçeye dönüştür
     */
    public function convertToPolicy(int $policyId, int $companyId): void
    {
        $this->update([
            'status' => 'converted',
            'converted_policy_id' => $policyId,
            'selected_company_id' => $companyId,
            'converted_at' => now(),
        ]);
    }

    /**
     * En düşük fiyatlı teklif
     */
    public function getLowestPriceItemAttribute()
    {
        return $this->items()->orderBy('premium_amount', 'asc')->first();
    }

    /**
     * Önerilen teklif
     */
    public function getRecommendedItemAttribute()
    {
        return $this->items()->where('is_recommended', true)->first();
    }
}
