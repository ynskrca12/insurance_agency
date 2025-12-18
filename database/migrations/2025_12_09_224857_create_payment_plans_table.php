<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('policy_id')->constrained('policies')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();

            $table->decimal('total_amount', 12, 2);
            $table->integer('installment_count')->default(1);

            $table->enum('payment_type', [
                'cash',
                'installment'
            ])->default('cash');

            $table->json('plan_details')->nullable();

            $table->timestamps();

            $table->index('policy_id');
            $table->index('customer_id');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_plans');
    }
};
