<?php

namespace App\Http\Controllers;

use App\Models\Tahsilat;
use App\Models\CariHesap;
use App\Models\Customer;
use App\Models\Policy;
use App\Models\CariHareket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;


class TahsilatController extends Controller
{
    /**
     * Tahsilat listesi
     */
    public function index(Request $request)
    {
        $query = Tahsilat::with(['musteriCari.customer', 'kasaBanka', 'policy', 'createdBy'])
                         ->where('tenant_id', auth()->id());

        // Tarih filtresi
        if ($request->filled('baslangic') && $request->filled('bitis')) {
            $query->whereBetween('tahsilat_tarihi', [
                $request->baslangic,
                $request->bitis
            ]);
        }

        // Ödeme yöntemi filtresi
        if ($request->filled('odeme_yontemi')) {
            $query->where('odeme_yontemi', $request->odeme_yontemi);
        }

        // Müşteri filtresi
        if ($request->filled('customer_id')) {
            $customer = Customer::find($request->customer_id);
            if ($customer && $customer->cariHesap) {
                $query->where('musteri_cari_id', $customer->cariHesap->id);
            }
        }

        $tahsilatlar = $query->latest('tahsilat_tarihi')->paginate(20);

        // Toplam istatistikler
        $toplamTahsilat = $query->sum('tutar');

        return view('tahsilatlar.index', compact('tahsilatlar', 'toplamTahsilat'));
    }

    /**
     * Yeni tahsilat formu
     */
    public function create(Request $request)
    {
        $customers = Customer::where('tenant_id', auth()->id())
                            ->whereHas('cariHesap', function($q) {
                                $q->where('bakiye', '>', 0); // Borcu olanlar
                            })
                            ->with('cariHesap')
                            ->orderBy('name')
                            ->get();

        $kasaBankaHesaplari = CariHesap::where('tenant_id', auth()->id())
                                      ->whereIn('tip', ['kasa', 'banka'])
                                      ->aktif()
                                      ->orderBy('tip')
                                      ->orderBy('ad')
                                      ->get();

        // Müşteri seçiliyse bilgilerini al
        $selectedCustomer = null;
        if ($request->filled('customer_id')) {
            $selectedCustomer = Customer::with('cariHesap.hareketler')
                                       ->find($request->customer_id);
        }

        return view('tahsilatlar.create', compact('customers', 'kasaBankaHesaplari', 'selectedCustomer'));
    }

    /**
     * Tahsilat kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'tutar' => 'required|numeric|min:0.01',
            'tahsilat_tarihi' => 'required|date',
            'odeme_yontemi' => 'required|in:nakit,kredi_kart,banka_havale,cek,sanal_pos,diger',
            'kasa_banka_id' => 'required|exists:cari_hesaplar,id',
            'makbuz_no' => 'nullable|string|max:50',
            'policy_id' => 'nullable|exists:policies,id',
            'aciklama' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $customer = Customer::findOrFail($validated['customer_id']);
            $musteriCari = $customer->getOrCreateCariHesap();

            // Tahsilat oluştur (Observer otomatik cari kayıtları yapacak)
            $tahsilat = Tahsilat::create([
                'tenant_id' => auth()->id(),
                'musteri_cari_id' => $musteriCari->id,
                'tutar' => $validated['tutar'],
                'tahsilat_tarihi' => $validated['tahsilat_tarihi'],
                'odeme_yontemi' => $validated['odeme_yontemi'],
                'kasa_banka_id' => $validated['kasa_banka_id'],
                'makbuz_no' => $validated['makbuz_no'],
                'policy_id' => $validated['policy_id'] ?? null,
                'aciklama' => $validated['aciklama'],
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()
                ->route('tahsilatlar.show', $tahsilat)
                ->with('success', 'Tahsilat başarıyla kaydedildi. Makbuz No: ' . ($tahsilat->makbuz_no ?? $tahsilat->id));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Tahsilat kaydedilirken hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Tahsilat detayı
     */
    public function show(Tahsilat $tahsilat)
    {
        $tahsilat->load([
            'musteriCari.customer',
            'kasaBanka',
            'policy',
            'createdBy',
            'cariHareketler'
        ]);

        return view('tahsilatlar.show', compact('tahsilat'));
    }

    /**
     * Tahsilat düzenle
     */
    public function edit(Tahsilat $tahsilat)
    {
        $kasaBankaHesaplari = CariHesap::where('tenant_id', auth()->id())
                                      ->whereIn('tip', ['kasa', 'banka'])
                                      ->aktif()
                                      ->get();

        $tahsilat->load('musteriCari.customer');

        return view('tahsilatlar.edit', compact('tahsilat', 'kasaBankaHesaplari'));
    }

    /**
     * Tahsilat güncelle
     */
    public function update(Request $request, Tahsilat $tahsilat)
    {
        $validated = $request->validate([
            'tutar' => 'required|numeric|min:0.01',
            'tahsilat_tarihi' => 'required|date',
            'odeme_yontemi' => 'required|in:nakit,kredi_kart,banka_havale,cek,sanal_pos,diger',
            'kasa_banka_id' => 'required|exists:cari_hesaplar,id',
            'makbuz_no' => 'nullable|string|max:50',
            'aciklama' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Eski cari kayıtları sil
            $tahsilat->cariHareketler()->delete();

            // Tahsilat güncelle
            $tahsilat->update($validated);

            // Yeni cari kayıtları oluşturulacak (Observer boot)
            $tahsilat->refresh();

            DB::commit();

            return redirect()
                ->route('tahsilatlar.show', $tahsilat)
                ->with('success', 'Tahsilat başarıyla güncellendi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Tahsilat güncellenirken hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Tahsilat sil
     */
    public function destroy(Tahsilat $tahsilat)
    {
        try {
            $tahsilat->delete(); // Soft delete - Observer cari kayıtları da silecek

            return redirect()
                ->route('tahsilatlar.index')
                ->with('success', 'Tahsilat başarıyla silindi.');

        } catch (\Exception $e) {
            return back()->with('error', 'Tahsilat silinirken hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Müşteri bazlı tahsilat detayları (AJAX)
     */
    public function customerDetails($customerId)
    {
        $customer = Customer::with(['cariHesap.hareketler' => function($q) {
                                $q->latest('islem_tarihi')->limit(10);
                            }])
                            ->findOrFail($customerId);

        if (!$customer->cariHesap) {
            return response()->json([
                'success' => false,
                'message' => 'Müşterinin cari hesabı bulunamadı.'
            ]);
        }

        return response()->json([
            'success' => true,
            'cari_kod' => $customer->cariHesap->kod,
            'bakiye' => $customer->cariHesap->bakiye,
            'bakiye_durumu' => $customer->cariHesap->bakiye_durumu,
            'son_hareketler' => $customer->cariHesap->hareketler
        ]);
    }

public function getCustomerPolicies($customerId)
{
    try {
        $customer = Customer::findOrFail($customerId);

        if (!$customer->cariHesap) {
            return response()->json([
                'success' => false,
                'message' => 'Müşterinin cari hesabı bulunamadı'
            ]);
        }

        $policies = Policy::where('customer_id', $customerId)
            ->with('insuranceCompany')
            ->get();

        if ($policies->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Bu müşteriye ait poliçe bulunamadı'
            ]);
        }

        $policiesData = $policies->map(function($policy) {
            $toplamTutar = $policy->premium_amount;

            // Bu poliçeye yapılan tahsilatlar
            $odenenTutar = $policy->tahsilatlar()->sum('tutar');

            // Kalan tutar
            $kalanTutar = $toplamTutar - $odenenTutar;

            return [
                'id' => $policy->id,
                'policy_number' => $policy->policy_number,
                'insurance_company' => $policy->insuranceCompany->name ?? 'N/A',
                'insurance_type' => $policy->policy_type_label,
                'toplam_tutar' => number_format($toplamTutar, 2, '.', ''),
                'odenen_tutar' => number_format($odenenTutar, 2, '.', ''),
                'kalan_tutar' => number_format(max(0, $kalanTutar), 2, '.', ''),
                'kalan_tutar_formatted' => number_format(max(0, $kalanTutar), 2, ',', '.') . '₺',
                'baslangic_tarihi' => $policy->start_date,
                'bitis_tarihi' => $policy->end_date,
                'durum' => $policy->status
            ];
        });

        $toplamBorc = $policies->sum('premium_amount');
        $toplamTahsilat = Tahsilat::where('musteri_cari_id', $customer->cariHesap->id)->sum('tutar');

        return response()->json([
            'success' => true,
            'policies' => $policiesData,
            'toplam_tahsilat' => number_format($toplamTahsilat, 2, '.', ''),
            'toplam_borc' => number_format($toplamBorc, 2, '.', ''),
            'genel_kalan' => number_format($toplamBorc - $toplamTahsilat, 2, '.', ''),
        ]);

    } catch (\Exception $e) {
        Log::error('getCustomerPolicies hatası: ' . $e->getMessage());

        return response()->json([
            'success' => false,
            'message' => 'Poliçeler yüklenirken hata oluştu'
        ], 500);
    }
}
}
