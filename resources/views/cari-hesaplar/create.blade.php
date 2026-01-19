@extends('layouts.app')

@section('title', 'Yeni Kasa/Banka Hesabı')

@section('content')
<div class="container-fluid">
    {{-- Başlık --}}
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <a href="{{ route('cari-hesaplar.index', ['tip' => $tip]) }}" class="btn btn-outline-secondary btn-sm mb-2">
                        <i class="bi bi-arrow-left me-2"></i>Geri
                    </a>
                    <h2 class="mb-0">
                        <i class="bi bi-{{ $tip === 'kasa' ? 'safe' : 'bank' }} me-2"></i>
                        Yeni {{ $tip === 'kasa' ? 'Kasa' : 'Banka' }} Hesabı
                    </h2>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- Form Bölümü --}}
        <div class="col-lg-8">
            <div class="card">
                <div class="card-header {{ $tip === 'kasa' ? 'bg-warning' : 'bg-info' }} text-white">
                    <h5 class="mb-0">
                        <i class="bi bi-file-earmark-text me-2"></i>
                        Hesap Bilgileri
                    </h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('cari-hesaplar.store') }}" method="POST">
                        @csrf
                        <input type="hidden" name="tip" value="{{ $tip }}">

                        {{-- Tip Seçimi --}}
                        <div class="mb-4">
                            <label class="form-label">Hesap Tipi *</label>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <div class="card {{ $tip === 'kasa' ? 'border-warning' : '' }}"
                                         style="cursor: pointer;"
                                         onclick="window.location.href='{{ route('cari-hesaplar.create', ['tip' => 'kasa']) }}'">
                                        <div class="card-body text-center">
                                            <i class="bi bi-safe display-1 {{ $tip === 'kasa' ? 'text-warning' : 'text-muted' }}"></i>
                                            <h5 class="mt-3 mb-2">Kasa</h5>
                                            <p class="text-muted small mb-0">Nakit tahsilatlar için fiziksel kasa</p>
                                            @if($tip === 'kasa')
                                                <div class="mt-2">
                                                    <span class="badge bg-warning">Seçili</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="card {{ $tip === 'banka' ? 'border-info' : '' }}"
                                         style="cursor: pointer;"
                                         onclick="window.location.href='{{ route('cari-hesaplar.create', ['tip' => 'banka']) }}'">
                                        <div class="card-body text-center">
                                            <i class="bi bi-bank display-1 {{ $tip === 'banka' ? 'text-info' : 'text-muted' }}"></i>
                                            <h5 class="mt-3 mb-2">Banka Hesabı</h5>
                                            <p class="text-muted small mb-0">Banka havalesi ve EFT işlemleri için</p>
                                            @if($tip === 'banka')
                                                <div class="mt-2">
                                                    <span class="badge bg-info">Seçili</span>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <hr class="my-4">

                        {{-- Hesap Adı --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-tag me-2"></i>
                                Hesap Adı *
                            </label>
                            <input type="text"
                                   name="ad"
                                   class="form-control form-control-lg @error('ad') is-invalid @enderror"
                                   placeholder="{{ $tip === 'kasa' ? 'Örn: Ana Kasa, Şube Kasası' : 'Örn: Garanti Bankası, İş Bankası Hesabı' }}"
                                   value="{{ old('ad') }}"
                                   required>
                            @error('ad')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                Hesabı kolayca tanımlayabileceğiniz bir isim verin
                            </small>
                        </div>

                        {{-- Banka Özel Alanları --}}
                        @if($tip === 'banka')
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-building me-2"></i>
                                        Banka Adı
                                    </label>
                                    <select class="form-select" id="bankaSelect">
                                        <option value="">Banka seçiniz...</option>
                                        <option value="Akbank">Akbank</option>
                                        <option value="Garanti BBVA">Garanti BBVA</option>
                                        <option value="İş Bankası">İş Bankası</option>
                                        <option value="Yapı Kredi">Yapı Kredi</option>
                                        <option value="Ziraat Bankası">Ziraat Bankası</option>
                                        <option value="Halkbank">Halkbank</option>
                                        <option value="QNB Finansbank">QNB Finansbank</option>
                                        <option value="TEB">TEB</option>
                                        <option value="Denizbank">Denizbank</option>
                                        <option value="Vakıfbank">Vakıfbank</option>
                                        <option value="diger">Diğer...</option>
                                    </select>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label class="form-label">
                                        <i class="bi bi-credit-card me-2"></i>
                                        IBAN / Hesap No
                                    </label>
                                    <input type="text"
                                           class="form-control"
                                           placeholder="TR00 0000 0000 0000 0000 0000 00">
                                    <small class="text-muted">Opsiyonel - Hatırlatma için</small>
                                </div>
                            </div>
                        @endif

                        {{-- Açıklama --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-chat-left-text me-2"></i>
                                Açıklama
                            </label>
                            <textarea name="aciklama"
                                      class="form-control @error('aciklama') is-invalid @enderror"
                                      rows="3"
                                      placeholder="Hesap hakkında notlar, kullanım amacı vb.">{{ old('aciklama') }}</textarea>
                            @error('aciklama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        {{-- Başlangıç Bakiyesi --}}
                        <div class="mb-3">
                            <label class="form-label">
                                <i class="bi bi-wallet2 me-2"></i>
                                Başlangıç Bakiyesi (₺)
                            </label>
                            <input type="number"
                                   name="bakiye"
                                   step="0.01"
                                   class="form-control @error('bakiye') is-invalid @enderror"
                                   placeholder="0.00"
                                   value="{{ old('bakiye', 0) }}">
                            @error('bakiye')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">
                                <i class="bi bi-info-circle me-1"></i>
                                Hesabın mevcut bakiyesini girin. Sonradan düzeltilebilir.
                            </small>
                        </div>

                        {{-- Bilgilendirme --}}
                        <div class="alert alert-info">
                            <i class="bi bi-lightbulb me-2"></i>
                            <strong>Bilgi:</strong>
                            <ul class="mb-0 mt-2">
                                <li>Hesap kodu otomatik olarak oluşturulacak</li>
                                <li>Bu hesap {{ $tip === 'kasa' ? 'nakit' : 'banka havalesi/EFT' }} işlemlerinde kullanılabilir</li>
                                <li>Tüm tahsilat ve ödeme işlemlerinde bu hesabı seçebilirsiniz</li>
                                <li>Hesap bakiyesi otomatik olarak güncellenecek</li>
                            </ul>
                        </div>

                        {{-- Butonlar --}}
                        <div class="d-flex justify-content-between">
                            <a href="{{ route('cari-hesaplar.index', ['tip' => $tip]) }}" class="btn btn-secondary">
                                <i class="bi bi-x-circle me-2"></i>İptal
                            </a>
                            <button type="submit" class="btn btn-{{ $tip === 'kasa' ? 'warning' : 'info' }} btn-lg">
                                <i class="bi bi-check-circle me-2"></i>Hesabı Oluştur
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        {{-- Bilgi Paneli --}}
        <div class="col-lg-4">
            {{-- Örnek Hesaplar --}}
            <div class="card mb-3 border-{{ $tip === 'kasa' ? 'warning' : 'info' }}">
                <div class="card-header bg-{{ $tip === 'kasa' ? 'warning' : 'info' }} text-white">
                    <h6 class="mb-0">
                        <i class="bi bi-lightbulb me-2"></i>
                        Örnek {{ $tip === 'kasa' ? 'Kasa' : 'Banka' }} Hesapları
                    </h6>
                </div>
                <div class="card-body">
                    @if($tip === 'kasa')
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Ana Kasa</strong>
                                <br>
                                <small class="text-muted">Günlük nakit tahsilatlar</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Şube Kasası</strong>
                                <br>
                                <small class="text-muted">Şube özel kasa</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>POS Kasası</strong>
                                <br>
                                <small class="text-muted">Kredi kartı tahsilatları</small>
                            </li>
                        </ul>
                    @else
                        <ul class="list-unstyled mb-0">
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>İş Bankası - Ana Hesap</strong>
                                <br>
                                <small class="text-muted">Ana banka hesabı</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Garanti BBVA - POS Hesabı</strong>
                                <br>
                                <small class="text-muted">Sanal POS tahsilatları</small>
                            </li>
                            <li class="mb-2">
                                <i class="bi bi-check-circle text-success me-2"></i>
                                <strong>Ziraat Bankası - Şirket Ödemeleri</strong>
                                <br>
                                <small class="text-muted">Sigorta şirketi ödemeleri için</small>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>

            {{-- Kullanım Alanları --}}
            <div class="card">
                <div class="card-header">
                    <h6 class="mb-0">
                        <i class="bi bi-question-circle me-2"></i>
                        Nasıl Kullanılır?
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        @if($tip === 'kasa')
                            <p class="mb-2"><strong>Kasa hesapları şunlar için kullanılır:</strong></p>
                            <ul class="mb-0">
                                <li>Nakit müşteri tahsilatları</li>
                                <li>Günlük kasa sayımı</li>
                                <li>Nakit giriş/çıkış takibi</li>
                                <li>POS ve kredi kartı tahsilatları</li>
                            </ul>
                        @else
                            <p class="mb-2"><strong>Banka hesapları şunlar için kullanılır:</strong></p>
                            <ul class="mb-0">
                                <li>Banka havalesi tahsilatları</li>
                                <li>EFT işlemleri</li>
                                <li>Sigorta şirketlerine ödemeler</li>
                                <li>Sanal POS tahsilatları</li>
                            </ul>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    // Banka seçildiğinde hesap adını otomatik doldur
    document.getElementById('bankaSelect')?.addEventListener('change', function() {
        const adInput = document.querySelector('input[name="ad"]');
        if (this.value && this.value !== 'diger' && !adInput.value) {
            adInput.value = this.value + ' Hesabı';
        }
    });
</script>
@endpush
@endsection
