<?php

namespace App\Models;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Installment extends Model
{
    use HasFactory, BelongsToTenant;

    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'due_date' => 'date',
        'paid_date' => 'date',
    ];

    /**
     * İlişkiler
     */
    public function paymentPlan()
    {
        return $this->belongsTo(PaymentPlan::class);
    }

    //  ÇOĞUL - Tüm ödemeler (Eğer kısmi ödeme varsa)
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    //  TEKİL - Son/Ana ödeme (Controller için)
    public function payment()
    {
        return $this->belongsTo(Payment::class, 'payment_id');
    }

    public function reminders()
    {
        return $this->hasMany(PaymentReminder::class);
    }

    /**
     * Scope'lar
     */
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->where('status', 'pending');
    }

    public function scopeDueToday($query)
    {
        return $query->whereDate('due_date', now())
                    ->where('status', 'pending');
    }

    public function scopeUpcoming($query, $days = 30)
    {
        return $query->whereBetween('due_date', [now(), now()->addDays($days)])
                    ->where('status', 'pending');
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopePaid($query)
    {
        return $query->where('status', 'paid');
    }

    /**
     * Ödendi mi?
     */
    public function isPaid(): bool
    {
        return $this->status === 'paid';
    }

    /**
     * Gecikmiş mi?
     */
    public function isOverdue(): bool
    {
        return $this->status === 'overdue' ||
               ($this->status === 'pending' && $this->due_date->isPast());
    }

    /**
     * Bugün mü?
     */
    public function isDueToday(): bool
    {
        return $this->due_date->isToday();
    }

    /**
     * Ödendi olarak işaretle
     */
    public function markAsPaid($paymentId, $paidDate, $paymentMethod)
    {
        $this->update([
            'status' => 'paid',
            'paid_date' => $paidDate,
            'payment_method' => $paymentMethod,
        ]);
    }

    /**
     * Durumu otomatik güncelle (Cron için)
     */
    public function updateStatus(): void
    {
        if ($this->status === 'pending' && $this->due_date->isPast()) {
            $this->update(['status' => 'overdue']);
        }
    }

    /**
     * Durum label
     */
    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'pending' => 'Bekliyor',
            'paid' => 'Ödendi',
            'overdue' => 'Gecikmiş',
            'partial' => 'Kısmi Ödendi',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Durum badge rengi
     */
    public function getStatusColorAttribute(): string
    {
        $colors = [
            'pending' => 'warning',
            'paid' => 'success',
            'overdue' => 'danger',
            'partial' => 'info',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Ödeme metodu label
     */
    public function getPaymentMethodLabelAttribute(): ?string
    {
        if (!$this->payment_method) {
            return null;
        }

        $labels = [
            'cash' => 'Nakit',
            'card' => 'Kredi Kartı',
            'transfer' => 'Havale',
            'check' => 'Çek',
        ];

        return $labels[$this->payment_method] ?? $this->payment_method;
    }
}
