<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class QuotationDocument extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'quotation_id',
        'uploaded_by',
        'file_name',
        'file_path',
        'file_type',
        'file_size',
        'document_type',
        'description',
    ];

    public function quotation()
    {
        return $this->belongsTo(Quotation::class);
    }

    public function uploadedBy()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }

    public function getFileSizeFormattedAttribute(): string
    {
        $bytes = $this->file_size;
        if ($bytes >= 1048576) {
            return number_format($bytes / 1048576, 2) . ' MB';
        } elseif ($bytes >= 1024) {
            return number_format($bytes / 1024, 2) . ' KB';
        } else {
            return $bytes . ' B';
        }
    }

    public function getFileUrlAttribute(): string
    {
        return asset('storage/' . str_replace('public/', '', $this->file_path));
    }
}
