<?php

namespace App\Services;

use App\Models\Quotation;

class QuotationPdfService
{
    /**
     * PDF görünümü oluştur (browser print için)
     */
    public function generatePrintView(Quotation $quotation): string
    {
        $quotation->load(['customer', 'items.insuranceCompany', 'createdBy']);

        return view('quotations.print', [
            'quotation' => $quotation,
        ])->render();
    }

    /**
     * PDF kaydını veritabanına işle
     */
    public function markAsPrinted(Quotation $quotation): void
    {
        // Kullanıcı print yaptığında bu metod çağrılır
        $filename = 'quotations/' . $quotation->quotation_number . '_' . time() . '.pdf';

        $quotation->update([
            'pdf_path' => 'public/' . $filename,
            'pdf_generated_at' => now(),
        ]);

        $quotation->logActivity('pdf_generated', 'PDF oluşturuldu');
    }

    /**
     * Email için PDF attachment bilgisi
     */
    public function getPdfInfo(Quotation $quotation): array
    {
        return [
            'has_pdf' => $quotation->hasPdf(),
            'filename' => $quotation->quotation_number . '.pdf',
            'generated_at' => $quotation->pdf_generated_at,
        ];
    }
}
