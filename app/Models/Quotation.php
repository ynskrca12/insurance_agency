<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;

class Quotation extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $guarded = [];

    protected $casts = [
        'vehicle_info' => 'array',
        'property_info' => 'array',
        'coverage_details' => 'array',
        'valid_until' => 'date',
        'converted_at' => 'datetime',
        'pdf_generated_at' => 'datetime',
        'last_emailed_at' => 'datetime',
        'customer_responded_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($quotation) {
            if (!$quotation->shared_link_token) {
                $quotation->shared_link_token = Str::random(32);
            }
        });

        // Aktivite logu
        static::created(function ($quotation) {
            $quotation->logActivity('created', 'Teklif oluşturuldu');
        });

        static::updated(function ($quotation) {
            if ($quotation->wasChanged('status')) {
                $quotation->logActivity('status_changed', 'Durum değiştirildi: ' . $quotation->status);
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

    public function revisions()
    {
        return $this->hasMany(QuotationRevision::class)->orderBy('revision_number', 'desc');
    }

    public function documents()
    {
        return $this->hasMany(QuotationDocument::class)->orderBy('created_at', 'desc');
    }

    public function emails()
    {
        return $this->hasMany(QuotationEmail::class)->orderBy('created_at', 'desc');
    }

    public function activityLogs()
    {
        return $this->hasMany(QuotationActivityLog::class)->orderBy('created_at', 'desc');
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

    public function scopeValid($query)
    {
        return $query->where('valid_until', '>=', now());
    }

    public function scopeExpired($query)
    {
        return $query->where('valid_until', '<', now())->where('status', '!=', 'converted');
    }

    /**
     * Accessor & Mutators
     */
    public function getShareUrlAttribute(): string
    {
        return url("/quotation/view/{$this->shared_link_token}");
    }

    public function getTypeDisplayAttribute(): string
    {
        $types = [
            'kasko' => 'Kasko',
            'trafik' => 'Trafik',
            'konut' => 'Konut',
            'dask' => 'DASK',
            'saglik' => 'Sağlık',
            'hayat' => 'Hayat',
            'tss' => 'TSS',
        ];

        return $types[$this->quotation_type] ?? ucfirst($this->quotation_type);
    }

    /**
     * Geçerli mi?
     */
    public function isValid(): bool
    {
        return $this->valid_until->isFuture() && $this->status !== 'converted';
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

        $this->logActivity('viewed', 'Teklif görüntülendi');
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

        $this->logActivity('converted', 'Poliçeye dönüştürüldü');
    }

    /**
     * En düşük fiyatlı teklif
     */
    public function getLowestPriceItemAttribute()
    {
        return $this->items()->orderBy('premium_amount', 'asc')->first();
    }

    /**
     * En yüksek fiyatlı teklif
     */
    public function getHighestPriceItemAttribute()
    {
        return $this->items()->orderBy('premium_amount', 'desc')->first();
    }

    /**
     * Önerilen teklif
     */
    public function getRecommendedItemAttribute()
    {
        return $this->items()->where('is_recommended', true)->first();
    }

    /**
     * Ortalama fiyat
     */
    public function getAveragePriceAttribute()
    {
        return $this->items()->avg('premium_amount') ?? 0;
    }

    /**
     * PDF var mı?
     */
    public function hasPdf(): bool
    {
        return $this->pdf_path && file_exists(storage_path('app/' . $this->pdf_path));
    }

    /**
     * PDF URL
     */
    public function getPdfUrl(): ?string
    {
        if ($this->hasPdf()) {
            return asset('storage/' . str_replace('public/', '', $this->pdf_path));
        }
        return null;
    }

    /**
     * Email gönderildi mi?
     */
    public function hasBeenEmailed(): bool
    {
        return $this->email_sent_count > 0;
    }

    /**
     * Aktivite logla
     */
    public function logActivity(string $action, string $description = null, array $oldValues = null, array $newValues = null): void
    {
        $this->activityLogs()->create([
            'user_id' => auth()->id(),
            'action' => $action,
            'description' => $description,
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Revizyon oluştur
     */
    public function createRevision(string $notes = null): void
    {
        $lastRevision = $this->revisions()->first();
        $newRevisionNumber = $lastRevision ? $lastRevision->revision_number + 1 : 1;

        $this->revisions()->create([
            'revision_number' => $newRevisionNumber,
            'created_by' => auth()->id(),
            'items_data' => $this->items->toArray(),
            'vehicle_info' => $this->vehicle_info,
            'property_info' => $this->property_info,
            'coverage_details' => $this->coverage_details,
            'valid_until' => $this->valid_until,
            'notes' => $notes,
        ]);

        $this->logActivity('revision_created', "Revizyon #{$newRevisionNumber} oluşturuldu");
    }
}
