<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cross_sell_opportunities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('tenant_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('customer_id')->constrained('customers')->cascadeOnDelete();
            $table->integer('created_by')->nullable();
            $table->enum('suggested_product', [
                'kasko',
                'trafik',
                'konut',
                'dask',
                'saglik',
                'hayat',
                'tss'
            ]);

            $table->text('reason');

            $table->enum('status', [
                'pending',
                'contacted',
                'converted',
                'rejected',
                'ignored'
            ])->default('pending');

            $table->integer('priority')->default(0);

            $table->timestamp('contacted_at')->nullable();
            $table->foreignId('contacted_by')->nullable()->constrained('users')->nullOnDelete();

            $table->timestamps();

            $table->index('customer_id');
            $table->index('status');
            $table->index(['customer_id', 'suggested_product']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cross_sell_opportunities');
    }
};
