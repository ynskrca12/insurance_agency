<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'title',
    //     'description',
    //     'task_type',
    //     'related_type',
    //     'related_id',
    //     'assigned_to_user_id',
    //     'due_date',
    //     'due_time',
    //     'priority',
    //     'status',
    //     'completed_at',
    //     'result_notes',
    //     'created_by',
    // ];

    protected $guarded = [];

    protected $casts = [
        'due_date' => 'date',
        'completed_at' => 'datetime',
    ];

    /**
     * İlişkiler
     */
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'assigned_to_user_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function related()
    {
        return $this->morphTo();
    }

    /**
     * Scope'lar
     */
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

    public function scopeOverdue($query)
    {
        return $query->where('due_date', '<', today())
                     ->whereNotIn('status', ['completed', 'cancelled']);
    }

    public function scopeDueToday($query)
    {
        return $query->where('due_date', today())
                     ->whereNotIn('status', ['completed', 'cancelled']);
    }

    public function scopeHighPriority($query)
    {
        return $query->whereIn('priority', ['high', 'urgent']);
    }

    public function scopeAssignedToUser($query, int $userId)
    {
        return $query->where('assigned_to_user_id', $userId);
    }

    /**
     * Beklemede mi?
     */
    public function isPending(): bool
    {
        return $this->status === 'pending';
    }

    /**
     * Tamamlandı mı?
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Gecikmiş mi?
     */
    public function isOverdue(): bool
    {
        return $this->due_date->isPast() && !$this->isCompleted();
    }

    /**
     * Bugün mü?
     */
    public function isDueToday(): bool
    {
        return $this->due_date->isToday();
    }

    /**
     * Tamamlandı olarak işaretle
     */
    public function markAsCompleted(?string $resultNotes = null): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
            'result_notes' => $resultNotes,
        ]);
    }

    /**
     * İptal edildi olarak işaretle
     */
    public function markAsCancelled(): void
    {
        $this->update(['status' => 'cancelled']);
    }

    /**
     * Devam ediyor olarak işaretle
     */
    public function markAsInProgress(): void
    {
        $this->update(['status' => 'in_progress']);
    }

    /**
     * Görev tipi label
     */
    public function getTaskTypeLabelAttribute(): string
    {
        $labels = [
            'call' => 'Arama',
            'follow_up' => 'Takip',
            'renewal' => 'Yenileme',
            'quotation_prepare' => 'Teklif Hazırlama',
            'document_collect' => 'Evrak Toplama',
            'payment_collect' => 'Ödeme Takibi',
            'other' => 'Diğer',
        ];

        return $labels[$this->task_type] ?? $this->task_type;
    }

    /**
     * Durum label
     */
    public function getStatusLabelAttribute(): string
    {
        $labels = [
            'pending' => 'Bekliyor',
            'in_progress' => 'Devam Ediyor',
            'completed' => 'Tamamlandı',
            'cancelled' => 'İptal Edildi',
        ];

        return $labels[$this->status] ?? $this->status;
    }

    /**
     * Öncelik label
     */
    public function getPriorityLabelAttribute(): string
    {
        $labels = [
            'low' => 'Düşük',
            'normal' => 'Normal',
            'high' => 'Yüksek',
            'urgent' => 'Acil',
        ];

        return $labels[$this->priority] ?? $this->priority;
    }

    /**
     * Durum badge rengi
     */
    public function getStatusColorAttribute(): string
    {
        $colors = [
            'pending' => 'warning',
            'in_progress' => 'info',
            'completed' => 'success',
            'cancelled' => 'secondary',
        ];

        return $colors[$this->status] ?? 'secondary';
    }

    /**
     * Öncelik badge rengi
     */
    public function getPriorityColorAttribute(): string
    {
        $colors = [
            'low' => 'secondary',
            'normal' => 'info',
            'high' => 'warning',
            'urgent' => 'danger',
        ];

        return $colors[$this->priority] ?? 'secondary';
    }
}
