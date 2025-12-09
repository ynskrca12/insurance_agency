<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class QuotationView extends Model
{
    use HasFactory;

    public $timestamps = false;

    // protected $fillable = [
    //     'quotation_id',
    //     'viewed_at',
    //     'ip_address',
    //     'user_agent',
    //     'device_type',
    // ];

    protected $guarded = [];

    protected $casts = [
        'viewed_at' => 'datetime',
    ];

    /**
     * İlişkiler
     */
    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }
}
