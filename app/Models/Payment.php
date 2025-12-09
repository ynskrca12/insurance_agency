<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'customer_id',
    //     'policy_id',
    //     'installment_id',
    //     'amount',
    //     'payment_date',
    //     'payment_type',
    //     'receipt_number',
    //     'notes',
    //     'received_by',
    // ];

    protected $guarded = [];

    protected $casts = [
        'amount' => 'decimal:2',
        'payment_date' => 'date',
    ];

    /**
     * İlişkiler
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }

    public function receivedBy()
    {
        return $this->belongsTo(User::class, 'received_by');
    }

    /**
     * Scope'lar
     */
    public function scopeByCustomer($query, int $customerId)
    {
        return $query->where('customer_id', $customerId);
    }

    public function scopeByPolicy($query, int $policyId)
    {
        return $query->where('policy_id', $policyId);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('payment_date', 'desc');
    }

    public function scopeToday($query)
    {
        return $query->where('payment_date', today());
    }

    public function scopeThisMonth($query)
    {
        return $query->whereYear('payment_date', now()->year)
                     ->whereMonth('payment_date', now()->month);
    }

    /**
     * Ödeme tipi label
     */
    public function getPaymentTypeLabelAttribute(): string
    {
        $labels = [
            'cash' => 'Nakit',
            'card' => 'Kredi Kartı',
            'transfer' => 'Havale/EFT',
            'check' => 'Çek',
        ];

        return $labels[$this->payment_type] ?? $this->payment_type;
    }

    /**
     * Makbuz var mı?
     */
    public function hasReceipt(): bool
    {
        return !empty($this->receipt_number);
    }
}
