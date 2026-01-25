<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\BelongsToTenant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class CariHesap extends Model
{
    use HasFactory, SoftDeletes, BelongsToTenant;

    protected $table = 'cari_hesaplar';

    protected $guarded = [];

    protected $casts = [
        'bakiye' => 'decimal:2',
        'kredi_limiti' => 'decimal:2',
        'aktif' => 'boolean',
        'vade_gun' => 'integer',
    ];

    /**
     * İlişkiler
     */
    public function hareketler()
    {
        return $this->hasMany(CariHareket::class, 'cari_hesap_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'referans_id');
    }

    public function insuranceCompany()
    {
        return $this->belongsTo(InsuranceCompany::class, 'referans_id');
    }

    public function tahsilatlar()
    {
        return $this->hasMany(Tahsilat::class, 'musteri_cari_id');
    }

    public function sirketOdemeleri()
    {
        return $this->hasMany(SirketOdeme::class, 'sirket_cari_id');
    }

    /**
     * Scope'lar
     */
    public function scopeMusteri($query)
    {
        return $query->where('tip', 'musteri');
    }

    public function scopeSirket($query)
    {
        return $query->where('tip', 'sirket');
    }

    public function scopeKasa($query)
    {
        return $query->where('tip', 'kasa');
    }

    public function scopeBanka($query)
    {
        return $query->where('tip', 'banka');
    }

    public function scopeAktif($query)
    {
        return $query->where('aktif', true);
    }

    public function scopeBorclu($query)
    {
        return $query->where('bakiye', '>', 0);
    }

    public function scopeAlacakli($query)
    {
        return $query->where('bakiye', '<', 0);
    }

    /**
     * Scope: Kasa/Banka hesaplarını tenant bazında getir
     *
     * Kasa/Banka ortak kaynak olduğu için created_by kontrolü YOK
     * Tenant'taki TÜM kullanıcılar erişebilir
     */
    public function scopeKasaBankaForTenant($query, $tenantId = null)
    {
        $tenantId = $tenantId ?? (auth()->check() ? auth()->user()->tenant_id : null);

        if (!$tenantId) {
            return $query->whereNull('id'); // Tenant yoksa hiçbir şey gösterme
        }

        return $query->withoutGlobalScope('tenantScope') // Global scope'u bypass et
                    ->whereIn('tip', ['kasa', 'banka'])
                    ->where('tenant_id', $tenantId)
                    ->where('aktif', true);
    }

    /**
     * Bakiye hesaplama
     */
    public function hesaplaBakiye()
    {
        $borclar = $this->hareketler()
                        ->where('islem_tipi', 'borc')
                        ->sum('tutar');

        $alacaklar = $this->hareketler()
                          ->where('islem_tipi', 'alacak')
                          ->sum('tutar');

        $bakiye = $borclar - $alacaklar;

        $this->update(['bakiye' => $bakiye]);

        return $bakiye;
    }

    /**
     * Yeni hareket ekle
     */
    public function hareketEkle(array $data)
    {
        $hareket = $this->hareketler()->create($data);
        $this->hesaplaBakiye();

        return $hareket;
    }

    /**
     * Vade geçmiş borçlar
     */
    public function vadeGecmisBorclar()
    {
        return $this->hareketler()
                    ->where('islem_tipi', 'borc')
                    ->where('vade_tarihi', '<', now())
                    ->whereNull('karsi_cari_hesap_id')
                    ->get();
    }

    /**
     * Bekleyen borçlar (vadesi gelmemiş)
     */
    public function bekleyenBorclar()
    {
        return $this->hareketler()
                    ->where('islem_tipi', 'borc')
                    ->where('vade_tarihi', '>=', now())
                    ->whereNull('karsi_cari_hesap_id')
                    ->get();
    }

    /**
     * Accessor'lar
     */
    public function getTipLabelAttribute()
    {
        $labels = [
            'musteri' => 'Müşteri',
            'sirket' => 'Sigorta Şirketi',
            'kasa' => 'Kasa',
            'banka' => 'Banka',
        ];

        return $labels[$this->tip] ?? $this->tip;
    }

    public function getBakiyeDurumuAttribute()
    {
        if ($this->bakiye > 0) {
            return 'Borçlu';
        } elseif ($this->bakiye < 0) {
            return 'Alacaklı';
        }
        return 'Dengede';
    }

    public function getBakiyeRengiAttribute()
    {
        if ($this->bakiye > 0) {
            return 'danger';
        } elseif ($this->bakiye < 0) {
            return 'success';
        }
        return 'secondary';
    }

    /**
     * Otomatik kod oluştur (Global scope'suz - RAW query)
     */
    public static function otomatikKodOlustur($tip, $tenantId)
    {
        Log::info(' otomatikKodOlustur BAŞLADI', [
            'tip' => $tip,
            'tenant_id' => $tenantId,
        ]);

        $prefix = [
            'musteri' => 'MCR',
            'sirket' => 'SCR',
            'kasa' => 'KAS',
            'banka' => 'BNK',
        ];

        //  GLOBAL SCOPE OLMADAN DOĞRUDAN DB QUERY
        $count = DB::table('cari_hesaplar')
                    ->where('tenant_id', $tenantId)
                    ->where('tip', $tip)
                    ->whereNull('deleted_at') // Soft delete kontrolü
                    ->count();

        Log::info('📊Mevcut kayıt sayısı (RAW)', [
            'count' => $count,
            'next_number' => $count + 1,
        ]);

        // İlk 20 deneme yap
        for ($i = 0; $i < 20; $i++) {
            $numara = $count + 1 + $i;
            $yeniNumara = str_pad($numara, 4, '0', STR_PAD_LEFT);
            $yeniKod = $prefix[$tip] . '-' . $yeniNumara;

            Log::info(' Kod kontrol ediliyor', [
                'kod' => $yeniKod,
                'attempt' => $i + 1,
            ]);

            // GLOBAL SCOPE OLMADAN KONTROL
            $exists = DB::table('cari_hesaplar')
                        ->where('tenant_id', $tenantId)
                        ->where('kod', $yeniKod)
                        ->whereNull('deleted_at')
                        ->exists();

            if (!$exists) {
                Log::info(' UYGUN KOD BULUNDU', ['kod' => $yeniKod]);
                return $yeniKod;
            }

            Log::warning('⚠️ Kod zaten var, bir sonraki deneniyor', ['kod' => $yeniKod]);
        }

        // Fallback
        $fallbackKod = $prefix[$tip] . '-T' . time();
        Log::error('FALLBACK KODU KULLANILDI', ['kod' => $fallbackKod]);

        return $fallbackKod;
    }
}
