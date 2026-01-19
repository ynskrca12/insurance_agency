<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cari_hareketler', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('cari_hesap_id')->constrained('cari_hesaplar')->onDelete('cascade');

            $table->enum('islem_tipi', ['borc', 'alacak']);

            $table->decimal('tutar', 15, 2);

            $table->text('aciklama')->nullable();

            $table->string('referans_tip')->nullable(); // policy, tahsilat, odeme, iptal, komisyon
            $table->unsignedBigInteger('referans_id')->nullable();

            $table->enum('odeme_yontemi', [
                'nakit',
                'kredi_kart',
                'banka_havale',
                'cek',
                'sanal_pos',
                'diger'
            ])->nullable();

            $table->date('vade_tarihi')->nullable();
            $table->date('islem_tarihi');

            $table->string('belge_no')->nullable();
            $table->string('belge_tip')->nullable(); // makbuz, fatura, dekont

            // Kasa/Banka hareketi ise karşı hesap
            $table->foreignId('karsi_cari_hesap_id')->nullable()->constrained('cari_hesaplar');

            $table->foreignId('created_by')->constrained('users');

            $table->timestamps();
            $table->softDeletes();

            $table->index('cari_hesap_id');
            $table->index('islem_tarihi');
            $table->index(['referans_tip', 'referans_id']);
            $table->index('vade_tarihi');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cari_hareketler');
    }
};
