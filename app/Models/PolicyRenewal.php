<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PolicyRenewal extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'policy_id',
    //     'customer_id',
    //     'status',
    //     'contacted_at',
    //     'contacted_by',
    //     'next_contact_date',
    //     'notes',
    //     'rejection_reason',
    //     'competitor_name',
    //     'new_policy_id',
    // ];

    protected $guarded = [];

    protected $casts = [
        'contacted_at' => 'datetime',
        'next_contact_date' => 'date',
    ];

    /**
     * İlişkiler
     */
    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function contactedBy()
    {
        return $this->belongsTo(User::class, 'contacted_by');
    }

    public function newPolicy()
    {
        return $this->belongsTo(Policy::class, 'new_policy_id');
    }

    /**
     * Scope'lar
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeContacted($query)
    {
        return $query->where('status', 'contacted');
    }

    public function scopeApproved($query)
    {
        return $query->where('status', 'approved');
    }

    public function scopeRejected($query)
    {
        return $query->where('status', 'rejected');
    }

    /**
     * Beklemede mi?
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Yenilendi mi?
     */
    public function isRenewed(): bool
    {
        return $this->status === 'renewed';
    }

    /**
     * İletişime geç olarak işaretle
     */
    public function markAsContacted(int $userId, ?string $notes = null): void
    {
        $this->update([
            'status' => 'contacted',
            'contacted_at' => now(),
            'contacted_by' => $userId,
            'notes' => $notes,
        ]);
    }

    /**
     * Onaylandı olarak işaretle
     */
    public function markAsApproved(): void
    {
        $this->update(['status' => 'approved']);
    }

    /**
     * Reddedildi olarak işaretle
     */
    public function markAsRejected(string $reason, ?string $competitorName = null): void
    {
        $this->update([
            'status' => 'rejected',
            'rejection_reason' => $reason,
            'competitor_name' => $competitorName,
        ]);
    }

    /**
     * Yenilendi olarak işaretle
     */
    public function markAsRenewed(int $newPolicyId): void
    {
        $this->update([
            'status' => 'renewed',
            'new_policy_id' => $newPolicyId,
        ]);
    }

    /**
     * Durum label
     */
    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'pending' => 'Bekliyor',
            'contacted' => 'Görüşüldü',
            'quotation_sent' => 'Teklif Verildi',
            'approved' => 'Onaylandı',
            'rejected' => 'Reddedildi',
            'lost_to_competitor' => 'Rakibe Gitti',
            'renewed' => 'Yenilendi',
        ];

        return $labels[$this->status] ?? $this->status;
    }
}
