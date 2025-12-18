<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('policy_renewals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('policy_id')->constrained('policies')->cascadeOnDelete();
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();

            $table->date('renewal_date'); // Poliçe bitiş tarihi

            $table->enum('priority', ['low', 'normal', 'high', 'critical'])->default('normal');

            $table->enum('status', [
                'pending',            // Bekliyor
                'contacted',          // Görüşüldü
                'quotation_sent',     // Teklif verildi
                'approved',           // Onaylandı
                'rejected',           // Reddedildi
                'lost_to_competitor', // Rakibe gitti
                'renewed',            // Yenilendi
                'lost'                // Kaybedildi
            ])->default('pending');

            $table->timestamp('contacted_at')->nullable();
            $table->foreignId('contacted_by')->nullable()->constrained('users')->nullOnDelete();
            $table->date('next_contact_date')->nullable();

            $table->text('contact_notes')->nullable();

            $table->text('notes')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->string('competitor_name')->nullable();

            $table->enum('lost_reason', ['price', 'service', 'competitor', 'customer_decision', 'other'])->nullable();

            $table->foreignId('new_policy_id')->nullable()
                  ->constrained('policies')->nullOnDelete();

            $table->timestamp('renewed_at')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index('policy_id');
            $table->index('customer_id');
            $table->index('renewal_date');
            $table->index('status');
            $table->index('priority');
            $table->index('next_contact_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('policy_renewals');
    }
};
