<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            // TEMEL BİLGİLER
            $table->string('title');
            $table->text('description')->nullable();
            $table->enum('category', ['call', 'meeting', 'follow_up', 'document', 'renewal', 'payment', 'quotation', 'other'])->default('other');
            $table->enum('priority', ['low', 'normal', 'high', 'urgent'])->default('normal');
            $table->enum('status', ['pending', 'in_progress', 'completed', 'cancelled'])->default('pending');

            // İLİŞKİLER
            $table->foreignId('assigned_to')->constrained('users')->cascadeOnDelete();
            $table->foreignId('assigned_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('customer_id')->nullable()->constrained('customers')->nullOnDelete();
            $table->foreignId('policy_id')->nullable()->constrained('policies')->nullOnDelete();

            // TARİHLER
            $table->datetime('due_date');
            $table->datetime('reminder_date')->nullable();
            $table->timestamp('completed_at')->nullable();

            // NOTLAR
            $table->text('notes')->nullable();

            $table->timestamps();

            // İNDEXLER
            $table->index('status');
            $table->index('priority');
            $table->index('category');
            $table->index('assigned_to');
            $table->index('due_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
