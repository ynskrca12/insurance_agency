<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CampaignLog extends Model
{
    use HasFactory;

    public $timestamps = false;

    // protected $fillable = [
    //     'campaign_id',
    //     'customer_id',
    //     'status',
    //     'message_content',
    //     'error_message',
    //     'sent_at',
    // ];

    protected $guarded = [];

    protected $casts = [
        'sent_at' => 'datetime',
    ];

    /**
     * İlişkiler
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    /**
     * Başarılı mı?
     */
    public function isSuccess(): bool
    {
        return $this->status === 'sent';
    }

    /**
     * Başarısız mı?
     */
    public function isFailed(): bool
    {
        return $this->status === 'failed';
    }
}
