<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tahsilat extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $table = 'tahsilatlar';

    protected $guarded = [];

    protected $casts = [
        'tutar' => 'decimal:2',
        'tahsilat_tarihi' => 'date',
    ];

    /**
     * İlişkiler
     */
    public function musteriCari()
    {
        return $this->belongsTo(CariHesap::class, 'musteri_cari_id');
    }

    public function kasaBanka()
    {
        return $this->belongsTo(CariHesap::class, 'kasa_banka_id');
    }

    public function policy()
    {
        return $this->belongsTo(Policy::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function cariHareketler()
    {
        return $this->morphMany(CariHareket::class, 'referans', 'referans_tip', 'referans_id');
    }

    /**
     * Scope'lar
     */
    public function scopeTarihAralik($query, $baslangic, $bitis)
    {
        return $query->whereBetween('tahsilat_tarihi', [$baslangic, $bitis]);
    }

    public function scopeOdemeYontemi($query, $yontem)
    {
        return $query->where('odeme_yontemi', $yontem);
    }

    /**
     * Accessor'lar
     */
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

    /**
     * Boot - Tahsilat oluşturulduğunda cari hareketleri oluştur
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($tahsilat) {
            // 1. Müşteri carisine ALACAK kaydı (müşterinin borcu azalır)
            CariHareket::create([
                'tenant_id' => $tahsilat->tenant_id,
                'cari_hesap_id' => $tahsilat->musteri_cari_id,
                'islem_tipi' => 'alacak',
                'tutar' => $tahsilat->tutar,
                'aciklama' => 'Tahsilat - ' . ($tahsilat->aciklama ?? 'Müşteri ödemesi'),
                'referans_tip' => 'tahsilat',
                'referans_id' => $tahsilat->id,
                'odeme_yontemi' => $tahsilat->odeme_yontemi,
                'islem_tarihi' => $tahsilat->tahsilat_tarihi,
                'belge_no' => $tahsilat->makbuz_no,
                'belge_tip' => 'tahsilat_makbuzu',
                'karsi_cari_hesap_id' => $tahsilat->kasa_banka_id,
                'created_by' => $tahsilat->created_by,
            ]);

            // 2. Kasa/Banka hesabına GİRİŞ kaydı (BORÇ - kasaya para girdi)
            if ($tahsilat->kasa_banka_id) {
                CariHareket::create([
                    'tenant_id' => $tahsilat->tenant_id,
                    'cari_hesap_id' => $tahsilat->kasa_banka_id,
                    'islem_tipi' => 'borc',
                    'tutar' => $tahsilat->tutar,
                    'aciklama' => 'Tahsilat - ' . $tahsilat->musteriCari->ad,
                    'referans_tip' => 'tahsilat',
                    'referans_id' => $tahsilat->id,
                    'odeme_yontemi' => $tahsilat->odeme_yontemi,
                    'islem_tarihi' => $tahsilat->tahsilat_tarihi,
                    'belge_no' => $tahsilat->makbuz_no,
                    'belge_tip' => 'tahsilat_makbuzu',
                    'karsi_cari_hesap_id' => $tahsilat->musteri_cari_id,
                    'created_by' => $tahsilat->created_by,
                ]);
            }
        });

        // Tahsilat silindiğinde cari hareketlerini de sil
        static::deleting(function ($tahsilat) {
            $tahsilat->cariHareketler()->delete();
        });
    }
}
