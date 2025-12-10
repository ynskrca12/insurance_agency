<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    /**
     * Müşteri listesi
     */
    public function index(Request $request)
    {
        $query = Customer::with('createdBy');

        // Arama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('phone', 'like', "%{$search}%")
                  ->orWhere('email', 'like', "%{$search}%")
                  ->orWhere('id_number', 'like', "%{$search}%");
            });
        }

        // Durum filtresi
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Şehir filtresi
        if ($request->filled('city')) {
            $query->where('city', $request->city);
        }

        // Sıralama
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        // Sayfalama
        $customers = $query->paginate(15)->withQueryString();

        // Şehirler (filtre için)
        $cities = Customer::distinct()->pluck('city')->filter()->sort()->values();

        return view('customers.index', compact('customers', 'cities'));
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
        ], [
            'name.required' => 'Müşteri adı gereklidir.',
            'phone.required' => 'Telefon numarası gereklidir.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'id_number.max' => 'TC Kimlik No en fazla 11 karakter olabilir.',
        ]);

        $validated['created_by'] = auth()->id();

        $customer = Customer::create($validated);

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Müşteri başarıyla eklendi.');
    }

    /**
     * Müşteri detay
     */
    public function show(Customer $customer)
    {
        $customer->load([
            'policies.insuranceCompany',
            'quotations',
            'customerNotes.user',
            'customerCalls.user',
            'crossSellOpportunities',
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

        $customer->update($validated);

        return redirect()->route('customers.show', $customer)
            ->with('success', 'Müşteri başarıyla güncellendi.');
    }

    /**
     * Müşteri sil
     */
    public function destroy(Customer $customer)
    {
        // Poliçesi varsa silme
        if ($customer->policies()->exists()) {
            return back()->with('error', 'Bu müşterinin aktif poliçeleri olduğu için silinemez.');
        }

        $customer->delete();

        return redirect()->route('customers.index')
            ->with('success', 'Müşteri başarıyla silindi.');
    }
}
