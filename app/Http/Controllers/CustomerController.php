<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\Models\CustomerNote;
use App\Models\Policy;
use App\Models\CustomerDocument;

class CustomerController extends Controller
{
    /**
     * Müşteri listesi
     */
    public function index(Request $request)
    {
        // ✅ CARİ İLİŞKİSİ EKLE
        $query = Customer::with(['assignedTo', 'cariHesap'])
            ->withCount('policies')
            ->orderBy('created_at', 'desc');

        // Durum filtresi
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Şehir filtresi
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        $customers = $query->get();

        // Şehirler (filtre için)
        $cities = Customer::distinct()->pluck('city')->filter()->sort()->values();

        // İstatistikler
        $stats = [
            'total_customers' => Customer::count(),
            'active_customers' => Customer::where('status', 'active')->count(),
            'potential_customers' => Customer::doesntHave('policies')->count(),
            'total_policies' => Policy::count(),
        ];

        return view('customers.index', compact('customers', 'cities', 'stats'));
    }

    /**
     * Yeni müşteri formu
     */
    public function create()
    {
        return view('customers.create');
    }

    /**
     * Müşteri kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'phone_secondary' => 'nullable|string|max:20',
            'id_number' => 'nullable|string|max:11',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:50',
            'district' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:10',
            'occupation' => 'nullable|string|max:255',
            'workplace' => 'nullable|string|max:255',
            'status' => 'required|in:active,potential,passive,lost',
            'notes' => 'nullable|string',
            'assigned_to' => 'nullable|exists:users,id',
        ], [
            'name.required' => 'Müşteri adı gereklidir.',
            'phone.required' => 'Telefon numarası gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'id_number.max' => 'TC Kimlik No en fazla 11 karakter olabilir.',
        ]);

        DB::beginTransaction();
        try {
            $notes = $validated['notes'] ?? null;
            unset($validated['notes']);

            $validated['created_by'] = auth()->id();
            $customer = Customer::create($validated);

            if ($notes) {
                CustomerNote::create([
                    'customer_id' => $customer->id,
                    'user_id' => auth()->id(),
                    'note_type' => 'note',
                    'note' => $notes,
                    'next_action_date' => null,
                ]);
            }

            DB::commit();

           return redirect()->route('customers.show', $customer)
            ->with('success', 'Müşteri başarıyla eklendi.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Customer store error', [
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return back()->withInput()
                ->with('error', 'Müşteri kaydedilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Müşteri detay
     */
    public function show(Customer $customer)
    {
        // ✅ CARİ İLİŞKİLERİ EKLE
        $customer->load([
            'policies.insuranceCompany',
            'policies.cariHareketler',  // ✅ YENİ: Poliçe cari hareketleri
            'quotations',
            'customerNotes.user',
            'customerCalls.user',
            'crossSellOpportunities',
            'documents.uploadedBy',
            'cariHesap.hareketler',  // ✅ YENİ: Cari hesap ve hareketler
        ]);

        return view('customers.show', compact('customer'));
    }

    /**
     * Müşteri düzenleme formu
     */
    public function edit(Customer $customer)
    {
        return view('customers.edit', compact('customer'));
    }

    /**
     * Müşteri güncelle
     */
    public function update(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'phone_secondary' => 'nullable|string|max:20',
            'id_number' => 'nullable|string|max:11',
            'birth_date' => 'nullable|date',
            'address' => 'nullable|string',
            'city' => 'nullable|string|max:50',
            'district' => 'nullable|string|max:50',
            'postal_code' => 'nullable|string|max:10',
            'occupation' => 'nullable|string|max:255',
            'workplace' => 'nullable|string|max:255',
            'status' => 'required|in:active,potential,passive,lost',
            'notes' => 'nullable|string',
        ]);

        DB::beginTransaction();
        try {
            $newNote = $validated['notes'] ?? null;
            unset($validated['notes']);

            $customer->update($validated);

            if ($newNote) {
                CustomerNote::create([
                    'customer_id' => $customer->id,
                    'user_id' => auth()->id(),
                    'note_type' => 'note',
                    'note' => "Müşteri bilgileri güncellendi:\n\n" . $newNote,
                ]);
            }

            DB::commit();

            return redirect()->route('customers.show', $customer)
                ->with('success', 'Müşteri bilgileri güncellendi.');

        } catch (\Exception $e) {
            DB::rollBack();

            Log::error('Customer update error', [
                'customer_id' => $customer->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            return back()->withInput()
                ->with('error', 'Güncelleme sırasında bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function destroy(Customer $customer)
    {
        // Poliçesi varsa silme
        if ($customer->policies()->exists()) {
            return back()->with('error', 'Bu müşterinin aktif poliçeleri olduğu için silinemez.');
        }

        // ✅ YENİ: Cari hesap kontrolü (bakiye 0 olmalı)
        if ($customer->cariHesap) {
            if ($customer->cariHesap->bakiye != 0) {
                return back()->with('error', 'Bu müşterinin cari hesabında ' .
                    number_format(abs($customer->cariHesap->bakiye), 2) .
                    '₺ bakiye olduğu için silinemez.');
            }

            // ✅ Bakiye 0 ise cari hesabı da sil
            $customer->cariHesap->delete();
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Müşteri ve ilgili cari hesap başarıyla silindi.');
    }

    /**
     * Müşteriye not ekle
     */
    public function addNote(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'note' => 'required|string|max:5000',
            'note_type' => 'nullable|in:note,call,meeting,email,sms',
            'next_action_date' => 'nullable|date',
        ], [
            'note.required' => 'Not içeriği boş olamaz.',
            'note.max' => 'Not en fazla 5000 karakter olabilir.',
        ]);

        try {
            $customerNote = CustomerNote::create([
                'customer_id' => $customer->id,
                'user_id' => auth()->id(),
                'note_type' => $validated['note_type'] ?? 'note',
                'note' => $validated['note'],
                'next_action_date' => $validated['next_action_date'] ?? null,
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Not başarıyla eklendi.',
                    'note' => [
                        'id' => $customerNote->id,
                        'note' => $customerNote->note,
                        'note_type' => $customerNote->note_type,
                        'note_type_label' => $customerNote->note_type_label,
                        'user_name' => auth()->user()->name,
                        'created_at' => $customerNote->created_at->diffForHumans(),
                        'created_at_formatted' => $customerNote->created_at->format('d.m.Y H:i'),
                    ]
                ]);
            }

            return back()->with('success', 'Not başarıyla eklendi.');

        } catch (\Exception $e) {
            Log::error('Customer note add error', [
                'customer_id' => $customer->id,
                'error' => $e->getMessage(),
                'user_id' => auth()->id(),
            ]);

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Not eklenirken bir hata oluştu: ' . $e->getMessage()
                ], 500);
            }

            return back()->with('error', 'Not eklenirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    public function storeDocument(Request $request, Customer $customer)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx,jpg,jpeg,png|max:5120',
            'description' => 'nullable|string',
        ]);

        if ($request->hasFile('file')) {
            $file = $request->file('file');

            $originalName = $file->getClientOriginalName();
            $mimeType = $file->getClientMimeType();
            $fileSize = $file->getSize();

            $fileName = time() . '_' . $originalName;
            $file->move(public_path('customer_files'), $fileName);

            $customer->documents()->create([
                'uploaded_by' => auth()->id(),
                'title' => $validated['title'],
                'file_name' => $originalName,
                'file_path' => $fileName,
                'file_type' => $mimeType,
                'file_size' => $fileSize,
                'description' => $validated['description'] ?? null,
            ]);
        }

        return back()->with('success', 'Belge başarıyla yüklendi.');
    }

    public function destroyDocument(Customer $customer, CustomerDocument $document)
    {
        if (file_exists(public_path('customer_files/' . $document->file_path))) {
            unlink(public_path('customer_files/' . $document->file_path));
        }

        $document->delete();

        return back()->with('success', 'Belge silindi.');
    }
}
