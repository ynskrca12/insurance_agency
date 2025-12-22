<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Builder;


class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    protected $guarded = [];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];
        /**
     * ============================================
     * TENANT SCOPE METODLARI (MANUEL)
     * ============================================
     */

    /**
     * Scope: Sadece kendi tenant'ındaki kullanıcılar
     */
    public function scopeForCurrentTenant(Builder $query)
    {
        if (auth()->check()) {
            return $query->where('tenant_id', auth()->user()->tenant_id);
        }
        return $query;
    }

    /**
     * Scope: Tüm kullanıcılar (admin için)
     */
    public function scopeAllUsers(Builder $query)
    {
        return $query;
    }

        /**
     * Demo user ilişkisi
     */
    public function demoUser()
    {
        return $this->hasOne(DemoUser::class);
    }

    /**
     * Kullanıcının demo hesabı var mı?
     */
    public function hasDemo()
    {
        return $this->demoUser()->exists();
    }

    /**
     * Demo süresi dolmuş mu?
     */
    public function isDemoExpired()
    {
        if (!$this->hasDemo()) {
            return false;
        }

        return $this->demoUser->isExpired();
    }

    /**
     * İlişkiler
     */
    public function createdCustomers()
    {
        return $this->hasMany(Customer::class, 'created_by');
    }

    public function createdPolicies()
    {
        return $this->hasMany(Policy::class, 'created_by');
    }

    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to_user_id');
    }

    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    public function customerNotes()
    {
        return $this->hasMany(CustomerNote::class);
    }

    public function customerCalls()
    {
        return $this->hasMany(CustomerCall::class);
    }

    /**
     * Kullanıcı admin mi?
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    /**
     * Kullanıcı aktif mi?
     */
    public function isActiveUser(): bool
    {
        return $this->is_active;
    }

    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    /**
     * Son giriş bilgisini güncelle
     */
    public function updateLastLogin(): void
    {
        $this->update([
            'last_login_at' => now(),
            'last_login_ip' => request()->ip(),
        ]);
    }


    // Accessor'lar
    // public function getAvatarUrlAttribute()
    // {
    //     if ($this->avatar) {
    //         return Storage::url($this->avatar);
    //     }
    //     return asset('images/default-avatar.png');
    // }

    public function getRoleLabelAttribute()
    {
        $labels = [
            'admin' => 'Yönetici',
            'manager' => 'Müdür',
            'agent' => 'Acente',
        ];

        return $labels[$this->role] ?? $this->role;
    }

    public function getStatusLabelAttribute()
    {
        return $this->is_active ? 'Aktif' : 'Pasif';
    }

    public function getStatusColorAttribute()
    {
        return $this->is_active ? 'success' : 'secondary';
    }
}
