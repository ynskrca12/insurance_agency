<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

/**
 * Roller:
 * - owner: Acente sahibi (tüm tenant verilerini görür/yönetir)
 * - manager: Müdür (tüm tenant verilerini görür/yönetir)
 * - agent: Çalışan (sadece kendi verilerini görür)
 * - admin: Sistem yöneticisi (tüm tenant'ları görür)
 */
class User extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes;

    /**
     * The attributes that aren't mass assignable.
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'is_admin' => 'boolean',
    ];

    // ============================================
    // ROL KONTROL METODLARı
    // ============================================

    /**
     * Kullanıcı sistem yöneticisi mi?
     */
    public function isAdmin(): bool
    {
        return $this->role === 'admin' || $this->is_admin === true;
    }

    /**
     * Kullanıcı acente sahibi mi?
     */
    public function isOwner(): bool
    {
        return $this->role === 'owner';
    }

    /**
     * Kullanıcı müdür mü?
     */
    public function isManager(): bool
    {
        return $this->role === 'manager';
    }

    /**
     * Kullanıcı çalışan mı?
     */
    public function isAgent(): bool
    {
        return $this->role === 'agent';
    }

    /**
     * Kullanıcı tüm tenant verilerini görebilir mi?
     * Owner ve Manager tüm acente verilerini görebilir.
     */
    public function canSeeAll(): bool
    {
        return in_array($this->role, ['owner', 'manager', 'admin']);
    }

    /**
     * Kullanıcı sadece kendi verilerini görebilir mi?
     * Agent sadece kendi eklediği verileri görebilir.
     */
    public function canSeeOnlyOwn(): bool
    {
        return $this->role === 'agent';
    }

    /**
     * Kullanıcı veri ekleyebilir mi?
     */
    public function canCreate(): bool
    {
        return $this->is_active && in_array($this->role, ['owner', 'manager', 'agent']);
    }

    /**
     * Kullanıcı veri düzenleyebilir mi?
     *
     * @param mixed $model Model instance (Customer, Policy vs)
     * @return bool
     */
    public function canEdit($model): bool
    {
        if (!$this->is_active) {
            return false;
        }

        // Admin her şeyi düzenleyebilir
        if ($this->isAdmin()) {
            return true;
        }

        // Farklı tenant'taki veriyi düzenleyemez
        if ($model->tenant_id !== $this->tenant_id) {
            return false;
        }

        // Owner ve Manager her şeyi düzenleyebilir
        if ($this->canSeeAll()) {
            return true;
        }

        // Agent sadece kendi eklediğini düzenleyebilir
        return $model->created_by === $this->id;
    }

    /**
     * Kullanıcı veri silebilir mi?
     */
    public function canDelete($model): bool
    {
        // Silme yetkisi düzenleme ile aynı
        return $this->canEdit($model);
    }

    /**
     * Kullanıcı aktif mi?
     */
    public function isActiveUser(): bool
    {
        return $this->is_active;
    }

    // ============================================
    // TENANT SCOPE METODLARı
    // ============================================

    /**
     * Scope: Sadece kendi tenant'ındaki kullanıcılar
     *
     * Kullanım: User::forCurrentTenant()->get()
     */
    public function scopeForCurrentTenant(Builder $query): Builder
    {
        if (!auth()->check()) {
            return $query->whereNull('id'); // Giriş yoksa hiçbir şey gösterme
        }

        if (auth()->user()->isAdmin()) {
            return $query; // Admin tüm kullanıcıları görür
        }

        return $query->where('tenant_id', auth()->user()->tenant_id);
    }

    /**
     * Scope: Tüm kullanıcılar (admin için)
     *
     * Kullanım: User::allUsers()->get()
     */
    public function scopeAllUsers(Builder $query): Builder
    {
        return $query;
    }

    /**
     * Scope: Sadece aktif kullanıcılar
     *
     * Kullanım: User::active()->get()
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('is_active', true);
    }

    /**
     * Scope: Belirli bir role sahip kullanıcılar
     *
     * Kullanım: User::byRole('agent')->get()
     */
    public function scopeByRole(Builder $query, string $role): Builder
    {
        return $query->where('role', $role);
    }

    /**
     * Scope: Yönetici ve üstü roller (owner, manager)
     *
     * Kullanım: User::managers()->get()
     */
    public function scopeManagers(Builder $query): Builder
    {
        return $query->whereIn('role', ['owner', 'manager']);
    }

    /**
     * Scope: Sadece çalışanlar (agent)
     *
     * Kullanım: User::agents()->get()
     */
    public function scopeAgents(Builder $query): Builder
    {
        return $query->where('role', 'agent');
    }

    // ============================================
    // İLİŞKİLER
    // ============================================

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
    public function hasDemo(): bool
    {
        return $this->demoUser()->exists();
    }

    /**
     * Demo süresi dolmuş mu?
     */
    public function isDemoExpired(): bool
    {
        if (!$this->hasDemo()) {
            return false;
        }

        return $this->demoUser->isExpired();
    }

    /**
     * Kullanıcının oluşturduğu müşteriler
     */
    public function createdCustomers()
    {
        return $this->hasMany(Customer::class, 'created_by');
    }

    /**
     * Kullanıcının oluşturduğu poliçeler
     */
    public function createdPolicies()
    {
        return $this->hasMany(Policy::class, 'created_by');
    }

    /**
     * Kullanıcıya atanan görevler
     */
    public function assignedTasks()
    {
        return $this->hasMany(Task::class, 'assigned_to_user_id');
    }

    /**
     * Kullanıcının oluşturduğu görevler
     */
    public function createdTasks()
    {
        return $this->hasMany(Task::class, 'created_by');
    }

    /**
     * Kullanıcının müşteri notları
     */
    public function customerNotes()
    {
        return $this->hasMany(CustomerNote::class);
    }

    /**
     * Kullanıcının müşteri aramaları
     */
    public function customerCalls()
    {
        return $this->hasMany(CustomerCall::class);
    }

    // ============================================
    // HELPER METODLAR
    // ============================================

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

    /**
     * Kullanıcının tam adını döndür
     */
    public function getFullNameAttribute(): string
    {
        return $this->name;
    }

    // ============================================
    // ACCESSOR'LAR
    // ============================================

    /**
     * Rol etiketini Türkçe olarak döndür
     */
    public function getRoleLabelAttribute(): string
    {
        $labels = [
            'admin' => 'Sistem Yöneticisi',
            'owner' => 'Acente Sahibi',
            'manager' => 'Müdür',
            'agent' => 'Çalışan',
        ];

        return $labels[$this->role] ?? $this->role;
    }

    /**
     * Rol rengini döndür (badge için)
     */
    public function getRoleColorAttribute(): string
    {
        $colors = [
            'admin' => 'danger',
            'owner' => 'primary',
            'manager' => 'info',
            'agent' => 'success',
        ];

        return $colors[$this->role] ?? 'secondary';
    }

    /**
     * Durum etiketini döndür
     */
    public function getStatusLabelAttribute(): string
    {
        return $this->is_active ? 'Aktif' : 'Pasif';
    }

    /**
     * Durum rengini döndür
     */
    public function getStatusColorAttribute(): string
    {
        return $this->is_active ? 'success' : 'secondary';
    }
}
