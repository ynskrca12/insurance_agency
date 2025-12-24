<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customer_notes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->integer('created_by')->nullable();
            $table->enum('note_type', [
                'note',
                'call',
                'meeting',
                'email',
                'sms'
            ])->default('note');

            $table->text('note');
            $table->date('next_action_date')->nullable();

            $table->timestamps();

            $table->index('customer_id');
            $table->index('user_id');
            $table->index('note_type');
            $table->index('created_at');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customer_notes');
    }
};
