<?php

namespace App\Models;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CustomerNote extends Model
{
    use HasFactory, BelongsToTenant;

    // protected $fillable = [
    //     'customer_id',
    //     'user_id',
    //     'note_type',
    //     'note',
    //     'next_action_date',
    // ];

    protected $guarded = [];

    protected $casts = [
        'next_action_date' => 'date',
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
    public function scopeByType($query, string $type)
    {
        return $query->where('note_type', $type);
    }

    public function scopeRecent($query)
    {
        return $query->orderBy('created_at', 'desc');
    }

    /**
     * Not tipi label
     */
    public function getNoteTypeLabelAttribute(): string
    {
        $labels = [
            'note' => 'Not',
            'call' => 'Arama',
            'meeting' => 'Toplantı',
            'email' => 'E-posta',
            'sms' => 'SMS',
        ];

        return $labels[$this->note_type] ?? $this->note_type;
    }
}
