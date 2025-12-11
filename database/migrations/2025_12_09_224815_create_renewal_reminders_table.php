<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('renewal_reminders', function (Blueprint $table) {
            $table->id();

            $table->foreignId('policy_id')->constrained('policies')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('policy_renewal_id')->nullable()->constrained('policy_renewals')->cascadeOnDelete();

            // Hatırlatma Tipi
            $table->enum('reminder_type', [
                '30_days',
                '15_days',
                '7_days',
                '1_day'
            ]);

            $table->date('reminder_date');
            $table->enum('channel', ['sms', 'email', 'whatsapp'])->default('sms');

            $table->enum('status', [
                'pending',
                'sent',
                'failed',
                'cancelled'
            ])->default('pending');

            $table->text('message_content');
            $table->timestamp('sent_at')->nullable();

            $table->text('error_message')->nullable();
            $table->integer('retry_count')->default(0);

            $table->timestamps();

            $table->index('policy_id');
            $table->index('customer_id');
            $table->index('reminder_date');
            $table->index('status');
            $table->index(['reminder_date', 'status']);
            $table->unique(['policy_id', 'reminder_type']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('renewal_reminders');
    }
};
