<?php

namespace App\Models;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Schema;

class PaymentPlan extends Model
{
    use HasFactory, BelongsToTenant;

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
     * ✅ Ödeme durumunu güncelle
     */
    public function updatePaymentStatus(): void
    {
        $totalInstallments = $this->installments()->count();
        $paidInstallments = $this->installments()->where('status', 'paid')->count();
        $overdueInstallments = $this->installments()->overdue()->count();

        // Durum belirleme
        if ($paidInstallments === $totalInstallments) {
            $status = 'completed'; // Tüm taksitler ödendi
        } elseif ($paidInstallments > 0) {
            $status = 'partial'; // Kısmen ödendi
        } elseif ($overdueInstallments > 0) {
            $status = 'overdue'; // Gecikmiş
        } else {
            $status = 'pending'; // Bekliyor
        }

        // ✅ Schema facade kullan
        if (Schema::hasColumn('payment_plans', 'status')) {
            $this->update(['status' => $status]);
        }

        // Ödeme istatistiklerini güncelle
        $updateData = [];

        if (Schema::hasColumn('payment_plans', 'paid_amount')) {
            $updateData['paid_amount'] = $this->paid_amount;
        }

        if (Schema::hasColumn('payment_plans', 'remaining_amount')) {
            $updateData['remaining_amount'] = $this->remaining_amount;
        }

        if (!empty($updateData)) {
            $this->update($updateData);
        }
    }

    /**
     * ✅ Ödeme istatistiklerini güncelle (Basit versiyon)
     */
    public function updatePaymentStats(): void
    {
        // İstatistikleri hesapla
        $paidAmount = $this->installments()->where('status', 'paid')->sum('amount');
        $remainingAmount = $this->total_amount - $paidAmount;

        // Sadece istatistik sütunları varsa güncelle
        $updateData = [];

        if (Schema::hasColumn('payment_plans', 'paid_amount')) {
            $updateData['paid_amount'] = $paidAmount;
        }

        if (Schema::hasColumn('payment_plans', 'remaining_amount')) {
            $updateData['remaining_amount'] = $remainingAmount;
        }

        if (!empty($updateData)) {
            $this->update($updateData);
        }

        // Policy durumunu da güncelle (tüm taksitler ödendiyse)
        if ($this->isFullyPaid() && $this->policy) {
            // Poliçenin payment_status'unu güncelle (varsa)
            if (Schema::hasColumn('policies', 'payment_status')) {
                $this->policy->update(['payment_status' => 'paid']);
            }
        }
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
