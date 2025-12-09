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

            $table->string('name');
            $table->text('description')->nullable();

            $table->enum('type', ['sms', 'email', 'whatsapp']);
            $table->foreignId('template_id')->nullable()->constrained('message_templates')->nullOnDelete();

            $table->json('target_filter')->nullable();

            $table->timestamp('scheduled_at')->nullable();
            $table->enum('status', [
                'draft',
                'scheduled',
                'sending',
                'completed',
                'failed',
                'cancelled'
            ])->default('draft');

            $table->integer('target_count')->default(0);
            $table->integer('sent_count')->default(0);
            $table->integer('success_count')->default(0);
            $table->integer('fail_count')->default(0);

            $table->timestamp('started_at')->nullable();
            $table->timestamp('completed_at')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index('status');
            $table->index('scheduled_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('campaigns');
    }
};
