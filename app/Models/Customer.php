<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory, SoftDeletes;

    // protected $fillable = [
    //     'name',
    //     'email',
    //     'phone',
    //     'phone_secondary',
    //     'id_number',
    //     'birth_date',
    //     'address',
    //     'city',
    //     'district',
    //     'postal_code',
    //     'occupation',
    //     'workplace',
    //     'segments',
    //     'total_policies',
    //     'total_premium',
    //     'lifetime_value',
    //     'risk_score',
    //     'last_contact_date',
    //     'next_contact_date',
    //     'status',
    //     'notes',
    //     'created_by',
    // ];

    protected $guarded = [];

    protected $casts = [
        'birth_date' => 'date',
        'last_contact_date' => 'datetime',
        'next_contact_date' => 'date',
        'segments' => 'array',
        'total_premium' => 'decimal:2',
        'lifetime_value' => 'decimal:2',
    ];

    /**
     * İlişkiler
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function policies()
    {
        return $this->hasMany(Policy::class);
    }

    public function quotations()
    {
        return $this->hasMany(Quotation::class);
    }

    public function notes()
    {
        return $this->hasMany(CustomerNote::class);
    }

    public function calls()
    {
        return $this->hasMany(CustomerCall::class);
    }

    public function crossSellOpportunities()
    {
        return $this->hasMany(CrossSellOpportunity::class);
    }

    public function policyRenewals()
    {
        return $this->hasMany(PolicyRenewal::class);
    }

    public function paymentPlans()
    {
        return $this->hasMany(PaymentPlan::class);
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    /**
     * Aktif poliçeler
     */
    public function activePolicies()
    {
        return $this->policies()->where('status', 'active');
    }

    /**
     * Süresi yaklaşan poliçeler
     */
    public function expiringSoonPolicies()
    {
        return $this->policies()->where('status', 'expiring_soon');
    }

    /**
     * Müşteri aktif mi?
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * VIP müşteri mi?
     */
    public function isVIP(): bool
    {
        $segments = $this->segments ?? [];
        return in_array('VIP', $segments);
    }

    /**
     * Müşteri segmentlerini güncelle
     */
    public function addSegment(string $segment): void
    {
        $segments = $this->segments ?? [];
        if (!in_array($segment, $segments)) {
            $segments[] = $segment;
            $this->update(['segments' => $segments]);
        }
    }

    public function removeSegment(string $segment): void
    {
        $segments = $this->segments ?? [];
        $segments = array_diff($segments, [$segment]);
        $this->update(['segments' => array_values($segments)]);
    }

    /**
     * İstatistikleri güncelle
     */
    public function updateStats(): void
    {
        $this->update([
            'total_policies' => $this->policies()->count(),
            'total_premium' => $this->policies()->sum('premium_amount'),
            'lifetime_value' => $this->policies()->sum('commission_amount'),
        ]);
    }

    /**
     * Tam ad + telefon
     */
    public function getFullContactAttribute(): string
    {
        return "{$this->name} ({$this->phone})";
    }
}
