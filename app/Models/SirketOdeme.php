<?php

namespace App\Models;

use App\Traits\BelongsToTenant;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SirketOdeme extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $table = 'sirket_odemeleri';

    protected $guarded = [];

    protected $casts = [
        'tutar' => 'decimal:2',
        'odeme_tarihi' => 'date',
        'policy_ids' => 'array',
    ];

    /**
     * İlişkiler
     */
    public function sirketCari()
    {
        return $this->belongsTo(CariHesap::class, 'sirket_cari_id');
    }

    public function kasaBanka()
    {
        return $this->belongsTo(CariHesap::class, 'kasa_banka_id');
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
     * Poliçeler (many to many benzeri ama JSON)
     */
    public function policies()
    {
        if (!$this->policy_ids) {
            return collect();
        }

        return Policy::whereIn('id', $this->policy_ids)->get();
    }

    /**
     * Scope'lar
     */
    public function scopeTarihAralik($query, $baslangic, $bitis)
    {
        return $query->whereBetween('odeme_tarihi', [$baslangic, $bitis]);
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
     * Boot - Ödeme oluşturulduğunda cari hareketleri oluştur
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($odeme) {
            // 1. Şirket carisine BORÇ kaydı (şirkete ödeme yaptık, borcumuz azaldı)
            CariHareket::create([
                'tenant_id' => $odeme->tenant_id,
                'cari_hesap_id' => $odeme->sirket_cari_id,
                'islem_tipi' => 'borc',
                'tutar' => $odeme->tutar,
                'aciklama' => 'Şirkete Ödeme - ' . ($odeme->aciklama ?? 'Prim ödemesi'),
                'referans_tip' => 'odeme',
                'referans_id' => $odeme->id,
                'odeme_yontemi' => $odeme->odeme_yontemi,
                'islem_tarihi' => $odeme->odeme_tarihi,
                'belge_no' => $odeme->dekont_no,
                'belge_tip' => 'odeme_dekontu',
                'karsi_cari_hesap_id' => $odeme->kasa_banka_id,
                'created_by' => $odeme->created_by,
            ]);

            // 2. Kasa/Banka hesabından ÇIKIŞ kaydı (ALACAK - kasadan para çıktı)
            if ($odeme->kasa_banka_id) {
                CariHareket::create([
                    'tenant_id' => $odeme->tenant_id,
                    'cari_hesap_id' => $odeme->kasa_banka_id,
                    'islem_tipi' => 'alacak',
                    'tutar' => $odeme->tutar,
                    'aciklama' => 'Şirkete Ödeme - ' . $odeme->sirketCari->ad,
                    'referans_tip' => 'odeme',
                    'referans_id' => $odeme->id,
                    'odeme_yontemi' => $odeme->odeme_yontemi,
                    'islem_tarihi' => $odeme->odeme_tarihi,
                    'belge_no' => $odeme->dekont_no,
                    'belge_tip' => 'odeme_dekontu',
                    'karsi_cari_hesap_id' => $odeme->sirket_cari_id,
                    'created_by' => $odeme->created_by,
                ]);
            }
        });

        // Ödeme silindiğinde cari hareketlerini de sil
        static::deleting(function ($odeme) {
            $odeme->cariHareketler()->delete();
        });
    }
}
