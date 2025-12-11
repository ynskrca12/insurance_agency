<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class PolicyRenewal extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'policy_id',
    //     'customer_id',
    //     'renewal_date',
    //     'status',
    //     'priority',
    //     'contacted_at',
    //     'contacted_by',
    //     'next_contact_date',
    //     'contact_notes',
    //     'notes',
    //     'rejection_reason',
    //     'competitor_name',
    //     'lost_reason',
    //     'new_policy_id',
    //     'renewed_at',
    //     'created_by',
    // ];

    protected $guarded = [];

    protected $casts = [
        'renewal_date' => 'date',
        'contacted_at' => 'datetime',
        'next_contact_date' => 'date',
        'renewed_at' => 'datetime',
    ];

    // İlişkiler
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

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function reminders()
    {
        return $this->hasMany(RenewalReminder::class, 'policy_renewal_id');
    }

    // Scope'lar
    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeContacted($query)
    {
        return $query->whereIn('status', ['contacted', 'quotation_sent', 'approved']);
    }

    public function scopeRenewed($query)
    {
        return $query->where('status', 'renewed');
    }

    public function scopeLost($query)
    {
        return $query->whereIn('status', ['rejected', 'lost_to_competitor', 'lost']);
    }

    public function scopeCritical($query)
    {
        return $query->whereBetween('renewal_date', [now(), now()->addDays(7)])
                    ->whereNotIn('status', ['renewed', 'rejected', 'lost_to_competitor', 'lost']);
    }

    public function scopeUpcoming($query)
    {
        return $query->whereBetween('renewal_date', [now(), now()->addDays(30)])
                    ->whereNotIn('status', ['renewed', 'rejected', 'lost_to_competitor', 'lost']);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('renewal_date', now())
                    ->whereNotIn('status', ['renewed', 'rejected', 'lost_to_competitor', 'lost']);
    }

    public function scopeOverdue($query)
    {
        return $query->where('renewal_date', '<', now())
                    ->whereNotIn('status', ['renewed', 'rejected', 'lost_to_competitor', 'lost']);
    }

    // Accessor'lar
    public function getDaysUntilRenewalAttribute()
    {
        return (int) now()->diffInDays($this->renewal_date, false);
    }

    public function getIsCriticalAttribute()
    {
        $days = $this->days_until_renewal;
        return $days >= 0 && $days <= 7;
    }

    public function getIsOverdueAttribute()
    {
        return $this->days_until_renewal < 0;
    }

    // Yardımcı Metodlar
    public function updatePriority()
    {
        $daysLeft = $this->days_until_renewal;

        if ($daysLeft < 0) {
            $this->priority = 'critical';
        } elseif ($daysLeft <= 7) {
            $this->priority = 'critical';
        } elseif ($daysLeft <= 30) {
            $this->priority = 'high';
        } elseif ($daysLeft <= 60) {
            $this->priority = 'normal';
        } else {
            $this->priority = 'low';
        }

        $this->save();
    }
}
