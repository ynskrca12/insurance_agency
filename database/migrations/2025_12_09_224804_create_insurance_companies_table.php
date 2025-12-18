<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('insurance_companies', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->string('name')->unique();
            $table->string('code', 10)->unique()->comment('AXA, ALC, HDI');
            $table->string('logo')->nullable();

            $table->string('phone', 20)->nullable();
            $table->string('email')->nullable();
            $table->string('website')->nullable();

            // Varsayılan Komisyon Oranları (%)
            $table->decimal('default_commission_kasko', 5, 2)->default(20.00);
            $table->decimal('default_commission_trafik', 5, 2)->default(15.00);
            $table->decimal('default_commission_konut', 5, 2)->default(18.00);
            $table->decimal('default_commission_dask', 5, 2)->default(18.00);
            $table->decimal('default_commission_saglik', 5, 2)->default(12.00);
            $table->decimal('default_commission_hayat', 5, 2)->default(25.00);
            $table->decimal('default_commission_tss', 5, 2)->default(15.00);

            $table->boolean('is_active')->default(true);
            $table->integer('display_order')->default(0);

            $table->timestamps();

            $table->index('code');
            $table->index('is_active');
            $table->index('display_order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('insurance_companies');
    }
};
