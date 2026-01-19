<?php

namespace App\Http\Controllers;

use App\Models\CariHesap;
use App\Models\CariHareket;
use App\Models\Customer;
use App\Models\InsuranceCompany;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CariHesapController extends Controller
{
    /**
     * Cari hesaplar listesi
     */
    public function index(Request $request)
    {
        $query = CariHesap::where('tenant_id', auth()->id());

        // Tip filtresi
        $tip = $request->get('tip', 'musteri');
        $query->where('tip', $tip);

        // Bakiye filtresi
        if ($request->filled('bakiye_durumu')) {
            if ($request->bakiye_durumu === 'borclu') {
                $query->where('bakiye', '>', 0);
            } elseif ($request->bakiye_durumu === 'alacakli') {
                $query->where('bakiye', '<', 0);
            }
        }

        // Arama
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('kod', 'like', '%' . $request->search . '%')
                  ->orWhere('ad', 'like', '%' . $request->search . '%');
            });
        }

        $cariHesaplar = $query->with(['customer', 'insuranceCompany'])
                             ->orderBy('bakiye', 'desc')
                             ->paginate(20);

        // İstatistikler
        $istatistikler = [
            'toplam_borc' => CariHesap::where('tenant_id', auth()->id())
                                     ->where('tip', $tip)
                                     ->where('bakiye', '>', 0)
                                     ->sum('bakiye'),
            'toplam_alacak' => abs(CariHesap::where('tenant_id', auth()->id())
                                           ->where('tip', $tip)
                                           ->where('bakiye', '<', 0)
                                           ->sum('bakiye')),
            'toplam_sayisi' => CariHesap::where('tenant_id', auth()->id())
                                       ->where('tip', $tip)
                                       ->count(),
        ];

        return view('cari-hesaplar.index', compact('cariHesaplar', 'istatistikler', 'tip'));
    }

    /**
     * Cari hesap detayı ve ekstre
     */
    public function show(CariHesap $cariHesap, Request $request)
    {
        // Tarih aralığı
        $baslangic = $request->get('baslangic', now()->startOfMonth()->format('Y-m-d'));
        $bitis = $request->get('bitis', now()->format('Y-m-d'));

        // Hareketler
        $hareketler = $cariHesap->hareketler()
                                ->with(['karsiCariHesap', 'createdBy'])
                                // ->whereBetween('islem_tarihi', [$baslangic, $bitis])
                                ->orderBy('islem_tarihi', 'desc')
                                ->orderBy('created_at', 'desc')
                                ->get();

        // Dönem başı bakiye
        $donemBasiBorclar = $cariHesap->hareketler()
                                     ->where('islem_tipi', 'borc')
                                     ->where('islem_tarihi', '<', $baslangic)
                                     ->sum('tutar');

        $donemBasiAlacaklar = $cariHesap->hareketler()
                                       ->where('islem_tipi', 'alacak')
                                       ->where('islem_tarihi', '<', $baslangic)
                                       ->sum('tutar');

        $donemBasiBakiye = $donemBasiBorclar - $donemBasiAlacaklar;

        // Dönem içi toplamlar
        $donemBorclar = $hareketler->where('islem_tipi', 'borc')->sum('tutar');
        $donemAlacaklar = $hareketler->where('islem_tipi', 'alacak')->sum('tutar');

        // İlişkili kayıt
        $cariHesap->load(['customer', 'insuranceCompany']);

        return view('cari-hesaplar.show', compact(
            'cariHesap',
            'hareketler',
            'baslangic',
            'bitis',
            'donemBasiBakiye',
            'donemBorclar',
            'donemAlacaklar'
        ));
    }

    /**
     * Yaşlandırma raporu
     */
    public function yasilandirma(Request $request)
    {
        $tip = $request->get('tip', 'musteri');

        $cariHesaplar = CariHesap::where('tenant_id', auth()->id())
                                ->where('tip', $tip)
                                ->where('bakiye', '>', 0) // Sadece borçlular
                                ->with(['customer', 'insuranceCompany'])
                                ->get()
                                ->map(function($cari) {
                                    $hareketler = $cari->hareketler()
                                                      ->where('islem_tipi', 'borc')
                                                      ->whereNull('karsi_cari_hesap_id') // Ödenmemiş
                                                      ->get();

                                    return [
                                        'cari' => $cari,
                                        'vade_0_30' => $hareketler->where('vade_tarihi', '>=', now()->subDays(30))->sum('tutar'),
                                        'vade_31_60' => $hareketler->whereBetween('vade_tarihi', [now()->subDays(60), now()->subDays(31)])->sum('tutar'),
                                        'vade_61_90' => $hareketler->whereBetween('vade_tarihi', [now()->subDays(90), now()->subDays(61)])->sum('tutar'),
                                        'vade_90_plus' => $hareketler->where('vade_tarihi', '<', now()->subDays(90))->sum('tutar'),
                                        'toplam' => $hareketler->sum('tutar'),
                                    ];
                                })
                                ->sortByDesc('toplam');

        return view('cari-hesaplar.yasilandirma', compact('cariHesaplar', 'tip'));
    }

    /**
     * Kasa/Banka raporu
     */
    public function kasaBanka(Request $request)
    {
        $baslangic = $request->get('baslangic', now()->startOfMonth()->format('Y-m-d'));
        $bitis = $request->get('bitis', now()->format('Y-m-d'));

        $kasaBankaHesaplari = CariHesap::where('tenant_id', auth()->id())
                                      ->whereIn('tip', ['kasa', 'banka'])
                                      ->aktif()
                                      ->get()
                                      ->map(function($hesap) use ($baslangic, $bitis) {
                                          $hareketler = $hesap->hareketler()
                                                            //  ->whereBetween('islem_tarihi', [$baslangic, $bitis])
                                                             ->get();

                                          return [
                                              'hesap' => $hesap,
                                              'girisler' => $hareketler->where('islem_tipi', 'borc')->sum('tutar'),
                                              'cikislar' => $hareketler->where('islem_tipi', 'alacak')->sum('tutar'),
                                              'net_hareket' => $hareketler->where('islem_tipi', 'borc')->sum('tutar') -
                                                             $hareketler->where('islem_tipi', 'alacak')->sum('tutar'),
                                          ];
                                      });

        return view('cari-hesaplar.kasa-banka', compact('kasaBankaHesaplari', 'baslangic', 'bitis'));
    }

    /**
     * Manuel cari hareket ekle
     */
    public function addHareket(Request $request, CariHesap $cariHesap)
    {
        $validated = $request->validate([
            'islem_tipi' => 'required|in:borc,alacak',
            'tutar' => 'required|numeric|min:0.01',
            'aciklama' => 'required|string|max:500',
            'islem_tarihi' => 'required|date',
            'vade_tarihi' => 'nullable|date',
            'odeme_yontemi' => 'nullable|in:nakit,kredi_kart,banka_havale,cek,sanal_pos,diger',
            'belge_no' => 'nullable|string|max:50',
        ]);

        try {
            $cariHesap->hareketEkle([
                'tenant_id' => auth()->id(),
                'islem_tipi' => $validated['islem_tipi'],
                'tutar' => $validated['tutar'],
                'aciklama' => $validated['aciklama'],
                'islem_tarihi' => $validated['islem_tarihi'],
                'vade_tarihi' => $validated['vade_tarihi'],
                'odeme_yontemi' => $validated['odeme_yontemi'] ?? null,
                'belge_no' => $validated['belge_no'] ?? null,
                'referans_tip' => 'manuel',
                'created_by' => auth()->id(),
            ]);

            return back()->with('success', 'Cari hareket başarıyla eklendi.');

        } catch (\Exception $e) {
            return back()->with('error', 'Hareket eklenirken hata: ' . $e->getMessage());
        }
    }

    /**
     * Cari hesap oluştur (Kasa/Banka için)
     */
    public function create(Request $request)
    {
        $tip = $request->get('tip', 'kasa');

        return view('cari-hesaplar.create', compact('tip'));
    }

    /**
     * Cari hesap kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'tip' => 'required|in:kasa,banka',
            'ad' => 'required|string|max:255',
            'aciklama' => 'nullable|string|max:500',
            'bakiye' => 'nullable|numeric',
        ]);

        try {
            $cariHesap = CariHesap::create([
                'tenant_id' => auth()->id(),
                'tip' => $validated['tip'],
                'kod' => CariHesap::otomatikKodOlustur($validated['tip'], auth()->id()),
                'ad' => $validated['ad'],
                'aciklama' => $validated['aciklama'],
                'bakiye' => $validated['bakiye'] ?? 0,
                'aktif' => true,
            ]);

            return redirect()
                ->route('cari-hesaplar.show', $cariHesap)
                ->with('success', 'Cari hesap başarıyla oluşturuldu.');

        } catch (\Exception $e) {
            return back()
                ->withInput()
                ->with('error', 'Cari hesap oluşturulurken hata: ' . $e->getMessage());
        }
    }

    /**
     * Bakiye yeniden hesapla
     */
    public function recalculateBalance(CariHesap $cariHesap)
    {
        try {
            $yeniBakiye = $cariHesap->hesaplaBakiye();

            return back()->with('success', "Bakiye yeniden hesaplandı: {$yeniBakiye}₺");

        } catch (\Exception $e) {
            return back()->with('error', 'Bakiye hesaplanırken hata: ' . $e->getMessage());
        }
    }
}
