<?php

namespace App\Models;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CrossSellOpportunity extends Model
{
    use HasFactory, BelongsToTenant;

    // protected $fillable = [
    //     'customer_id',
    //     'suggested_product',
    //     'reason',
    //     'status',
    //     'priority',
    //     'contacted_at',
    //     'contacted_by',
    // ];

    protected $guarded = [];

    protected $casts = [
        'contacted_at' => 'datetime',
    ];

    /**
     * İlişkiler
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function contactedBy()
    {
        return $this->belongsTo(User::class, 'contacted_by');
    }

    /**
     * Scope'lar
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeHighPriority($query)
    {
        return $query->where('priority', '>=', 7)->orderBy('priority', 'desc');
    }

    public function scopeByProduct($query, string $product)
    {
        return $query->where('suggested_product', $product);
    }

    /**
     * Beklemede mi?
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Dönüştürüldü mü?
     */
    public function isConverted(): bool
    {
        return $this->status === 'converted';
    }

    /**
     * İletişime geçildi olarak işaretle
     */
    public function markAsContacted(int $userId): void
    {
        $this->update([
            'status' => 'contacted',
            'contacted_at' => now(),
            'contacted_by' => $userId,
        ]);
    }

    /**
     * Dönüştürüldü olarak işaretle
     */
    public function markAsConverted(): void
    {
        $this->update(['status' => 'converted']);
    }

    /**
     * Reddedildi olarak işaretle
     */
    public function markAsRejected(): void
    {
        $this->update(['status' => 'rejected']);
    }

    /**
     * Ürün label
     */
    public function getSuggestedProductLabelAttribute(): string
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

        return $labels[$this->suggested_product] ?? $this->suggested_product;
    }

    /**
     * Durum label
     */
    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'pending' => 'Bekliyor',
            'contacted' => 'Görüşüldü',
            'converted' => 'Dönüştürüldü',
            'rejected' => 'Reddedildi',
            'ignored' => 'Göz Ardı Edildi',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Öncelik badge rengi
     */
    public function getPriorityColorAttribute(): string
    {
        if ($this->priority >= 8) return 'danger';
        if ($this->priority >= 6) return 'warning';
        if ($this->priority >= 4) return 'info';
        return 'secondary';
    }
}
