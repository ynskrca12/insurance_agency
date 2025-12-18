<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            // İLİŞKİLER
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('policy_id')->nullable()->constrained('policies')->nullOnDelete();
            $table->foreignId('payment_plan_id')->nullable()->constrained('payment_plans')->nullOnDelete();
            $table->foreignId('installment_id')->nullable()->constrained('installments')->nullOnDelete();

            // ÖDEME BİLGİLERİ
            $table->decimal('amount', 10, 2);
            $table->datetime('payment_date');
            $table->enum('payment_method', ['cash', 'credit_card', 'bank_transfer', 'check', 'pos'])->default('cash');
            $table->string('payment_reference', 100)->nullable();

            // DURUM - ✅ BU KOLON EKLENMELİ
            $table->enum('status', ['completed', 'pending', 'failed', 'cancelled'])->default('completed');

            // NOTLAR
            $table->text('notes')->nullable();

            // İPTAL BİLGİLERİ
            $table->timestamp('cancelled_at')->nullable();
            $table->foreignId('cancelled_by')->nullable()->constrained('users')->nullOnDelete();

            // KİM OLUŞTURDU
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            // İNDEXLER
            $table->index('customer_id');
            $table->index('policy_id');
            $table->index('payment_plan_id');
            $table->index('installment_id');
            $table->index('payment_date');
            $table->index('status'); // ✅ INDEX EKLE
            $table->index('payment_method');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
