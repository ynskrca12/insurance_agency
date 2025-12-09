<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentPlan extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'policy_id',
    //     'customer_id',
    //     'total_amount',
    //     'installment_count',
    //     'payment_type',
    //     'plan_details',
    // ];

    protected $guarded = [];

    protected $casts = [
        'total_amount' => 'decimal:2',
        'plan_details' => 'array',
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

    public function installments()
    {
        return $this->hasMany(Installment::class);
    }

    /**
     * Peşin mi?
     */
    public function isCash(): bool
    {
        return $this->payment_type === 'cash';
    }

    /**
     * Taksitli mi?
     */
    public function isInstallment(): bool
    {
        return $this->payment_type === 'installment';
    }

    /**
     * Ödenen toplam tutar
     */
    public function getPaidAmountAttribute(): float
    {
        return $this->installments()->where('status', 'paid')->sum('amount');
    }

    /**
     * Kalan tutar
     */
    public function getRemainingAmountAttribute(): float
    {
        return $this->total_amount - $this->paid_amount;
    }

    /**
     * Ödeme durumu (%)
     */
    public function getPaymentProgressAttribute(): int
    {
        if ($this->total_amount == 0) {
            return 0;
        }

        return (int)(($this->paid_amount / $this->total_amount) * 100);
    }

    /**
     * Tüm taksitler ödendi mi?
     */
    public function isFullyPaid(): bool
    {
        return $this->remaining_amount <= 0;
    }

    /**
     * Gecikmiş taksit var mı?
     */
    public function hasOverdueInstallments(): bool
    {
        return $this->installments()->where('status', 'overdue')->exists();
    }

    /**
     * Taksitleri oluştur
     */
    public function generateInstallments(): void
    {
        if ($this->isCash()) {
            // Peşin ödeme - tek taksit
            $this->installments()->create([
                'installment_number' => 1,
                'amount' => $this->total_amount,
                'due_date' => $this->policy->start_date,
                'status' => 'pending',
            ]);
        } else {
            // Taksitli ödeme
            $installmentAmount = $this->total_amount / $this->installment_count;
            $startDate = $this->policy->start_date;

            for ($i = 1; $i <= $this->installment_count; $i++) {
                $this->installments()->create([
                    'installment_number' => $i,
                    'amount' => round($installmentAmount, 2),
                    'due_date' => $startDate->copy()->addMonths($i - 1),
                    'status' => 'pending',
                ]);
            }
        }
    }
}
