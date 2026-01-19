<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('sirket_odemeleri', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');

            // Sigorta şirketi carisi
            $table->foreignId('sirket_cari_id')->constrained('cari_hesaplar')->onDelete('cascade');

            $table->decimal('tutar', 15, 2);
            $table->date('odeme_tarihi');

            $table->enum('odeme_yontemi', [
                'nakit',
                'kredi_kart',
                'banka_havale',
                'cek',
                'sanal_pos',
                'diger'
            ]);

            // Hangi kasadan/bankadan çıktı
            $table->foreignId('kasa_banka_id')->nullable()->constrained('cari_hesaplar');

            $table->string('dekont_no')->nullable();
            $table->text('aciklama')->nullable();

            // Hangi poliçelere karşılık (opsiyonel - toplu ödeme olabilir)
            $table->json('policy_ids')->nullable(); // [1,2,3,4]

            $table->foreignId('created_by')->constrained('users');

            $table->timestamps();
            $table->softDeletes();

            $table->index('sirket_cari_id');
            $table->index('odeme_tarihi');
            $table->index('dekont_no');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('sirket_odemeleri');
    }
};
