<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('message_templates', function (Blueprint $table) {
            $table->id();

            $table->string('name')->comment('Şablon adı');
            $table->enum('type', ['sms', 'email', 'whatsapp']);

            // Email için
            $table->string('subject')->nullable();

            $table->text('content');

            $table->json('available_variables')->nullable();

            $table->enum('category', [
                'renewal',        // Yenileme
                'payment',        // Ödeme
                'welcome',        // Hoşgeldin
                'campaign',       // Kampanya
                'custom'          // Özel
            ])->default('custom');

            $table->boolean('is_active')->default(true);
            $table->boolean('is_default')->default(false);

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index('type');
            $table->index('category');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('message_templates');
    }
};
