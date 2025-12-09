<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('policies', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('insurance_company_id')->constrained('insurance_companies')->restrictOnDelete();

            // Poliçe Bilgileri
            $table->string('policy_number')->unique();
            $table->enum('policy_type', [
                'kasko',
                'trafik',
                'konut',
                'dask',
                'saglik',
                'hayat',
                'tss'
            ]);

            // Araç Bilgileri (Kasko/Trafik için)
            $table->string('vehicle_plate', 20)->nullable();
            $table->string('vehicle_brand', 50)->nullable();
            $table->string('vehicle_model', 50)->nullable();
            $table->integer('vehicle_year')->nullable();
            $table->string('vehicle_chassis_no', 50)->nullable();

            // Konut Bilgileri (Konut/DASK için)
            $table->text('property_address')->nullable();
            $table->integer('property_area')->nullable()->comment('m2');
            $table->integer('property_floor')->nullable();

            $table->date('start_date');
            $table->date('end_date');

            $table->decimal('premium_amount', 12, 2);
            $table->decimal('commission_rate', 5, 2)->comment('Komisyon %');
            $table->decimal('commission_amount', 12, 2)->comment('Komisyon tutar');

            $table->enum('payment_type', ['cash', 'installment'])->default('cash');
            $table->integer('installment_count')->nullable();

            // Durum (Otomatik güncellenir)
            $table->enum('status', [
                'active',           // Aktif
                'expiring_soon',    // 30 gün
                'critical',         // 7 gün
                'expired',          // Bitti
                'renewed',          // Yenilendi
                'cancelled'         // İptal
            ])->default('active');

            // Yenileme İlişkisi
            $table->foreignId('renewed_from_policy_id')->nullable()
                  ->constrained('policies')->nullOnDelete();

            $table->foreignId('renewed_to_policy_id')->nullable()
                  ->constrained('policies')->nullOnDelete();

            $table->string('document_path')->nullable();

            $table->text('notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index('policy_number');
            $table->index('customer_id');
            $table->index('insurance_company_id');
            $table->index('policy_type');
            $table->index('status');
            $table->index('start_date');
            $table->index('end_date');
            $table->index(['end_date', 'status']);
            $table->index('vehicle_plate');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('policies');
    }
};
