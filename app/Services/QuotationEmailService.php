<?php

namespace App\Services;

use App\Models\Quotation;
use App\Models\QuotationEmail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\DB;

class QuotationEmailService
{
    /**
     * Teklif emaili gönder
     */
    public function sendQuotation(
        Quotation $quotation,
        string $recipientEmail,
        ?string $recipientName = null,
        ?string $customMessage = null
    ): array {
        DB::beginTransaction();
        try {
            // Email kaydı oluştur
            $emailLog = $quotation->emails()->create([
                'sent_by' => auth()->id(),
                'recipient_email' => $recipientEmail,
                'recipient_name' => $recipientName ?? $quotation->customer->name,
                'subject' => $this->getSubject($quotation),
                'body' => $customMessage ?? $this->getDefaultBody($quotation),
                'status' => 'pending',
            ]);

            // Email gönder
            Mail::send('emails.quotation', [
                'quotation' => $quotation,
                'customMessage' => $customMessage,
                'trackingToken' => $emailLog->tracking_token,
            ], function ($message) use ($quotation, $recipientEmail, $recipientName, $emailLog) {
                $message->to($recipientEmail, $recipientName ?? $quotation->customer->name)
                        ->subject($this->getSubject($quotation))
                        ->from(config('mail.from.address'), config('mail.from.name'));
            });

            // Email durumunu güncelle
            $emailLog->update([
                'status' => 'sent',
                'sent_at' => now(),
            ]);

            // Quotation güncelle
            $quotation->update([
                'status' => $quotation->status === 'draft' ? 'sent' : $quotation->status,
                'last_emailed_at' => now(),
            ]);
            $quotation->increment('email_sent_count');

            $quotation->logActivity('email_sent', "Email gönderildi: {$recipientEmail}");

            DB::commit();

            return [
                'success' => true,
                'message' => 'Email başarıyla gönderildi.',
                'email_id' => $emailLog->id,
            ];

        } catch (\Exception $e) {
            DB::rollBack();

            // Hata kaydı
            if (isset($emailLog)) {
                $emailLog->update([
                    'status' => 'failed',
                    'error_message' => $e->getMessage(),
                ]);
            }

            return [
                'success' => false,
                'message' => 'Email gönderilirken hata: ' . $e->getMessage(),
            ];
        }
    }

    /**
     * Email açıldığında track et
     */
    public function trackOpen(string $trackingToken): void
    {
        $email = QuotationEmail::where('tracking_token', $trackingToken)->first();

        if ($email) {
            $email->markAsOpened();
        }
    }

    /**
     * Link tıklandığında track et
     */
    public function trackClick(string $trackingToken): void
    {
        $email = QuotationEmail::where('tracking_token', $trackingToken)->first();

        if ($email) {
            $email->markAsClicked();
        }
    }

    /**
     * Email subject
     */
    private function getSubject(Quotation $quotation): string
    {
        return config('app.name') . ' - Sigorta Teklifiniz #' . $quotation->quotation_number;
    }

    /**
     * Varsayılan email body
     */
    private function getDefaultBody(Quotation $quotation): string
    {
        return "Sayın {$quotation->customer->name},\n\n" .
               "{$quotation->typeDisplay} sigortası için hazırladığımız teklifimiz ektedir.\n\n" .
               "Teklifimizi incelemek için aşağıdaki linki kullanabilirsiniz:\n" .
               "{$quotation->share_url}\n\n" .
               "Saygılarımızla,\n" .
               config('app.name');
    }
}
