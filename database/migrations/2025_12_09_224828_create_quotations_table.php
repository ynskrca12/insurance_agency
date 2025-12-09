<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotations', function (Blueprint $table) {
            $table->id();

            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();

            $table->string('quotation_number')->unique();
            $table->enum('quotation_type', [
                'kasko',
                'trafik',
                'konut',
                'dask',
                'saglik',
                'hayat',
                'tss'
            ]);

            // Araç Bilgileri (Kasko/Trafik)
            $table->json('vehicle_info')->nullable();

            // Konut Bilgileri (Konut/DASK)
            $table->json('property_info')->nullable();

            // Teminat Detayları
            $table->json('coverage_details')->nullable();

            // Geçerlilik
            $table->date('valid_until');

            $table->enum('status', [
                'draft',
                'sent',
                'viewed',
                'approved',
                'rejected',
                'converted',
                'expired'
            ])->default('draft');

            // Paylaşım
            $table->string('shared_link_token')->nullable()->unique();
            $table->integer('view_count')->default(0);

            // Müşteri Yanıtı
            $table->text('customer_response')->nullable();
            $table->foreignId('selected_company_id')->nullable()
                  ->constrained('insurance_companies')->nullOnDelete();

            // Dönüşüm
            $table->foreignId('converted_policy_id')->nullable()
                  ->constrained('policies')->nullOnDelete();

            $table->timestamp('converted_at')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();

            $table->index('customer_id');
            $table->index('quotation_number');
            $table->index('quotation_type');
            $table->index('status');
            $table->index('valid_until');
            $table->index('shared_link_token');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotations');
    }
};
