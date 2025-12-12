<?php

namespace App\Http\Controllers;

use App\Models\Campaign;
use App\Models\CampaignRecipient;
use App\Models\MessageTemplate;
use App\Models\Customer;
use App\Models\Policy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CampaignController extends Controller
{
    /**
     * Kampanya listesi
     */
    public function index(Request $request)
    {
        $query = Campaign::with(['createdBy']);

        // Arama
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%");
            });
        }

        // Durum filtresi
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        // Tip filtresi
        if ($request->filled('type')) {
            $query->where('type', $request->type);
        }

        // Sıralama
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

        $campaigns = $query->paginate(20)->withQueryString();

        // İstatistikler
        $stats = [
            'total' => Campaign::count(),
            'draft' => Campaign::where('status', 'draft')->count(),
            'scheduled' => Campaign::where('status', 'scheduled')->count(),
            'sent' => Campaign::where('status', 'sent')->count(),
            'total_recipients' => CampaignRecipient::count(),
        ];

        return view('campaigns.index', compact('campaigns', 'stats'));
    }

    /**
     * Yeni kampanya formu
     */
    public function create()
    {
        $templates = MessageTemplate::where('is_active', true)->get();

        return view('campaigns.create', compact('templates'));
    }

    /**
     * Kampanya kaydet
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:sms,email,whatsapp',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string',
            'target_type' => 'required|in:all,active_customers,policy_type,city,custom',
            'target_filter' => 'nullable|array',
            'scheduled_at' => 'nullable|date|after:now',
            'send_now' => 'nullable|boolean',
        ]);

        DB::beginTransaction();
        try {
            // Kampanya oluştur
            $campaign = Campaign::create([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'subject' => $validated['subject'] ?? null,
                'message' => $validated['message'],
                'target_type' => $validated['target_type'],
                'target_filter' => $validated['target_filter'] ?? null,
                'status' => $request->boolean('send_now') ? 'sending' : ($validated['scheduled_at'] ? 'scheduled' : 'draft'),
                'scheduled_at' => $validated['scheduled_at'] ?? null,
                'created_by' => auth()->id(),
            ]);

            // Hedef kitleyi belirle
            $recipients = $this->getTargetRecipients($validated['target_type'], $validated['target_filter'] ?? []);

            // Alıcıları kaydet
            foreach ($recipients as $recipient) {
                CampaignRecipient::create([
                    'campaign_id' => $campaign->id,
                    'customer_id' => $recipient['customer_id'],
                    'contact_type' => $validated['type'],
                    'contact_value' => $recipient['contact_value'],
                    'status' => 'pending',
                ]);
            }

            // Toplam alıcı sayısını güncelle
            $campaign->update([
                'total_recipients' => count($recipients),
            ]);

            // Hemen gönder seçilmişse
            if ($request->boolean('send_now')) {
                $this->sendCampaign($campaign);
            }

            DB::commit();

            return redirect()->route('campaigns.show', $campaign)
                ->with('success', 'Kampanya başarıyla oluşturuldu.');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->withInput()
                ->with('error', 'Kampanya oluşturulurken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Kampanya detay
     */
    public function show(Campaign $campaign)
    {
        $campaign->load([
            'createdBy',
            'recipients.customer',
        ]);

        $recipientStats = [
            'total' => $campaign->recipients->count(),
            'sent' => $campaign->recipients->where('status', 'sent')->count(),
            'delivered' => $campaign->recipients->where('status', 'delivered')->count(),
            'failed' => $campaign->recipients->where('status', 'failed')->count(),
            'pending' => $campaign->recipients->where('status', 'pending')->count(),
        ];

        return view('campaigns.show', compact('campaign', 'recipientStats'));
    }

    /**
     * Kampanya sil
     */
    public function destroy(Campaign $campaign)
    {
        if ($campaign->status === 'sent') {
            return back()->with('error', 'Gönderilmiş kampanyalar silinemez.');
        }

        try {
            $campaign->delete();

            return redirect()->route('campaigns.index')
                ->with('success', 'Kampanya başarıyla silindi.');

        } catch (\Exception $e) {
            return back()->with('error', 'Kampanya silinirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Kampanyayı gönder
     */
    public function send(Campaign $campaign)
    {
        if (!in_array($campaign->status, ['draft', 'scheduled'])) {
            return back()->with('error', 'Bu kampanya zaten gönderilmiş veya gönderiliyor.');
        }

        try {
            $this->sendCampaign($campaign);

            return back()->with('success', 'Kampanya gönderilmeye başlandı.');

        } catch (\Exception $e) {
            return back()->with('error', 'Kampanya gönderilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Kampanya durumunu test et
     */
    public function test(Request $request, Campaign $campaign)
    {
        $validated = $request->validate([
            'test_contact' => 'required|string',
        ]);

        try {
            // Test mesajı gönderimi
            // SMS/Email/WhatsApp servisi entegre edildiğinde burası doldurulacak

            return back()->with('success', 'Test mesajı gönderildi: ' . $validated['test_contact']);

        } catch (\Exception $e) {
            return back()->with('error', 'Test mesajı gönderilirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Mesaj şablonları
     */
    public function templates()
    {
        $templates = MessageTemplate::orderBy('created_at', 'desc')->paginate(20);

        return view('campaigns.templates', compact('templates'));
    }

    /**
     * Şablon kaydet
     */
    public function storeTemplate(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:sms,email,whatsapp',
            'subject' => 'nullable|string|max:255',
            'content' => 'required|string',
            'variables' => 'nullable|array',
            'is_active' => 'nullable|boolean',
        ]);

        try {
            MessageTemplate::create([
                'name' => $validated['name'],
                'type' => $validated['type'],
                'subject' => $validated['subject'] ?? null,
                'content' => $validated['content'],
                'variables' => $validated['variables'] ?? [],
                'is_active' => $request->boolean('is_active', true),
                'created_by' => auth()->id(),
            ]);

            return back()->with('success', 'Şablon başarıyla oluşturuldu.');

        } catch (\Exception $e) {
            return back()->withInput()
                ->with('error', 'Şablon oluşturulurken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Şablon sil
     */
    public function destroyTemplate(MessageTemplate $template)
    {
        try {
            $template->delete();

            return back()->with('success', 'Şablon başarıyla silindi.');

        } catch (\Exception $e) {
            return back()->with('error', 'Şablon silinirken bir hata oluştu: ' . $e->getMessage());
        }
    }

    /**
     * Hedef kitleyi getir
     */
    private function getTargetRecipients($targetType, $targetFilter)
    {
        $recipients = [];
        $query = Customer::where('status', 'active');

        switch ($targetType) {
            case 'all':
                // Tüm aktif müşteriler
                break;

            case 'active_customers':
                // Aktif poliçesi olan müşteriler
                $query->has('policies');
                break;

            case 'policy_type':
                // Belirli poliçe türüne sahip müşteriler
                if (isset($targetFilter['policy_type'])) {
                    $query->whereHas('policies', function($q) use ($targetFilter) {
                        $q->where('policy_type', $targetFilter['policy_type']);
                    });
                }
                break;

            case 'city':
                // Belirli şehirdeki müşteriler
                if (isset($targetFilter['city'])) {
                    $query->where('city', $targetFilter['city']);
                }
                break;

            case 'custom':
                // Özel filtreler
                if (isset($targetFilter['customer_ids'])) {
                    $query->whereIn('id', $targetFilter['customer_ids']);
                }
                break;
        }

        $customers = $query->get();

        foreach ($customers as $customer) {
            $recipients[] = [
                'customer_id' => $customer->id,
                'contact_value' => $customer->phone, // veya email
            ];
        }

        return $recipients;
    }

    /**
     * Kampanyayı gönder
     */
    private function sendCampaign(Campaign $campaign)
    {
        DB::beginTransaction();
        try {
            $campaign->update([
                'status' => 'sending',
                'started_at' => now(),
            ]);

            $recipients = $campaign->recipients()->where('status', 'pending')->get();

            foreach ($recipients as $recipient) {
                try {
                    // TODO: Gerçek SMS/Email/WhatsApp gönderimi
                    // Servis entegre edildiğinde burası doldurulacak

                    // Şimdilik gönderildi olarak işaretle
                    $recipient->update([
                        'status' => 'sent',
                        'sent_at' => now(),
                    ]);

                } catch (\Exception $e) {
                    $recipient->update([
                        'status' => 'failed',
                        'error_message' => $e->getMessage(),
                    ]);
                }
            }

            // İstatistikleri güncelle
            $campaign->update([
                'status' => 'sent',
                'completed_at' => now(),
                'sent_count' => $campaign->recipients()->where('status', 'sent')->count(),
                'failed_count' => $campaign->recipients()->where('status', 'failed')->count(),
            ]);

            DB::commit();

        } catch (\Exception $e) {
            DB::rollBack();
            $campaign->update(['status' => 'failed']);
            throw $e;
        }
    }

    /**
     * Hedef kitle önizleme (AJAX)
     */
    public function previewRecipients(Request $request)
    {
        $targetType = $request->get('target_type');
        $targetFilter = $request->get('target_filter', []);

        $recipients = $this->getTargetRecipients($targetType, $targetFilter);

        return response()->json([
            'count' => count($recipients),
            'recipients' => array_slice($recipients, 0, 10), // İlk 10 kişi
        ]);
    }
}
