@component('mail::message')
# Yeni İletişim Formu Mesajı

Sigorta Yönetim Sistemi iletişim formundan yeni bir mesaj aldınız.

## Gönderen Bilgileri

**Ad Soyad:** {{ $data['full_name'] }}
**E-posta:** {{ $data['email'] }}
**Telefon:** {{ $data['phone'] ?? 'Belirtilmedi' }}
**Konu:** {{ $data['subject'] ?? 'Genel Bilgi Talebi' }}
**IP Adresi:** {{ $data['ip_address'] }}
**Tarih:** {{ now()->format('d.m.Y H:i') }}

---

## Mesaj İçeriği

{{ $data['message'] }}

---

@component('mail::button', ['url' => 'mailto:' . $data['email']])
Yanıtla
@endcomponent

Bu mesaj otomatik olarak gönderilmiştir.

Teşekkürler,<br>
{{ config('app.name') }}
@endcomponent
