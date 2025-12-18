<?php

namespace App\Models;
use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    use HasFactory, BelongsToTenant;

    // protected $fillable = [
    //     'full_name',
    //     'email',
    //     'phone',
    //     'subject',
    //     'message',
    //     'is_read',
    //     'replied_at',
    //     'reply_message',
    //     'ip_address',
    // ];

    protected $guarded = [];

    protected $casts = [
        'is_read' => 'boolean',
        'replied_at' => 'datetime',
    ];

    /**
     * Mesaj okundu mu?
     */
    public function isRead(): bool
    {
        return $this->is_read;
    }

    /**
     * Mesaj cevaplandı mı?
     */
    public function isReplied(): bool
    {
        return !is_null($this->replied_at);
    }

    /**
     * Mesajı okundu olarak işaretle
     */
    public function markAsRead(): void
    {
        $this->is_read = true;
        $this->save();
    }

    /**
     * Mesajı cevapla
     */
    public function reply(string $replyMessage): void
    {
        $this->reply_message = $replyMessage;
        $this->replied_at = now();
        $this->is_read = true;
        $this->save();
    }

    /**
     * Scope: Okunmamış mesajlar
     */
    public function scopeUnread($query)
    {
        return $query->where('is_read', false);
    }

    /**
     * Scope: Okunmuş mesajlar
     */
    public function scopeRead($query)
    {
        return $query->where('is_read', true);
    }

    /**
     * Scope: Cevaplanmış mesajlar
     */
    public function scopeReplied($query)
    {
        return $query->whereNotNull('replied_at');
    }

    /**
     * Scope: Cevaplanmamış mesajlar
     */
    public function scopePending($query)
    {
        return $query->whereNull('replied_at');
    }
}
