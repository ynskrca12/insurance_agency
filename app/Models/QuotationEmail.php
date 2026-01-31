<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class QuotationEmail extends Model
{
    protected $fillable = [
        'quotation_id',
        'sent_by',
        'recipient_email',
        'recipient_name',
        'subject',
        'body',
        'attachments',
        'status',
        'error_message',
        'sent_at',
        'opened_at',
        'clicked_at',
        'open_count',
        'click_count',
        'tracking_token',
    ];

    protected $casts = [
        'attachments' => 'array',
        'sent_at' => 'datetime',
        'opened_at' => 'datetime',
        'clicked_at' => 'datetime',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($email) {
            if (!$email->tracking_token) {
                $email->tracking_token = Str::random(64);
            }
        });
    }

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function sentBy()
    {
        return $this->belongsTo(User::class, 'sent_by');
    }

    public function markAsOpened(): void
    {
        if (!$this->opened_at) {
            $this->update([
                'opened_at' => now(),
                'status' => 'opened',
            ]);
        }
        $this->increment('open_count');
    }

    public function markAsClicked(): void
    {
        if (!$this->clicked_at) {
            $this->update([
                'clicked_at' => now(),
                'status' => 'clicked',
            ]);
        }
        $this->increment('click_count');
    }
}
