<?php

namespace App\Models;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory, BelongsToTenant;

    // protected $fillable = [
    //     'name',
    //     'type',
    //     'subject',
    //     'message',
    //     'target_type',
    //     'target_filter',
    //     'status',
    //     'scheduled_at',
    //     'started_at',
    //     'completed_at',
    //     'total_recipients',
    //     'sent_count',
    //     'failed_count',
    //     'created_by',
    // ];

    protected $guarded = [];

    protected $casts = [
        'target_filter' => 'array',
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    // ✅ İLİŞKİLER
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function recipients()
    {
        return $this->hasMany(CampaignRecipient::class);
    }

    // Scope'lar
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }

    public function scopeScheduled($query)
    {
        return $query->where('status', 'scheduled');
    }

    public function scopeSent($query)
    {
        return $query->where('status', 'sent');
    }

    public function scopeFailed($query)
    {
        return $query->where('status', 'failed');
    }

    // Accessor'lar
    public function getSuccessRateAttribute()
    {
        if ($this->total_recipients == 0) {
            return 0;
        }
        return ($this->sent_count / $this->total_recipients) * 100;
    }

    // Yardımcı metodlar
    public function isDraft(): bool
    {
        return $this->status === 'draft';
    }

    public function isSending(): bool
    {
        return $this->status === 'sending';
    }

    public function isSent(): bool
    {
        return $this->status === 'sent';
    }
}
