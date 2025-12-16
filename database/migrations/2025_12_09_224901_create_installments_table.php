<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('installments', function (Blueprint $table) {
            $table->id();

            $table->foreignId('payment_plan_id')->constrained('payment_plans')->cascadeOnDelete();

            $table->integer('installment_number');
            $table->decimal('amount', 12, 2);
            $table->date('due_date');

            $table->date('paid_date')->nullable();
            $table->enum('payment_method', [
                'cash',
                'credit_card',
                'transfer',
                'check',
                'bank_transfer',
                'pos'
            ])->nullable();

            $table->string('receipt_number')->nullable();

            $table->enum('status', [
                'pending',
                'paid',
                'overdue',
                'partial'
            ])->default('pending');

            $table->text('notes')->nullable();

            $table->timestamps();

            $table->index('payment_plan_id');
            $table->index('due_date');
            $table->index('status');
            $table->index(['payment_plan_id', 'installment_number']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('installments');
    }
};
