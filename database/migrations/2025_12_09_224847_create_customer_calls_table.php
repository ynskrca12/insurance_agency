<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_calls', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('created_by')->nullable();
            $table->timestamp('called_at');
            $table->integer('duration')->nullable()->comment('Süre (saniye)');

            $table->enum('outcome', [
                'answered',
                'no_answer',
                'busy',
                'wrong_number',
                'call_back'
            ]);

            $table->text('notes')->nullable();
            $table->date('next_call_date')->nullable();

            $table->timestamps();

            $table->index('customer_id');
            $table->index('user_id');
            $table->index('called_at');
            $table->index('next_call_date');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_calls');
    }
};
