<?php

namespace App\Models;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory, BelongsToTenant;

    // protected $fillable = [
    //     'title',
    //     'description',
    //     'category',
    //     'priority',
    //     'status',
    //     'assigned_to',
    //     'assigned_by',
    //     'customer_id',
    //     'policy_id',
    //     'due_date',
    //     'reminder_date',
    //     'completed_at',
    //     'notes',
    // ];

    protected $guarded = [];

    protected $casts = [
        'due_date' => 'datetime',
        'reminder_date' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // İlişkiler
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function assignedBy()
    {
        return $this->belongsTo(User::class, 'assigned_by');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    public function comments()
    {
        return $this->hasMany(TaskComment::class);
    }

    public function activityLogs()
    {
        return $this->hasMany(TaskActivity::class);
    }

    // Scope'lar
    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', now())
                    ->whereNotIn('status', ['completed', 'cancelled']);
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }

    public function scopeInProgress($query)
    {
        return $query->where('status', 'in_progress');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    public function scopeMyTasks($query, $userId)
    {
        return $query->where('assigned_to', $userId);
    }

    public function scopeDueToday($query)
    {
        return $query->whereDate('due_date', now());
    }

    public function scopeDueThisWeek($query)
    {
        return $query->whereBetween('due_date', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    // Accessor'lar
    public function getIsOverdueAttribute()
    {
        return $this->due_date < now() && !in_array($this->status, ['completed', 'cancelled']);
    }

    public function getCategoryLabelAttribute()
    {
        $labels = [
            'call' => 'Arama',
            'meeting' => 'Toplantı',
            'follow_up' => 'Takip',
            'document' => 'Evrak',
            'renewal' => 'Yenileme',
            'payment' => 'Ödeme',
            'quotation' => 'Teklif',
            'other' => 'Diğer',
        ];

        return $labels[$this->category] ?? $this->category;
    }

    public function getPriorityLabelAttribute()
    {
        $labels = [
            'low' => 'Düşük',
            'normal' => 'Normal',
            'high' => 'Yüksek',
            'urgent' => 'Acil',
        ];

        return $labels[$this->priority] ?? $this->priority;
    }

    public function getStatusLabelAttribute()
    {
        $labels = [
            'pending' => 'Bekliyor',
            'in_progress' => 'Devam Ediyor',
            'completed' => 'Tamamlandı',
            'cancelled' => 'İptal',
        ];

        return $labels[$this->status] ?? $this->status;
    }
}
