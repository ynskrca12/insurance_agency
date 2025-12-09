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

            $table->string('title');
            $table->text('description')->nullable();

            $table->enum('task_type', [
                'call',
                'follow_up',
                'renewal',
                'quotation_prepare',
                'document_collect',
                'payment_collect',
                'other'
            ]);

            // Polymorphic İlişki
            $table->nullableMorphs('related');

            $table->foreignId('assigned_to_user_id')->nullable()->constrained('users')->nullOnDelete();

            $table->date('due_date');
            $table->time('due_time')->nullable();

            $table->enum('priority', [
                'low',
                'normal',
                'high',
                'urgent'
            ])->default('normal');

            $table->enum('status', [
                'pending',
                'in_progress',
                'completed',
                'cancelled'
            ])->default('pending');

            $table->timestamp('completed_at')->nullable();
            $table->text('result_notes')->nullable();

            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index('assigned_to_user_id');
            $table->index('due_date');
            $table->index('status');
            $table->index('priority');
            $table->index(['due_date', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('tasks');
    }
};
