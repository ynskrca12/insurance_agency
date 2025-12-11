<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RenewalReminder extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'policy_id',
    //     'customer_id',
    //     'reminder_type',
    //     'reminder_date',
    //     'channel',
    //     'status',
    //     'message_content',
    //     'sent_at',
    //     'error_message',
    //     'retry_count',
    // ];

    protected $guarded = [];

    protected $casts = [
        'reminder_date' => 'date',
        'sent_at' => 'datetime',
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

    public function policyRenewal()
    {
        return $this->belongsTo(PolicyRenewal::class, 'policy_renewal_id');
    }

    /**
     * Scope'lar
     */
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    public function scopeDueToday($query)
    {
        return $query->where('reminder_date', today());
    }

    /**
     * Gönderildi olarak işaretle
     */
    public function markAsSent(): void
    {
        $this->update([
            'status' => 'sent',
            'sent_at' => now(),
        ]);
    }

    /**
     * Başarısız olarak işaretle
     */
    public function markAsFailed(string $errorMessage): void
    {
        $this->update([
            'status' => 'failed',
            'error_message' => $errorMessage,
            'retry_count' => $this->retry_count + 1,
        ]);
    }

    /**
     * İptal et
     */
    public function cancel(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    /**
     * Hatırlatma türü label
     */
    public function getReminderTypeLabelAttribute(): string
    {
        $labels = [
            '30_days' => '30 Gün Önce',
            '15_days' => '15 Gün Önce',
            '7_days' => '7 Gün Önce',
            '1_day' => '1 Gün Önce',
        ];

        return $labels[$this->reminder_type] ?? $this->reminder_type;
    }
}
