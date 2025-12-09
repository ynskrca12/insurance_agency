<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'name',
    //     'description',
    //     'type',
    //     'template_id',
    //     'target_filter',
    //     'scheduled_at',
    //     'status',
    //     'target_count',
    //     'sent_count',
    //     'success_count',
    //     'fail_count',
    //     'started_at',
    //     'completed_at',
    //     'created_by',
    // ];

    protected $guarded = [];

    protected $casts = [
        'target_filter' => 'array',
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    /**
     * İlişkiler
     */
    public function template()
    {
        return $this->belongsTo(MessageTemplate::class, 'template_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function logs()
    {
        return $this->hasMany(CampaignLog::class);
    }

    /**
     * Scope'lar
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeCompleted($query)
    {
        return $query->where('status', 'completed');
    }

    /**
     * Başarı oranı
     */
    public function getSuccessRateAttribute(): float
    {
        if ($this->sent_count === 0) {
            return 0;
        }

        return round(($this->success_count / $this->sent_count) * 100, 2);
    }

    /**
     * Taslak mı?
     */
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    /**
     * Gönderiliyor mu?
     */
    public function isSending(): bool
    {
        return $this->status === 'sending';
    }

    /**
     * Tamamlandı mı?
     */
    public function isCompleted(): bool
    {
        return $this->status === 'completed';
    }

    /**
     * Kampanyayı başlat
     */
    public function start(): void
    {
        $this->update([
            'status' => 'sending',
            'started_at' => now(),
        ]);
    }

    /**
     * Kampanyayı tamamla
     */
    public function complete(): void
    {
        $this->update([
            'status' => 'completed',
            'completed_at' => now(),
        ]);
    }

    /**
     * Gönderim sayacını artır
     */
    public function incrementSent(bool $success = true): void
    {
        $this->increment('sent_count');

        if ($success) {
            $this->increment('success_count');
        } else {
            $this->increment('fail_count');
        }
    }
}
