<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('demo_users', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('full_name');
            $table->string('email')->unique();
            $table->string('phone', 20);
            $table->string('city', 100)->nullable();
            $table->text('message')->nullable();
            $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
            $table->dateTime('trial_ends_at');
            $table->boolean('is_converted')->default(false);
            $table->string('ip_address', 45)->nullable();
            $table->timestamps();

            $table->index('trial_ends_at');
            $table->index('is_converted');
        });
    }

    public function down()
    {
        Schema::dropIfExists('demo_users');
    }
};
