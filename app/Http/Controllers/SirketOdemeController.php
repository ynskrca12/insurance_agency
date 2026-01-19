<?php

namespace App\Http\Controllers;

use App\Models\SirketOdeme;
use App\Models\CariHesap;
use App\Models\InsuranceCompany;
use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SirketOdemeController extends Controller
{
    /**
     * Şirket ödemeleri listesi
     */
    public function index(Request $request)
    {
        $query = SirketOdeme::with(['sirketCari.insuranceCompany', 'kasaBanka', 'createdBy'])
                           ->where('tenant_id', auth()->id());

        // Tarih filtresi
        if ($request->filled('baslangic') && $request->filled('bitis')) {
            $query->whereBetween('odeme_tarihi', [
                $request->baslangic,
                $request->bitis
            ]);
        }

        // Şirket filtresi
        if ($request->filled('insurance_company_id')) {
            $company = InsuranceCompany::find($request->insurance_company_id);
            if ($company && $company->cariHesap) {
                $query->where('sirket_cari_id', $company->cariHesap->id);
            }
        }

        // Ödeme yöntemi filtresi
        if ($request->filled('odeme_yontemi')) {
            $query->where('odeme_yontemi', $request->odeme_yontemi);
        }

        $odemeler = $query->latest('odeme_tarihi')->paginate(20);

        // Toplam istatistikler
        $toplamOdeme = $query->sum('tutar');

        return view('sirket-odemeleri.index', compact('odemeler', 'toplamOdeme'));
    }

    /**
     * Yeni ödeme formu
     */
    public function create(Request $request)
    {
        // Borcu olan şirketler
        $companies = InsuranceCompany::whereHas('cariHesap', function($q) {
                                        $q->where('bakiye', '<', 0); // Bizim borcumuz var (negatif bakiye)
                                    })
                                    ->with('cariHesap')
                                    ->active()
                                    ->orderBy('name')
                                    ->get();

        $kasaBankaHesaplari = CariHesap::where('tenant_id', auth()->id())
                                      ->whereIn('tip', ['kasa', 'banka'])
                                      ->aktif()
                                      ->orderBy('tip')
                                      ->orderBy('ad')
                                      ->get();

        // Şirket seçiliyse bilgilerini al
        $selectedCompany = null;
        $bekleyenPoliceler = collect();

        if ($request->filled('insurance_company_id')) {
            $selectedCompany = InsuranceCompany::with(['cariHesap.hareketler'])
                                              ->find($request->insurance_company_id);

            // Bu şirkete ait ödenmemiş poliçeler
            if ($selectedCompany && $selectedCompany->cariHesap) {
                $bekleyenPoliceler = Policy::where('insurance_company_id', $selectedCompany->id)
                                          ->whereHas('cariHareketler', function($q) use ($selectedCompany) {
                                              $q->where('cari_hesap_id', $selectedCompany->cariHesap->id)
                                                ->where('islem_tipi', 'alacak');
                                          })
                                          ->with('customer')
                                          ->latest()
                                          ->get();
            }
        }

        return view('sirket-odemeleri.create', compact(
            'companies',
            'kasaBankaHesaplari',
            'selectedCompany',
            'bekleyenPoliceler'
        ));
    }

    /**
     * Ödeme kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'insurance_company_id' => 'required|exists:insurance_companies,id',
            'tutar' => 'required|numeric|min:0.01',
            'odeme_tarihi' => 'required|date',
            'odeme_yontemi' => 'required|in:nakit,kredi_kart,banka_havale,cek,sanal_pos,diger',
            'kasa_banka_id' => 'required|exists:cari_hesaplar,id',
            'dekont_no' => 'nullable|string|max:50',
            'policy_ids' => 'nullable|array',
            'policy_ids.*' => 'exists:policies,id',
            'aciklama' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            $company = InsuranceCompany::findOrFail($validated['insurance_company_id']);

            // Şirket cari hesabını al veya oluştur
            $sirketCari = $company->cariHesap;
            if (!$sirketCari) {
                $sirketCari = CariHesap::create([
                    'tenant_id' => auth()->id(),
                    'tip' => 'sirket',
                    'referans_id' => $company->id,
                    'kod' => CariHesap::otomatikKodOlustur('sirket', auth()->id()),
                    'ad' => $company->name,
                    'vade_gun' => 30,
                    'aktif' => true,
                ]);
            }

            // Ödeme oluştur (Observer otomatik cari kayıtları yapacak)
            $odeme = SirketOdeme::create([
                'tenant_id' => auth()->id(),
                'sirket_cari_id' => $sirketCari->id,
                'tutar' => $validated['tutar'],
                'odeme_tarihi' => $validated['odeme_tarihi'],
                'odeme_yontemi' => $validated['odeme_yontemi'],
                'kasa_banka_id' => $validated['kasa_banka_id'],
                'dekont_no' => $validated['dekont_no'],
                'policy_ids' => $validated['policy_ids'] ?? null,
                'aciklama' => $validated['aciklama'],
                'created_by' => auth()->id(),
            ]);

            DB::commit();

            return redirect()
                ->route('sirket-odemeleri.show', $odeme)
                ->with('success', 'Şirket ödemesi başarıyla kaydedildi. Dekont No: ' . ($odeme->dekont_no ?? $odeme->id));

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Ödeme kaydedilirken hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Ödeme detayı
     */
    public function show(SirketOdeme $sirketOdeme)
    {
        $sirketOdeme->load([
            'sirketCari.insuranceCompany',
            'kasaBanka',
            'createdBy',
            'cariHareketler'
        ]);

        // İlgili poliçeler
        $policies = collect();
        if ($sirketOdeme->policy_ids) {
            $policies = Policy::whereIn('id', $sirketOdeme->policy_ids)
                             ->with('customer')
                             ->get();
        }

        return view('sirket-odemeleri.show', compact('sirketOdeme', 'policies'));
    }

    /**
     * Ödeme düzenle
     */
    public function edit(SirketOdeme $sirketOdeme)
    {
        $kasaBankaHesaplari = CariHesap::where('tenant_id', auth()->id())
                                      ->whereIn('tip', ['kasa', 'banka'])
                                      ->aktif()
                                      ->get();

        $sirketOdeme->load('sirketCari.insuranceCompany');

        return view('sirket-odemeleri.edit', compact('sirketOdeme', 'kasaBankaHesaplari'));
    }

    /**
     * Ödeme güncelle
     */
    public function update(Request $request, SirketOdeme $sirketOdeme)
    {
        $validated = $request->validate([
            'tutar' => 'required|numeric|min:0.01',
            'odeme_tarihi' => 'required|date',
            'odeme_yontemi' => 'required|in:nakit,kredi_kart,banka_havale,cek,sanal_pos,diger',
            'kasa_banka_id' => 'required|exists:cari_hesaplar,id',
            'dekont_no' => 'nullable|string|max:50',
            'aciklama' => 'nullable|string|max:500',
        ]);

        try {
            DB::beginTransaction();

            // Eski cari kayıtları sil
            $sirketOdeme->cariHareketler()->delete();

            // Ödeme güncelle
            $sirketOdeme->update($validated);

            DB::commit();

            return redirect()
                ->route('sirket-odemeleri.show', $sirketOdeme)
                ->with('success', 'Ödeme başarıyla güncellendi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()
                ->withInput()
                ->with('error', 'Ödeme güncellenirken hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Ödeme sil
     */
    public function destroy(SirketOdeme $sirketOdeme)
    {
        try {
            $sirketOdeme->delete(); // Soft delete - Observer cari kayıtları da silecek

            return redirect()
                ->route('sirket-odemeleri.index')
                ->with('success', 'Ödeme başarıyla silindi.');

        } catch (\Exception $e) {
            return back()->with('error', 'Ödeme silinirken hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Şirket bazlı borç detayları (AJAX)
     */
    public function companyDetails($companyId)
    {
        $company = InsuranceCompany::with(['cariHesap.hareketler' => function($q) {
                                        $q->latest('islem_tarihi')->limit(10);
                                    }])
                                  ->findOrFail($companyId);

        if (!$company->cariHesap) {
            return response()->json([
                'success' => false,
                'message' => 'Şirketin cari hesabı bulunamadı.'
            ]);
        }

        return response()->json([
            'success' => true,
            'cari_kod' => $company->cariHesap->kod,
            'bakiye' => $company->cariHesap->bakiye,
            'bakiye_durumu' => $company->cariHesap->bakiye_durumu,
            'son_hareketler' => $company->cariHesap->hareketler
        ]);
    }
}
