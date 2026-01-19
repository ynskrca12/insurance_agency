<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CariHareket extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $table = 'cari_hareketler';

    protected $guarded = [];

    protected $casts = [
        'tutar' => 'decimal:2',
        'islem_tarihi' => 'date',
        'vade_tarihi' => 'date',
    ];

    /**
     * İlişkiler
     */
    public function cariHesap()
    {
        return $this->belongsTo(CariHesap::class, 'cari_hesap_id');
    }

    public function karsiCariHesap()
    {
        return $this->belongsTo(CariHesap::class, 'karsi_cari_hesap_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class, 'referans_id')
                    ->where('referans_tip', 'policy');
    }

    public function tahsilat()
    {
        return $this->belongsTo(Tahsilat::class, 'referans_id')
                    ->where('referans_tip', 'tahsilat');
    }

    public function sirketOdeme()
    {
        return $this->belongsTo(SirketOdeme::class, 'referans_id')
                    ->where('referans_tip', 'odeme');
    }

    /**
     * Scope'lar
     */
    public function scopeBorc($query)
    {
        return $query->where('islem_tipi', 'borc');
    }

    public function scopeAlacak($query)
    {
        return $query->where('islem_tipi', 'alacak');
    }

    public function scopeVadeGecmis($query)
    {
        return $query->where('vade_tarihi', '<', now());
    }

    public function scopeBekleyen($query)
    {
        return $query->where('vade_tarihi', '>=', now());
    }

    public function scopeTarihAralik($query, $baslangic, $bitis)
    {
        return $query->whereBetween('islem_tarihi', [$baslangic, $bitis]);
    }

    /**
     * Accessor'lar
     */
    public function getIslemTipiLabelAttribute()
    {
        return $this->islem_tipi === 'borc' ? 'Borç' : 'Alacak';
    }

    public function getIslemTipiRengiAttribute()
    {
        return $this->islem_tipi === 'borc' ? 'danger' : 'success';
    }

    public function getOdemeYontemiLabelAttribute()
    {
        $labels = [
            'nakit' => 'Nakit',
            'kredi_kart' => 'Kredi Kartı',
            'banka_havale' => 'Banka Havalesi',
            'cek' => 'Çek',
            'sanal_pos' => 'Sanal POS',
            'diger' => 'Diğer',
        ];

        return $labels[$this->odeme_yontemi] ?? '-';
    }

    public function getVadeDurumuAttribute()
    {
        if (!$this->vade_tarihi) {
            return 'Vade Yok';
        }

        if ($this->vade_tarihi < now()) {
            $gun = now()->diffInDays($this->vade_tarihi);
            return "{$gun} gün gecikmiş";
        }

        if ($this->vade_tarihi->isToday()) {
            return 'Bugün vadeli';
        }

        $gun = now()->diffInDays($this->vade_tarihi);
        return "{$gun} gün kaldı";
    }

    /**
     * Boot
     */
    protected static function boot()
    {
        parent::boot();

        // Hareket eklendiğinde bakiye güncelle
        static::created(function ($hareket) {
            $hareket->cariHesap->hesaplaBakiye();
        });

        // Hareket silindiğinde bakiye güncelle
        static::deleted(function ($hareket) {
            $hareket->cariHesap->hesaplaBakiye();
        });
    }
}
