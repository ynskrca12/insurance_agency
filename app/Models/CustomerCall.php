<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerCall extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'customer_id',
    //     'user_id',
    //     'called_at',
    //     'duration',
    //     'outcome',
    //     'notes',
    //     'next_call_date',
    // ];

    protected $guarded = [];

    protected $casts = [
        'called_at' => 'datetime',
        'next_call_date' => 'date',
    ];

    /**
     * İlişkiler
     */
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Scope'lar
     */
    public function scopeAnswered($query)
    {
        return $query->where('outcome', 'answered');
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('called_at', 'desc');
    }

    /**
     * Süre (dakika)
     */
    public function getDurationInMinutesAttribute(): ?int
    {
        return $this->duration ? (int)($this->duration / 60) : null;
    }

    /**
     * Sonuç label
     */
    public function getOutcomeLabelAttribute(): string
    {
        $labels = [
            'answered' => 'Cevaplandı',
            'no_answer' => 'Cevap Yok',
            'busy' => 'Meşgul',
            'wrong_number' => 'Yanlış Numara',
            'call_back' => 'Geri Aranacak',
        ];

        return $labels[$this->outcome] ?? $this->outcome;
    }
}
