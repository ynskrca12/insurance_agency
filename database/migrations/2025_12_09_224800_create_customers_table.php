<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->string('name');
            $table->string('email')->nullable();
            $table->string('phone', 20);
            $table->string('phone_secondary', 20)->nullable();
            $table->string('id_number', 11)->nullable()->comment('TC Kimlik No');
            $table->date('birth_date')->nullable();

            $table->text('address')->nullable();
            $table->string('city', 50)->nullable();
            $table->string('district', 50)->nullable();
            $table->string('postal_code', 10)->nullable();

            $table->string('occupation')->nullable()->comment('Meslek');
            $table->string('workplace')->nullable()->comment('İş Yeri');

            $table->json('segments')->nullable()->comment('VIP, Potansiyel, Risk vb.');

            // İstatistikler (Cache için)
            $table->integer('total_policies')->default(0);
            $table->decimal('total_premium', 12, 2)->default(0);
            $table->decimal('lifetime_value', 12, 2)->default(0);
            $table->integer('risk_score')->default(0)->comment('0-100 arası');

            $table->timestamp('last_contact_date')->nullable();
            $table->date('next_contact_date')->nullable();

            // Durum
            $table->enum('status', [
                'active',      // Aktif müşteri
                'potential',   // Potansiyel
                'passive',     // Pasif
                'lost'         // Kayıp
            ])->default('active');

            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index('phone');
            $table->index('email');
            $table->index('id_number');
            $table->index('status');
            $table->index('next_contact_date');
            $table->index(['city', 'district']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
