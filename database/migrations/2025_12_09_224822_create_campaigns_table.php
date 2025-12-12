<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('campaigns', function (Blueprint $table) {
            $table->id();

            // TEMEL BİLGİLER
            $table->string('name');
            $table->enum('type', ['sms', 'email', 'whatsapp'])->default('sms');
            $table->string('subject')->nullable();
            $table->text('message');

            // HEDEF KİTLE
            $table->enum('target_type', ['all', 'active_customers', 'policy_type', 'city', 'custom'])->default('all');
            $table->json('target_filter')->nullable();

            // DURUM
            $table->enum('status', ['draft', 'scheduled', 'sending', 'sent', 'failed'])->default('draft');

            // TARİHLER
            $table->timestamp('scheduled_at')->nullable();
            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            // İSTATİSTİKLER
            $table->integer('total_recipients')->default(0);
            $table->integer('sent_count')->default(0);
            $table->integer('failed_count')->default(0);

            // OLUŞTURAN
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();

            $table->timestamps();

            // İNDEXLER
            $table->index('status');
            $table->index('type');
            $table->index('scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
