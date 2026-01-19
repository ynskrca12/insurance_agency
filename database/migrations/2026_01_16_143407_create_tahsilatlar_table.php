<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tahsilatlar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');

            // Müşteri carisi
            $table->foreignId('musteri_cari_id')->constrained('cari_hesaplar')->onDelete('cascade');

            $table->decimal('tutar', 15, 2);
            $table->date('tahsilat_tarihi');

            $table->enum('odeme_yontemi', [
                'nakit',
                'kredi_kart',
                'banka_havale',
                'cek',
                'sanal_pos',
                'diger'
            ]);

            // Hangi kasaya/bankaya geldi
            $table->foreignId('kasa_banka_id')->nullable()->constrained('cari_hesaplar');

            $table->string('makbuz_no')->nullable();
            $table->text('aciklama')->nullable();

            // Hangi poliçelere karşılık (opsiyonel)
            $table->foreignId('policy_id')->nullable()->constrained('policies');

            $table->foreignId('created_by')->constrained('users');

            $table->timestamps();
            $table->softDeletes();

            $table->index('musteri_cari_id');
            $table->index('tahsilat_tarihi');
            $table->index('makbuz_no');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tahsilatlar');
    }
};
