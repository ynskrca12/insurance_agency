<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('payment_reminders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('installment_id')->constrained('installments')->cascadeOnDelete();

            $table->datetime('reminder_date');
            $table->enum('channel', ['sms', 'email', 'whatsapp', 'phone'])->default('sms');

            $table->enum('status', ['pending', 'sent', 'failed'])->default('pending');
            $table->timestamp('sent_at')->nullable();
            $table->text('error_message')->nullable();

            $table->text('message_content');

            $table->timestamps();

            $table->index('customer_id');
            $table->index('installment_id');
            $table->index('reminder_date');
            $table->index('status');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('payment_reminders');
    }
};
