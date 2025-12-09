<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MessageTemplate extends Model
{
    use HasFactory;

    // protected $fillable = [
    //     'name',
    //     'type',
    //     'subject',
    //     'content',
    //     'available_variables',
    //     'category',
    //     'is_active',
    //     'is_default',
    //     'created_by',
    // ];

    protected $guarded = [];

    protected $casts = [
        'available_variables' => 'array',
        'is_active' => 'boolean',
        'is_default' => 'boolean',
    ];

    /**
     * İlişkiler
     */
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function campaigns()
    {
        return $this->hasMany(Campaign::class, 'template_id');
    }

    /**
     * Scope'lar
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }

    public function scopeByType($query, string $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByCategory($query, string $category)
    {
        return $query->where('category', $category);
    }

    /**
     * Değişkenleri değerlerle değiştir
     */
    public function render(array $data): string
    {
        $content = $this->content;

        foreach ($data as $key => $value) {
            $content = str_replace("{" . $key . "}", $value, $content);
        }

        return $content;
    }

    /**
     * Tip label
     */
    public function getTypeLabelAttribute(): string
    {
        $labels = [
            'sms' => 'SMS',
            'email' => 'E-posta',
            'whatsapp' => 'WhatsApp',
        ];

        return $labels[$this->type] ?? $this->type;
    }

    /**
     * Kategori label
     */
    public function getCategoryLabelAttribute(): string
    {
        $labels = [
            'renewal' => 'Yenileme',
            'payment' => 'Ödeme',
            'welcome' => 'Hoşgeldin',
            'campaign' => 'Kampanya',
            'custom' => 'Özel',
        ];

        return $labels[$this->category] ?? $this->category;
    }
}
