<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PaymentReminder extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'reminder_date' => 'datetime',
        'sent_at' => 'datetime',
    ];

    // İlişkiler
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function installment()
    {
        return $this->belongsTo(Installment::class);
    }
}
