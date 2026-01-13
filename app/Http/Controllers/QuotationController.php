<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Customer;
use App\Models\InsuranceCompany;
use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class QuotationController extends Controller
{
    /**
     * Teklif listesi
     */
    public function index(Request $request)
    {
        $query = Quotation::with(['customer', 'items.insuranceCompany']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('quotation_number', 'like', "%{$search}%")
                  ->orWhereHas('customer', function($q) use ($search) {
                      $q->where('name', 'like', "%{$search}%")
                        ->orWhere('phone', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('quotation_type')) {
            $query->where('quotation_type', $request->quotation_type);
        }

        if ($request->filled('date_filter')) {
            switch ($request->date_filter) {
                case 'valid':
                    $query->where('valid_until', '>=', now());
                    break;
                case 'expired':
                    $query->where('valid_until', '<', now());
                    break;
            }
        }

        $quotations = $query->get();

        $stats = [
            'total' => Quotation::count(),
            'sent' => Quotation::sent()->count(),
            'approved' => Quotation::approved()->count(),
            'converted' => Quotation::converted()->count(),
            'expired' => Quotation::where('valid_until', '<', now())->where('status', '!=', 'converted')->count(),
            'viewed' => Quotation::where('status', 'viewed')->count(),

        ];

        return view('quotations.index', compact('quotations', 'stats'));
    }

    /**
     * Yeni teklif formu
     */
    public function create(Request $request)
    {
        $customers = Customer::where('status', '!=', 'lost')
            ->orderBy('name')
            ->get();

        $insuranceCompanies = InsuranceCompany::active()->get();

        $selectedCustomer = $request->customer_id
            ? Customer::find($request->customer_id)
            : null;

        return view('quotations.create', compact('customers', 'insuranceCompanies', 'selectedCustomer'));
    }

    /**
     * Teklif kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quotation_type' => 'required|in:kasko,trafik,konut,dask,saglik,hayat,tss',
            'vehicle_info' => 'nullable|array',
            'property_info' => 'nullable|array',
            'coverage_details' => 'nullable|array',
            'valid_until' => 'required|date|after:today',
            'items' => 'required|array|min:1',
            'items.*.company_id' => 'required|exists:insurance_companies,id',
            'items.*.premium_amount' => 'required|numeric|min:0',
            'items.*.coverage_summary' => 'nullable|string',
            'items.*.is_recommended' => 'nullable|boolean',
        ], [
            'customer_id.required' => 'Müşteri seçilmelidir.',
            'quotation_type.required' => 'Teklif türü seçilmelidir.',
            'valid_until.required' => 'Geçerlilik tarihi gereklidir.',
            'valid_until.after' => 'Geçerlilik tarihi bugünden sonra olmalıdır.',
            'items.required' => 'En az bir şirket teklifi eklenmelidir.',
            'items.min' => 'En az bir şirket teklifi eklenmelidir.',
        ]);

        DB::beginTransaction();
        try {
            $quotationNumber = $this->generateQuotationNumber();

            $quotation = Quotation::create([
                'customer_id' => $validated['customer_id'],
                'quotation_number' => $quotationNumber,
                'quotation_type' => $validated['quotation_type'],
                'vehicle_info' => $validated['vehicle_info'] ?? null,
                'property_info' => $validated['property_info'] ?? null,
                'coverage_details' => $validated['coverage_details'] ?? null,
                'valid_until' => $validated['valid_until'],
                'status' => 'draft',
                'shared_link_token' => Str::random(32),
                'created_by' => auth()->id(),
            ]);

            foreach ($validated['items'] as $index => $item) {
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'insurance_company_id' => $item['company_id'],
                    'premium_amount' => $item['premium_amount'],
                    'coverage_summary' => $item['coverage_summary'] ?? null,
                    'is_recommended' => $item['is_recommended'] ?? false,
                    'rank' => $index + 1,
                ]);
            }

            DB::commit();

            return redirect()->route('quotations.show', $quotation)
                ->with('success', 'Teklif başarıyla oluşturuldu.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Teklif oluşturulurken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Teklif detay
     */
    public function show(Quotation $quotation)
    {
        $quotation->load([
            'customer',
            'items.insuranceCompany',
            'selectedCompany',
            'convertedPolicy',
            'views',
            'createdBy',
        ]);

        return view('quotations.show', compact('quotation'));
    }

    /**
     * Teklif düzenleme
     */
    public function edit(Quotation $quotation)
    {
        if ($quotation->status === 'converted') {
            return back()->with('error', 'Poliçeye dönüştürülmüş teklifler düzenlenemez.');
        }

        $quotation->load('items');
        $customers = Customer::orderBy('name')->get();
        $insuranceCompanies = InsuranceCompany::active()->get();

        return view('quotations.edit', compact('quotation', 'customers', 'insuranceCompanies'));
    }

    /**
     * Teklif güncelle
     */
    public function update(Request $request, Quotation $quotation)
    {
        if ($quotation->status === 'converted') {
            return back()->with('error', 'Poliçeye dönüştürülmüş teklifler düzenlenemez.');
        }

        $validated = $request->validate([
            'customer_id' => 'required|exists:customers,id',
            'quotation_type' => 'required|in:kasko,trafik,konut,dask,saglik,hayat,tss',
            'vehicle_info' => 'nullable|array',
            'property_info' => 'nullable|array',
            'coverage_details' => 'nullable|array',
            'valid_until' => 'required|date',
            'items' => 'required|array|min:1',
            'items.*.company_id' => 'required|exists:insurance_companies,id',
            'items.*.premium_amount' => 'required|numeric|min:0',
            'items.*.coverage_summary' => 'nullable|string',
            'items.*.is_recommended' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            $quotation->update([
                'customer_id' => $validated['customer_id'],
                'quotation_type' => $validated['quotation_type'],
                'vehicle_info' => $validated['vehicle_info'] ?? null,
                'property_info' => $validated['property_info'] ?? null,
                'coverage_details' => $validated['coverage_details'] ?? null,
                'valid_until' => $validated['valid_until'],
            ]);

            $quotation->items()->delete();

            foreach ($validated['items'] as $index => $item) {
                QuotationItem::create([
                    'quotation_id' => $quotation->id,
                    'insurance_company_id' => $item['company_id'],
                    'premium_amount' => $item['premium_amount'],
                    'coverage_summary' => $item['coverage_summary'] ?? null,
                    'is_recommended' => $item['is_recommended'] ?? false,
                    'rank' => $index + 1,
                ]);
            }

            DB::commit();

            return redirect()->route('quotations.show', $quotation)
                ->with('success', 'Teklif başarıyla güncellendi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Teklif güncellenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Teklif sil
     */
    public function destroy(Quotation $quotation)
    {
        if ($quotation->status === 'converted') {
            return back()->with('error', 'Poliçeye dönüştürülmüş teklifler silinemez.');
        }

        $quotation->delete();

        return redirect()->route('quotations.index')
            ->with('success', 'Teklif başarıyla silindi.');
    }

    /**
     * Teklifi müşteriye gönder
     */
    public function send(Quotation $quotation)
    {
        if ($quotation->status === 'draft') {
            $quotation->update(['status' => 'sent']);
        }

        // SMS/Email gönderimi burada yapılacak

        return back()->with('success', 'Teklif müşteriye gönderildi. Paylaşım linki kopyalandı.');
    }

    /**
     * Müşteri görünümü (Public)
     */
    public function view($token)
    {
        $quotation = Quotation::where('shared_link_token', $token)->firstOrFail();

        $quotation->views()->create([
            'viewed_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'device_type' => $this->detectDeviceType(request()->userAgent()),
        ]);

        $quotation->incrementViewCount();

        $quotation->load(['customer', 'items.insuranceCompany']);

        return view('quotations.view', compact('quotation'));
    }

    /**
     * Poliçeye dönüştür
     */
    public function convert(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'selected_item_id' => 'required|exists:quotation_items,id',
            'start_date' => 'required|date',
            'payment_type' => 'required|in:cash,installment',
            'installment_count' => 'nullable|integer|min:1|max:12',
        ]);

        DB::beginTransaction();
        try {
            $selectedItem = QuotationItem::findOrFail($validated['selected_item_id']);

            $policyNumber = $this->generatePolicyNumber($quotation->quotation_type);

            $commissionRate = $selectedItem->insuranceCompany->getCommissionRate($quotation->quotation_type);
            $commissionAmount = ($selectedItem->premium_amount * $commissionRate) / 100;

            $policy = Policy::create([
                'customer_id' => $quotation->customer_id,
                'insurance_company_id' => $selectedItem->insurance_company_id,
                'policy_number' => $policyNumber,
                'policy_type' => $quotation->quotation_type,
                'vehicle_plate' => $quotation->vehicle_info['plate'] ?? null,
                'vehicle_brand' => $quotation->vehicle_info['brand'] ?? null,
                'vehicle_model' => $quotation->vehicle_info['model'] ?? null,
                'vehicle_year' => $quotation->vehicle_info['year'] ?? null,
                'vehicle_chassis_no' => $quotation->vehicle_info['chassis'] ?? null,
                'property_address' => $quotation->property_info['address'] ?? null,
                'property_area' => $quotation->property_info['area'] ?? null,
                'property_floor' => $quotation->property_info['floor'] ?? null,
                'start_date' => $validated['start_date'],
                'end_date' => now()->parse($validated['start_date'])->addYear(),
                'premium_amount' => $selectedItem->premium_amount,
                'commission_rate' => $commissionRate,
                'commission_amount' => $commissionAmount,
                'payment_type' => $validated['payment_type'],
                'installment_count' => $validated['installment_count'] ?? 1,
                'status' => 'active',
                'created_by' => auth()->id(),
            ]);

            $paymentPlan = $policy->paymentPlan()->create([
                'customer_id' => $policy->customer_id,
                'total_amount' => $selectedItem->premium_amount,
                'installment_count' => $validated['installment_count'] ?? 1,
                'payment_type' => $validated['payment_type'],
            ]);

            $paymentPlan->generateInstallments();

            $quotation->convertToPolicy($policy->id, $selectedItem->insurance_company_id);

            $quotation->customer->updateStats();

            DB::commit();

            return redirect()->route('policies.show', $policy)
                ->with('success', 'Teklif başarıyla poliçeye dönüştürüldü.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Poliçe oluşturulurken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Teklif numarası oluştur
     */
    private function generateQuotationNumber(): string
    {
        $prefix = 'TKL';
        $year = date('Y');
        $month = date('m');

        $lastQuotation = Quotation::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastQuotation ? (intval(substr($lastQuotation->quotation_number, -4)) + 1) : 1;

        return sprintf('%s-%s%s-%04d', $prefix, $year, $month, $sequence);
    }

    /**
     * Poliçe numarası oluştur
     */
    private function generatePolicyNumber(string $type): string
    {
        $prefixes = [
            'kasko' => 'KSK',
            'trafik' => 'TRF',
            'konut' => 'KNT',
            'dask' => 'DASK',
            'saglik' => 'SGL',
            'hayat' => 'HYT',
            'tss' => 'TSS',
        ];

        $prefix = $prefixes[$type] ?? 'POL';
        $year = date('Y');

        $lastPolicy = Policy::where('policy_type', $type)
            ->whereYear('created_at', $year)
            ->orderBy('id', 'desc')
            ->first();

        $sequence = $lastPolicy ? (intval(substr($lastPolicy->policy_number, -4)) + 1) : 1;

        return sprintf('%s-%s-%04d', $prefix, $year, $sequence);
    }

    /**
     * Cihaz tipini algıla
     */
    private function detectDeviceType(string $userAgent): string
    {
        if (preg_match('/mobile/i', $userAgent)) {
            return 'mobile';
        } elseif (preg_match('/tablet/i', $userAgent)) {
            return 'tablet';
        }
        return 'desktop';
    }
}
