<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Mail\ContactFormMail;
use App\Models\ContactMessage;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        $stats = [
            'users' => 1000,
            'policies' => 50000,
            'uptime' => 99.9,
            'support' => 24,
        ];

        return view('web.home', compact('stats'));
    }

     public function sendContact(Request $request)
    {
        $validated = $request->validate([
            'full_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'nullable|string|max:255',
            'message' => 'required|string|max:5000',
        ], [
            'full_name.required' => 'Ad soyad alanı zorunludur.',
            'email.required' => 'E-posta alanı zorunludur.',
            'email.email' => 'Geçerli bir e-posta adresi giriniz.',
            'message.required' => 'Mesaj alanı zorunludur.',
            'message.max' => 'Mesaj en fazla 5000 karakter olabilir.',
        ]);

        // Veritabanına kaydet
        ContactMessage::create([
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'] ?? null,
            'subject' => $validated['subject'] ?? 'Genel Bilgi Talebi',
            'message' => $validated['message'],
            'ip_address' => $request->ip(),
        ]);

        // Mail gönder
        try {
            $mailData = [
                'full_name' => $validated['full_name'],
                'email' => $validated['email'],
                'phone' => $validated['phone'] ?? null,
                'subject' => $validated['subject'] ?? 'Genel Bilgi Talebi',
                'message' => $validated['message'],
                'ip_address' => $request->ip(),
            ];

            Mail::to('sigortaacenteyonetimsistemi@gmail.com')
                ->send(new ContactFormMail($mailData));

            return back()->with('success', 'Mesajınız başarıyla gönderildi. En kısa sürede size dönüş yapacağız.');
        } catch (\Exception $e) {
            // Mail gönderilemese bile veritabanına kaydedildi
            Log::error('Mail gönderme hatası: ' . $e->getMessage());

            return back()->with('success', 'Mesajınız alındı. En kısa sürede size dönüş yapacağız.');
        }
    }
}
