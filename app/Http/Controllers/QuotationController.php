<?php

namespace App\Http\Controllers;

use App\Models\Quotation;
use App\Models\QuotationItem;
use App\Models\Customer;
use App\Models\InsuranceCompany;
use App\Models\Policy;
use App\Models\Setting;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use App\Services\QuotationPdfService;
use App\Services\QuotationEmailService;

class QuotationController extends Controller
{
    protected $pdfService;
    protected $emailService;

    public function __construct(QuotationPdfService $pdfService, QuotationEmailService $emailService)
    {
        $this->pdfService = $pdfService;
        $this->emailService = $emailService;
    }

    /**
     * Teklif listesi
     */
    public function index(Request $request)
    {
        $query = Quotation::with(['customer', 'items.insuranceCompany', 'createdBy']);

        // Search
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

        // Status filter
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Type filter
        if ($request->filled('quotation_type')) {
            $query->where('quotation_type', $request->quotation_type);
        }

        // Date filter
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        $quotations = $query->latest()->get();

        // Stats
        $stats = [
            'total' => Quotation::count(),
            'draft' => Quotation::draft()->count(),
            'sent' => Quotation::sent()->count(),
            'viewed' => Quotation::where('status', 'viewed')->count(),
            'approved' => Quotation::approved()->count(),
            'converted' => Quotation::converted()->count(),
            'expired' => Quotation::expired()->count(),
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
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.company_id' => 'required|exists:insurance_companies,id',
            'items.*.premium_amount' => 'required|numeric|min:0',
            'items.*.coverage_summary' => 'nullable|string',
            'items.*.is_recommended' => 'nullable|boolean',
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
                'notes' => $validated['notes'] ?? null,
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

            // İlk revizyon
            $quotation->createRevision('İlk teklif oluşturuldu');

            DB::commit();

            return redirect()->route('quotations.show', $quotation)
                ->with('success', 'Teklif başarıyla oluşturuldu.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Teklif oluşturulurken hata: ' . $e->getMessage());
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
            'revisions.createdBy',
            'documents.uploadedBy',
            'emails.sentBy',
            'activityLogs.user',
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
            'notes' => 'nullable|string',
            'items' => 'required|array|min:1',
            'items.*.company_id' => 'required|exists:insurance_companies,id',
            'items.*.premium_amount' => 'required|numeric|min:0',
            'items.*.coverage_summary' => 'nullable|string',
            'items.*.is_recommended' => 'nullable|boolean',
            'create_revision' => 'nullable|boolean',
            'revision_notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            // Revizyon oluştur
            if ($validated['create_revision'] ?? false) {
                $quotation->createRevision($validated['revision_notes'] ?? 'Teklif güncellendi');
            }

            $quotation->update([
                'customer_id' => $validated['customer_id'],
                'quotation_type' => $validated['quotation_type'],
                'vehicle_info' => $validated['vehicle_info'] ?? null,
                'property_info' => $validated['property_info'] ?? null,
                'coverage_details' => $validated['coverage_details'] ?? null,
                'valid_until' => $validated['valid_until'],
                'notes' => $validated['notes'] ?? null,
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
                ->with('error', 'Teklif güncellenirken hata: ' . $e->getMessage());
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

        $quotation->logActivity('deleted', 'Teklif silindi');
        $quotation->delete();

        return redirect()->route('quotations.index')
            ->with('success', 'Teklif başarıyla silindi.');
    }

    /**
     * PDF Print Sayfası
     */
    public function print(Quotation $quotation)
    {
        $quotation->load(['customer', 'items.insuranceCompany', 'createdBy']);

        $agency_info = [
            'company_name' => Setting::get('company_name'),
            'company_address' => Setting::get('company_address'),
            'company_phone' => Setting::get('company_phone'),
            'company_email' => Setting::get('company_email'),
        ];

        return view('quotations.print', compact('quotation', 'agency_info'));
    }

    /**
     * PDF oluşturuldu olarak işaretle
     */
    public function markPdfGenerated(Quotation $quotation)
    {
        $this->pdfService->markAsPrinted($quotation);

        return response()->json(['success' => true]);
    }

    /**
     * Email gönder
     */
    public function sendEmail(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'recipient_email' => 'required|email',
            'recipient_name' => 'nullable|string',
            'custom_message' => 'nullable|string',
        ]);

        $result = $this->emailService->sendQuotation(
            $quotation,
            $validated['recipient_email'],
            $validated['recipient_name'] ?? null,
            $validated['custom_message'] ?? null
        );

        if ($result['success']) {
            return back()->with('success', $result['message']);
        } else {
            return back()->with('error', $result['message']);
        }
    }

    /**
     * Müşteri görünümü (Public)
     */
    public function view($token)
    {
        $quotation = Quotation::where('shared_link_token', $token)->firstOrFail();

        // View kaydı
        $quotation->views()->create([
            'viewed_at' => now(),
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'device_type' => $this->detectDeviceType(request()->userAgent()),
        ]);

        $quotation->incrementViewCount();

        $quotation->load(['customer', 'items.insuranceCompany']);

        $agency_info = [
            'company_name' => Setting::get('company_name'),
            'company_address' => Setting::get('company_address'),
            'company_phone' => Setting::get('company_phone'),
            'company_email' => Setting::get('company_email'),
        ];

        return view('quotations.view', compact('quotation', 'agency_info'));
    }

    /**
     * Müşteri onayı
     */
    public function customerApprove(Request $request, $token)
    {
        $quotation = Quotation::where('shared_link_token', $token)->firstOrFail();

        $validated = $request->validate([
            'customer_response' => 'required|in:approved,rejected',
            'customer_note' => 'nullable|string|max:1000',
        ]);

        $quotation->update([
            'status' => $validated['customer_response'] === 'approved' ? 'approved' : 'rejected',
            'customer_response' => $validated['customer_response'],
            'customer_note' => $validated['customer_note'],
            'customer_responded_at' => now(),
        ]);

        $quotation->logActivity(
            'customer_response',
            "Müşteri yanıtı: " . ($validated['customer_response'] === 'approved' ? 'Onaylandı' : 'Reddedildi')
        );

        $message = $validated['customer_response'] === 'approved'
            ? 'Teklif onaylandı. Teşekkür ederiz!'
            : 'Geri bildiriminiz için teşekkürler.';

        return back()->with('success', $message);
    }

    /**
     * Email tracking - Open
     */
    public function trackEmailOpen($trackingToken)
    {
        $this->emailService->trackOpen($trackingToken);

        // 1x1 pixel transparent GIF
        return response(base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7'))
            ->header('Content-Type', 'image/gif');
    }

    /**
     * Email tracking - Click
     */
    public function trackEmailClick($trackingToken)
    {
        $this->emailService->trackClick($trackingToken);

        $email = \App\Models\QuotationEmail::where('tracking_token', $trackingToken)->first();

        if ($email && $email->quotation) {
            return redirect($email->quotation->share_url);
        }

        return redirect()->route('home');
    }

    /**
     * Poliçeye dönüştür (CARİ SİSTEM ENTEGRE)
     */
    public function convert(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'selected_item_id' => 'required|exists:quotation_items,id',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after:start_date',
        ]);

        DB::beginTransaction();
        try {
            $selectedItem = QuotationItem::with('insuranceCompany')->findOrFail($validated['selected_item_id']);

            // 1. POLİÇE NUMARASI OLUŞTUR
            $policyNumber = $this->generatePolicyNumber($quotation->quotation_type);

            // 2. KOMİSYON HESAPLA
            $commissionRate = $selectedItem->insuranceCompany->getCommissionRate($quotation->quotation_type);
            $commissionAmount = ($selectedItem->premium_amount * $commissionRate) / 100;

            // 3. POLİÇE OLUŞTUR
            $policy = Policy::create([
                'customer_id' => $quotation->customer_id,
                'insurance_company_id' => $selectedItem->insurance_company_id,
                'policy_number' => $policyNumber,
                'policy_type' => $quotation->quotation_type,

                // Araç Bilgileri
                'vehicle_plate' => $quotation->vehicle_info['plate'] ?? null,
                'vehicle_brand' => $quotation->vehicle_info['brand'] ?? null,
                'vehicle_model' => $quotation->vehicle_info['model'] ?? null,
                'vehicle_year' => $quotation->vehicle_info['year'] ?? null,
                'vehicle_chassis_no' => $quotation->vehicle_info['chassis'] ?? null,

                // Konut Bilgileri
                'property_address' => $quotation->property_info['address'] ?? null,
                'property_area' => $quotation->property_info['area'] ?? null,
                'property_floor' => $quotation->property_info['floor'] ?? null,

                // Tarih & Tutar Bilgileri
                'start_date' => $validated['start_date'],
                'end_date' => $validated['end_date'],
                'premium_amount' => $selectedItem->premium_amount,
                'commission_rate' => $commissionRate,
                'commission_amount' => $commissionAmount,

                'status' => 'active',
                'notes' => $quotation->notes,
                'created_by' => auth()->id(),
            ]);

            // ✅ PolicyObserver otomatik çalışacak ve şunları yapacak:
            // - Müşteri carisine: +premium_amount BORÇ
            // - Şirket carisine: -(premium_amount - commission_amount) ALACAK

            // 4. TEKLİFİ DÖNÜŞTÜR
            $quotation->convertToPolicy($policy->id, $selectedItem->insurance_company_id);

            // 5. MÜŞTERİ İSTATİSTİKLERİNİ GÜNCELLE
            $quotation->customer->updateStats();

            // 6. AKTİVİTE LOGU
            $quotation->logActivity('converted_to_policy', "Poliçe #{$policy->policy_number} oluşturuldu. Müşteri carisine " . number_format($selectedItem->premium_amount, 2) . "₺ borç kaydedildi.");

            DB::commit();

            return redirect()->route('policies.show', $policy)
                ->with('success', 'Teklif başarıyla poliçeye dönüştürüldü! Müşteri carisine ' . number_format($selectedItem->premium_amount, 2) . '₺ borç kaydedildi.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', 'Poliçe oluşturulurken hata: ' . $e->getMessage());
        }
    }

    /**
     * Dosya yükle
     */
    public function uploadDocument(Request $request, Quotation $quotation)
    {
        $validated = $request->validate([
            'document' => 'required|file|max:10240', // 10MB
            'document_type' => 'required|in:pdf,contract,policy,attachment,other',
            'description' => 'nullable|string|max:500',
        ]);

        $file = $request->file('document');
        $filename = time() . '_' . $file->getClientOriginalName();
        $path = $file->storeAs('quotations/documents', $filename, 'public');

        $quotation->documents()->create([
            'uploaded_by' => auth()->id(),
            'file_name' => $file->getClientOriginalName(),
            'file_path' => 'public/' . $path,
            'file_type' => $file->getClientMimeType(),
            'file_size' => $file->getSize(),
            'document_type' => $validated['document_type'],
            'description' => $validated['description'] ?? null,
        ]);

        $quotation->logActivity('document_uploaded', 'Dosya yüklendi: ' . $file->getClientOriginalName());

        return back()->with('success', 'Dosya başarıyla yüklendi.');
    }

    /**
     * Dosya sil
     */
    public function deleteDocument(Quotation $quotation, $documentId)
    {
        $document = $quotation->documents()->findOrFail($documentId);

        // Fiziksel dosyayı sil
        if (\Storage::exists($document->file_path)) {
            \Storage::delete($document->file_path);
        }

        $document->delete();

        $quotation->logActivity('document_deleted', 'Dosya silindi: ' . $document->file_name);

        return back()->with('success', 'Dosya başarıyla silindi.');
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
