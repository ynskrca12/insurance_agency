<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('quotation_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('quotation_id')->constrained('quotations')->cascadeOnDelete();
            $table->foreignId('insurance_company_id')->constrained('insurance_companies')->restrictOnDelete();

            $table->decimal('premium_amount', 12, 2);
            $table->text('coverage_summary')->nullable();

            $table->boolean('is_recommended')->default(false);
            $table->integer('rank')->default(0);

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('quotation_id');
            $table->index('insurance_company_id');
            $table->index(['quotation_id', 'rank']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('quotation_items');
    }
};
