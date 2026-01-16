<?php

namespace App\Models;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Carbon\Carbon;

class Policy extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    // protected $fillable = [
    //     'customer_id',
    //     'insurance_company_id',
    //     'policy_number',
    //     'policy_type',
    //     'vehicle_plate',
    //     'vehicle_brand',
    //     'vehicle_model',
    //     'vehicle_year',
    //     'vehicle_chassis_no',
    //     'property_address',
    //     'property_area',
    //     'property_floor',
    //     'start_date',
    //     'end_date',
    //     'premium_amount',
    //     'commission_rate',
    //     'commission_amount',
    //     'payment_type',
    //     'installment_count',
    //     'status',
    //     'renewed_from_policy_id',
    //     'renewed_to_policy_id',
    //     'document_path',
    //     'notes',
    //     'created_by',
    // ];

    protected $guarded = [];

    protected $casts = [
        'start_date' => 'date',
        'end_date' => 'date',
        'premium_amount' => 'decimal:2',
        'commission_rate' => 'decimal:2',
        'commission_amount' => 'decimal:2',
    ];

    /**
     * İlişkiler
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function insuranceCompany()
    {
        return $this->belongsTo(InsuranceCompany::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function renewal()
    {
        return $this->hasOne(PolicyRenewal::class);
    }

    public function reminders()
    {
        return $this->hasMany(RenewalReminder::class);
    }

    public function paymentPlan()
    {
        return $this->hasOne(PaymentPlan::class);
    }

    public function renewedFromPolicy()
    {
        return $this->belongsTo(Policy::class, 'renewed_from_policy_id');
    }

    public function renewedToPolicy()
    {
        return $this->belongsTo(Policy::class, 'renewed_to_policy_id');
    }

    /**
     * Scope'lar
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeExpiringSoon($query, $days = 90)
    {
        return $query->where('status', 'active')
                    ->whereBetween('end_date', [
                        now(),
                        now()->addDays($days)
                    ]);
    }

    public function scopeCritical($query)
    {
        return $query->where('status', 'critical');
    }

    public function scopeExpired($query)
    {
        return $query->where('status', 'expired');
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('policy_type', $type);
    }

     /**
     * Activity Logs ilişkisi (Polymorphic)
     */
    public function activityLogs()
    {
        return $this->morphMany(ActivityLog::class, 'subject');
    }

    /**
     * Bitimine kaç gün kaldı?
     */
    public function getDaysUntilExpiryAttribute(): int
    {
        return now()->diffInDays($this->end_date, false);
    }
    public function getStatusAttribute($value)
    {
        if (in_array($value, ['renewed', 'cancelled', 'lost'])) {
            return $value;
        }

        $daysUntilExpiry = $this->days_until_expiry;

        if ($daysUntilExpiry < 0) {
            return 'expired'; // Süresi dolmuş
        } elseif ($daysUntilExpiry <= 7) {
            return 'critical'; // 7 gün veya daha az
        } elseif ($daysUntilExpiry <= 90) {
            return 'expiring_soon'; // 90 gün içinde
        } else {
            return 'active'; // Normal aktif
        }
    }

    public function getRawStatusAttribute()
    {
        return $this->attributes['status'];
    }

    /**
     * Poliçe aktif mi?
     */
    public function isActive(): bool
    {
        return $this->status === 'active';
    }

    /**
     * Poliçe süresi dolmuş mu?
     */
    public function isExpired(): bool
    {
        return $this->end_date->isPast();
    }

    /**
     * Durumu otomatik güncelle
     */
    public function updateStatus(): void
    {
        $daysUntilExpiry = $this->days_until_expiry;

        if ($daysUntilExpiry < 0) {
            $status = 'expired';
        } elseif ($daysUntilExpiry <= 7) {
            $status = 'critical';
        } elseif ($daysUntilExpiry <= 30) {
            $status = 'expiring_soon';
        } else {
            $status = 'active';
        }

        if ($this->status !== $status && $this->status !== 'renewed' && $this->status !== 'cancelled') {
            $this->update(['status' => $status]);
        }
    }

    /**
     * Araç poliçesi mi?
     */
    public function isVehiclePolicy(): bool
    {
        return in_array($this->policy_type, ['kasko', 'trafik']);
    }

    /**
     * Konut poliçesi mi?
     */
    public function isPropertyPolicy(): bool
    {
        return in_array($this->policy_type, ['konut', 'dask']);
    }

    /**
     * Döküman URL
     */
    public function getDocumentUrlAttribute(): ?string
    {
        return $this->document_path ? asset('storage/' . $this->document_path) : null;
    }

    /**
     * Poliçe türü label
     */
    public function getPolicyTypeLabelAttribute(): string
    {
        $labels = [
            'kasko' => 'Kasko',
            'trafik' => 'Trafik',
            'konut' => 'Konut',
            'dask' => 'DASK',
            'saglik' => 'Sağlık',
            'hayat' => 'Hayat',
            'tss' => 'TSS',
        ];

        return $labels[$this->policy_type] ?? $this->policy_type;
    }
}
