<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationActivityLog extends Model
{
    protected $fillable = [
        'quotation_id',
        'user_id',
        'action',
        'description',
        'old_values',
        'new_values',
        'ip_address',
        'user_agent',
    ];

    protected $casts = [
        'old_values' => 'array',
        'new_values' => 'array',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getUserNameAttribute(): string
    {
        return $this->user ? $this->user->name : 'Sistem';
    }
}
