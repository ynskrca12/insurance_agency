<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cari_hesaplar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            // Cari tipi: musteri, sirket, kasa, banka
            $table->enum('tip', ['musteri', 'sirket', 'kasa', 'banka']);

            $table->unsignedBigInteger('referans_id')->nullable();

            $table->string('kod')->unique();
            $table->string('ad');
            $table->text('aciklama')->nullable();

            $table->decimal('bakiye', 15, 2)->default(0); // Pozitif: Bizim alacağımız var- Negatif: Bizim borcumuz var

            // Limitler (müşteri için kredi limiti gibi)
            $table->decimal('kredi_limiti', 15, 2)->nullable();
            $table->integer('vade_gun')->default(0); // Standart vade günü

            $table->boolean('aktif')->default(true);

            $table->timestamps();
            $table->softDeletes();

            $table->index(['tip', 'referans_id']);
            $table->index('kod');
            $table->index('aktif');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cari_hesaplar');
    }
};
