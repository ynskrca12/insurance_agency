<?php

namespace App\Models;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    use HasFactory, BelongsToTenant;

    // protected $fillable = [
    //     'name',
    //     'type',
    //     'subject',
    //     'content',
    //     'variables',
    //     'is_active',
    //     'created_by',
    // ];

    protected $guarded = [];
    protected $casts = [
        'variables' => 'array',
        'is_active' => 'boolean',
    ];

    // İlişkiler
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // Scope'lar
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }
}
