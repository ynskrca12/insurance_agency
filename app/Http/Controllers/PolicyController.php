<?php

namespace App\Http\Controllers;

use App\Models\Policy;
use App\Models\Customer;
use App\Models\InsuranceCompany;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PolicyController extends Controller
{
    /**
     * Poliçe listesi
     */
    public function index(Request $request)
    {
        // ✅ CARİ İLİŞKİLERİ EKLE
        $query = Policy::with([
            'customer.cariHesap',  // ✅ YENİ: Müşteri cari hesabı
            'insuranceCompany',
            'createdBy',
            'cariHareketler'  // ✅ YENİ: Poliçeye ait cari hareketler
        ])->orderBy('created_at', 'desc');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('policy_number', 'like', "%{$search}%")
                  ->orWhere('vehicle_plate', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('policy_type')) {
            $query->where('policy_type', $request->policy_type);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('insurance_company_id')) {
            $query->where('insurance_company_id', $request->insurance_company_id);
        }

        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'expiring_30':
                    $query->whereBetween('end_date', [now(), now()->addDays(30)]);
                    break;
                case 'expiring_7':
                    $query->whereBetween('end_date', [now(), now()->addDays(7)]);
                    break;
                case 'expired':
                    $query->where('end_date', '<', now());
                    break;
            }
        }

        $policies = $query->get();

        $insuranceCompanies = InsuranceCompany::where('is_active', true)
            ->orderBy('name')
            ->get();

        $stats = $this->getPolicyStats();

        return view('policies.index', compact('policies', 'insuranceCompanies', 'stats'));
    }

    /**
     * Yeni poliçe formu
     */
    public function create(Request $request)
    {
        $customers = Customer::where('status', 'active')
            ->with('cariHesap')  // ✅ YENİ: Cari hesap bilgisi
            ->orderBy('name')
            ->get();

        $insuranceCompanies = InsuranceCompany::active()->get();

        $selectedCustomer = $request->customer_id
            ? Customer::with('cariHesap')->find($request->customer_id)
            : null;

        return view('policies.create', compact('customers', 'insuranceCompanies', 'selectedCustomer'));
    }

    /**
     * Poliçe kaydet
     */
    public function store(Request $request)
    {
        $validated = $this->validatePolicy($request);

        DB::beginTransaction();
        try {
            $commissionRate = $validated['commission_rate'] ??
                InsuranceCompany::find($validated['insurance_company_id'])
                    ->getCommissionRate($validated['policy_type']);

            $commissionAmount = ($validated['premium_amount'] * $commissionRate) / 100;

            $policy = Policy::create([
                'customer_id' => $validated['customer_id'],
                'insurance_company_id' => $validated['insurance_company_id'],
                'policy_number' => $validated['policy_number'],
                'policy_type' => $validated['policy_type'],
                'vehicle_plate' => $validated['vehicle_plate'] ?? null,
                'vehicle_brand' => $validated['vehicle_brand'] ?? null,
                'vehicle_model' => $validated['vehicle_model'] ?? null,
                'vehicle_year' => $validated['vehicle_year'] ?? null,
                'vehicle_chassis_no' => $validated['vehicle_chassis_no'] ?? null,
                'property_address' => $validated['property_address'] ?? null,
                'property_area' => $validated['property_area'] ?? null,
                'property_floor' => $validated['property_floor'] ?? null,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'premium_amount' => $validated['premium_amount'],
                'commission_rate' => $commissionRate,
                'commission_amount' => $commissionAmount,
                'status' => 'active',
                'notes' => $validated['notes'] ?? null,
                'created_by' => auth()->id(),
            ]);

            // ✅ PolicyObserver otomatik cari kayıt oluşturacak
            // Müşteri carisine +premium_amount BORÇ
            // Şirket carisine -(premium_amount - commission_amount) ALACAK

            $policy->customer->updateStats();

            DB::commit();

            return redirect()->route('policies.show', $policy)
                ->with('success', 'Poliçe başarıyla oluşturuldu. Müşteri carisine ' . number_format($validated['premium_amount'], 2) . '₺ borç kaydedildi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Poliçe oluşturulurken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Poliçe detay
     */
    public function show(Policy $policy)
    {
        $policy->load([
            'customer.cariHesap',  // ✅ YENİ: Müşteri cari hesabı
            'insuranceCompany.cariHesap',  // ✅ YENİ: Şirket cari hesabı
            'createdBy',
            'cariHareketler',  // ✅ YENİ: Bu poliçeye ait cari hareketler
            'renewal',
            'reminders',
        ]);

        // ✅ YENİ: Bu poliçeye yapılan tahsilatları getir
        // $tahsilatlar = \App\Models\Tahsilat::whereHas('cariHareketler', function($q) use ($policy) {
        //     $q->where('referans_tip', 'policy')
        //       ->where('referans_id', $policy->id);
        // })
        // ->with('musteriCari.customer', 'kasaBanka')
        // ->latest()
        // ->get();
        $tahsilatlar = $policy->tahsilatlar()
            ->with('musteriCari.customer', 'kasaBanka')
            ->latest()
            ->get();

        // $tahsilatlar = Tahsilat::where('policy_id', $policy->id)
        //     ->with('musteriCari.customer', 'kasaBanka')
        //     ->latest()
        //     ->get();

        // dd($tahsilatlar);

        // ✅ YENİ: Ödeme durumu hesapla
        $toplamOdenen = $tahsilatlar->sum('tutar');
        $kalanBorc = $policy->premium_amount - $toplamOdenen;
        $odemeYuzdesi = $policy->premium_amount > 0
            ? round(($toplamOdenen / $policy->premium_amount) * 100, 2)
            : 0;

        return view('policies.show', compact('policy', 'tahsilatlar', 'toplamOdenen', 'kalanBorc', 'odemeYuzdesi'));
    }

    /**
     * Poliçe düzenleme formu
     */
    public function edit(Policy $policy)
    {
        $customers = Customer::with('cariHesap')->orderBy('name')->get();
        $insuranceCompanies = InsuranceCompany::active()->get();

        return view('policies.edit', compact('policy', 'customers', 'insuranceCompanies'));
    }

    /**
     * Poliçe güncelle
     */
    public function update(Request $request, Policy $policy)
    {
        $validated = $this->validatePolicy($request, $policy);

        DB::beginTransaction();
        try {
            $commissionRate = $validated['commission_rate'] ?? $policy->commission_rate;
            $commissionAmount = ($validated['premium_amount'] * $commissionRate) / 100;

            $policy->update([
                'customer_id' => $validated['customer_id'],
                'insurance_company_id' => $validated['insurance_company_id'],
                'policy_number' => $validated['policy_number'],
                'policy_type' => $validated['policy_type'],
                'vehicle_plate' => $validated['vehicle_plate'] ?? null,
                'vehicle_brand' => $validated['vehicle_brand'] ?? null,
                'vehicle_model' => $validated['vehicle_model'] ?? null,
                'vehicle_year' => $validated['vehicle_year'] ?? null,
                'vehicle_chassis_no' => $validated['vehicle_chassis_no'] ?? null,
                'property_address' => $validated['property_address'] ?? null,
                'property_area' => $validated['property_area'] ?? null,
                'property_floor' => $validated['property_floor'] ?? null,
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'premium_amount' => $validated['premium_amount'],
                'commission_rate' => $commissionRate,
                'commission_amount' => $commissionAmount,
                'notes' => $validated['notes'] ?? null,
            ]);

            $policy->updateStatus();
            $policy->customer->updateStats();

            DB::commit();

            return redirect()->route('policies.show', $policy)
                ->with('success', 'Poliçe başarıyla güncellendi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Poliçe güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Poliçe sil
     */
    public function destroy(Policy $policy)
    {
        if ($policy->renewal && $policy->renewal->status === 'renewed') {
            return back()->with('error', 'Yenilenmiş poliçeler silinemez.');
        }

        DB::beginTransaction();
        try {
            $customerId = $policy->customer_id;

            // ✅ PolicyObserver otomatik cari kayıtları da silecek
            $policy->delete();

            Customer::find($customerId)?->updateStats();

            DB::commit();

            return redirect()->route('policies.index')
                ->with('success', 'Poliçe ve ilgili cari kayıtlar başarıyla silindi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Poliçe silinirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Validasyon
     */
    private function validatePolicy(Request $request, ?Policy $policy = null)
    {
        $rules = [
            'customer_id' => 'required|exists:customers,id',
            'insurance_company_id' => 'required|exists:insurance_companies,id',
            'policy_number' => 'required|string|max:50|unique:policies,policy_number,' . ($policy?->id ?? 'NULL'),
            'policy_type' => 'required|in:kasko,trafik,konut,dask,saglik,hayat,tss',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
            'premium_amount' => 'required|numeric|min:0',
            'commission_rate' => 'nullable|numeric|min:0|max:100',
            'notes' => 'nullable|string',
        ];

        if (in_array($request->policy_type, ['kasko', 'trafik'])) {
            $rules['vehicle_plate'] = 'required|string|max:20';
            $rules['vehicle_brand'] = 'nullable|string|max:50';
            $rules['vehicle_model'] = 'nullable|string|max:50';
            $rules['vehicle_year'] = 'nullable|integer|min:1900|max:' . (date('Y') + 1);
            $rules['vehicle_chassis_no'] = 'nullable|string|max:50';
        }

        if (in_array($request->policy_type, ['konut', 'dask'])) {
            $rules['property_address'] = 'required|string';
            $rules['property_area'] = 'nullable|numeric|min:0';
            $rules['property_floor'] = 'nullable|integer|min:0';
        }

        return $request->validate($rules, [
            'customer_id.required' => 'Müşteri seçilmelidir.',
            'insurance_company_id.required' => 'Sigorta şirketi seçilmelidir.',
            'policy_number.required' => 'Poliçe numarası gereklidir.',
            'policy_number.unique' => 'Bu poliçe numarası zaten kullanılıyor.',
            'policy_type.required' => 'Poliçe türü seçilmelidir.',
            'start_date.required' => 'Başlangıç tarihi gereklidir.',
            'end_date.required' => 'Bitiş tarihi gereklidir.',
            'end_date.after' => 'Bitiş tarihi başlangıç tarihinden sonra olmalıdır.',
            'premium_amount.required' => 'Prim tutarı gereklidir.',
            'premium_amount.min' => 'Prim tutarı 0\'dan büyük olmalıdır.',
            'vehicle_plate.required' => 'Plaka bilgisi gereklidir.',
            'property_address.required' => 'Adres bilgisi gereklidir.',
        ]);
    }

    /**
     * Poliçe istatistikleri
     */
    private function getPolicyStats()
    {
        return [
            'total' => Policy::count(),
            'active' => Policy::active()->count(),
            'expiring_soon' => Policy::expiringSoon()->count(),
            'critical' => Policy::critical()->count(),
            'expired' => Policy::expired()->count(),
        ];
    }
}
