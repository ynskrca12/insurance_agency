<?php

namespace App\Http\Controllers;

use App\Models\InsuranceCompany;
use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class InsuranceCompanyController extends Controller
{
    /**
     * Şirket listesi
     */
    public function index(Request $request)
    {
        $query = InsuranceCompany::withCount('policies');

        // Arama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('code', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Durum filtresi
        if ($request->filled('is_active')) {
            $query->where('is_active', $request->is_active);
        }

        // Sıralama
        $sortBy = $request->get('sort_by', 'display_order');
        $sortOrder = $request->get('sort_order', 'asc');
        $query->orderBy($sortBy, $sortOrder);

        $companies = $query->paginate(20)->withQueryString();

        // İstatistikler
        $stats = [
            'total' => InsuranceCompany::count(),
            'active' => InsuranceCompany::where('is_active', true)->count(),
            'inactive' => InsuranceCompany::where('is_active', false)->count(),
            'total_policies' => Policy::count(),
        ];

        return view('insurance-companies.index', compact('companies', 'stats'));
    }

    /**
     * Yeni şirket formu
     */
    public function create()
    {
        return view('insurance-companies.create');
    }

    /**
     * Şirket kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:insurance_companies,name',
            'code' => 'required|string|max:10|unique:insurance_companies,code',
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',

            // Komisyon oranları
            'default_commission_kasko' => 'nullable|numeric|min:0|max:100',
            'default_commission_trafik' => 'nullable|numeric|min:0|max:100',
            'default_commission_konut' => 'nullable|numeric|min:0|max:100',
            'default_commission_dask' => 'nullable|numeric|min:0|max:100',
            'default_commission_saglik' => 'nullable|numeric|min:0|max:100',
            'default_commission_hayat' => 'nullable|numeric|min:0|max:100',
            'default_commission_tss' => 'nullable|numeric|min:0|max:100',

            'is_active' => 'nullable|boolean',
            'display_order' => 'nullable|integer|min:0',
        ]);

        try {
            if ($request->hasFile('logo')) {

                $file = $request->file('logo');

                // Klasör yolu (public altında)
                $destinationPath = public_path('insurance_companies');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Dosya adı (istersen uniq yapabilirsin)
                $fileName = time() . '_' . $file->getClientOriginalName();

                // Dosyayı public altına taşı
                $file->move($destinationPath, $fileName);

                $validated['logo'] = $fileName;
            }

            // Varsayılan değerler
            $validated['is_active'] = $request->boolean('is_active', true);
            $validated['display_order'] = $validated['display_order'] ?? 0;

            InsuranceCompany::create($validated);

            return redirect()->route('insurance-companies.index')
                ->with('success', 'Sigorta şirketi başarıyla eklendi.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Şirket eklenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Şirket detay
     */
    public function show(InsuranceCompany $insuranceCompany)
    {
        $insuranceCompany->loadCount('policies');

        // Poliçe türüne göre dağılım
        $policyDistribution = Policy::where('insurance_company_id', $insuranceCompany->id)
            ->select('policy_type', DB::raw('COUNT(*) as count'), DB::raw('SUM(premium_amount) as total_premium'))
            ->groupBy('policy_type')
            ->get();

        // Son poliçeler
        $recentPolicies = Policy::where('insurance_company_id', $insuranceCompany->id)
            ->with('customer')
            ->latest()
            ->limit(10)
            ->get();

        // Aylık istatistikler
        $monthlyStats = Policy::where('insurance_company_id', $insuranceCompany->id)
            ->whereYear('created_at', now()->year)
            ->select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('COUNT(*) as count'),
                DB::raw('SUM(premium_amount) as total_premium'),
                DB::raw('SUM(commission_amount) as total_commission')
            )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        // Toplam istatistikler
        $stats = [
            'total_policies' => Policy::where('insurance_company_id', $insuranceCompany->id)->count(),
            'total_premium' => Policy::where('insurance_company_id', $insuranceCompany->id)->sum('premium_amount'),
            'total_commission' => Policy::where('insurance_company_id', $insuranceCompany->id)->sum('commission_amount'),
            'active_policies' => Policy::where('insurance_company_id', $insuranceCompany->id)
                ->where('status', 'active')->count(),
        ];

        return view('insurance-companies.show', compact(
            'insuranceCompany',
            'policyDistribution',
            'recentPolicies',
            'monthlyStats',
            'stats'
        ));
    }

    /**
     * Şirket düzenleme formu
     */
    public function edit(InsuranceCompany $insuranceCompany)
    {
        return view('insurance-companies.edit', compact('insuranceCompany'));
    }

    /**
     * Şirket güncelle
     */
    public function update(Request $request, InsuranceCompany $insuranceCompany)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:insurance_companies,name,' . $insuranceCompany->id,
            'code' => 'required|string|max:10|unique:insurance_companies,code,' . $insuranceCompany->id,
            'phone' => 'nullable|string|max:20',
            'email' => 'nullable|email|max:255',
            'website' => 'nullable|url|max:255',
            'logo' => 'nullable|image|mimes:jpeg,jpg,png,gif,svg|max:2048',

            // Komisyon oranları
            'default_commission_kasko' => 'nullable|numeric|min:0|max:100',
            'default_commission_trafik' => 'nullable|numeric|min:0|max:100',
            'default_commission_konut' => 'nullable|numeric|min:0|max:100',
            'default_commission_dask' => 'nullable|numeric|min:0|max:100',
            'default_commission_saglik' => 'nullable|numeric|min:0|max:100',
            'default_commission_hayat' => 'nullable|numeric|min:0|max:100',
            'default_commission_tss' => 'nullable|numeric|min:0|max:100',

            'is_active' => 'nullable|boolean',
            'display_order' => 'nullable|integer|min:0',
        ]);

        try {
            if ($request->hasFile('logo')) {

                $destinationPath = public_path('insurance_companies');

                if (!file_exists($destinationPath)) {
                    mkdir($destinationPath, 0755, true);
                }

                // Eski logoyu sil
                if ($insuranceCompany->logo) {
                    $oldLogoPath = $destinationPath . '/' . $insuranceCompany->logo;

                    if (file_exists($oldLogoPath)) {
                        unlink($oldLogoPath);
                    }
                }

                $file = $request->file('logo');

                // Güvenli ve çakışmayan dosya adı
                $fileName = Str::uuid() . '.' . $file->getClientOriginalExtension();

                // Dosyayı public altına taşı
                $file->move($destinationPath, $fileName);

                $validated['logo'] = $fileName;
            }

            $validated['is_active'] = $request->boolean('is_active', true);

            $insuranceCompany->update($validated);

            return redirect()->route('insurance-companies.show', $insuranceCompany)
                ->with('success', 'Şirket bilgileri başarıyla güncellendi.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Şirket güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Şirket sil
     */
    public function destroy(InsuranceCompany $insuranceCompany)
    {
        // Şirkete ait poliçe var mı kontrol et
        if ($insuranceCompany->policies()->count() > 0) {
            return back()->with('error', 'Bu şirkete ait poliçeler olduğu için silinemez.');
        }

        try {
            // Logo sil
            if ($insuranceCompany->logo) {
                Storage::disk('public')->delete($insuranceCompany->logo);
            }

            $insuranceCompany->delete();

            return redirect()->route('insurance-companies.index')
                ->with('success', 'Şirket başarıyla silindi.');

        } catch (\Exception $e) {
            return back()->with('error', 'Şirket silinirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Durum değiştir (AJAX)
     */
    public function toggleStatus(InsuranceCompany $insuranceCompany)
    {
        try {
            $insuranceCompany->update([
                'is_active' => !$insuranceCompany->is_active
            ]);

            return response()->json([
                'success' => true,
                'is_active' => $insuranceCompany->is_active,
                'message' => 'Durum başarıyla güncellendi.',
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Bir hata oluştu: ' . $e->getMessage(),
            ], 500);
        }
    }
}
