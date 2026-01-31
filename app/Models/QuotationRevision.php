<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuotationRevision extends Model
{
    protected $fillable = [
        'quotation_id',
        'revision_number',
        'created_by',
        'items_data',
        'vehicle_info',
        'property_info',
        'coverage_details',
        'valid_until',
        'notes',
    ];

    protected $casts = [
        'items_data' => 'array',
        'vehicle_info' => 'array',
        'property_info' => 'array',
        'coverage_details' => 'array',
        'valid_until' => 'date',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
