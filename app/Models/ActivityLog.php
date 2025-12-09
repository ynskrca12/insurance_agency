<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityLog extends Model
{
    use HasFactory;

    const UPDATED_AT = null;

    // protected $fillable = [
    //     'user_id',
    //     'subject_type',
    //     'subject_id',
    //     'action',
    //     'description',
    //     'properties',
    //     'ip_address',
    //     'user_agent',
    // ];

    protected $guarded = [];

    protected $casts = [
        'properties' => 'array',
        'created_at' => 'datetime',
    ];

    /**
     * İlişkiler
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function subject()
    {
        return $this->morphTo();
    }

    /**
     * Scope'lar
     */
    public function scopeByUser($query, int $userId)
    {
        return $query->where('user_id', $userId);
    }

    public function scopeBySubject($query, string $type, int $id)
    {
        return $query->where('subject_type', $type)->where('subject_id', $id);
    }

    public function scopeByAction($query, string $action)
    {
        return $query->where('action', $action);
    }

    public function scopeRecent($query, int $days = 7)
    {
        return $query->where('created_at', '>=', now()->subDays($days));
    }

    /**
     * Log kaydı oluştur
     */
    public static function log(
        string $action,
        string $description,
        ?Model $subject = null,
        ?array $properties = null
    ): self {
        return self::create([
            'user_id' => auth()->id(),
            'subject_type' => $subject ? get_class($subject) : null,
            'subject_id' => $subject?->id,
            'action' => $action,
            'description' => $description,
            'properties' => $properties,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Aksiyon label
     */
    public function getActionLabelAttribute(): string
    {
        $labels = [
            'created' => 'Oluşturdu',
            'updated' => 'Güncelledi',
            'deleted' => 'Sildi',
            'viewed' => 'Görüntüledi',
            'exported' => 'Dışa Aktardı',
            'imported' => 'İçe Aktardı',
            'login' => 'Giriş Yaptı',
            'logout' => 'Çıkış Yaptı',
        ];

        return $labels[$this->action] ?? $this->action;
    }

    /**
     * Subject tip label
     */
    public function getSubjectTypeLabelAttribute(): ?string
    {
        if (!$this->subject_type) {
            return null;
        }

        $labels = [
            'App\Models\Customer' => 'Müşteri',
            'App\Models\Policy' => 'Poliçe',
            'App\Models\Quotation' => 'Teklif',
            'App\Models\Payment' => 'Ödeme',
            'App\Models\Task' => 'Görev',
        ];

        return $labels[$this->subject_type] ?? class_basename($this->subject_type);
    }
}
