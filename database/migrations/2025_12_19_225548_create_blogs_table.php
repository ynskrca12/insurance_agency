<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();

            // Başlık ve İçerik
            $table->string('title');
            $table->string('slug')->unique();
            $table->text('excerpt')->nullable();
            $table->longText('content');

            // Görsel
            $table->string('featured_image')->nullable();
            $table->string('image_alt')->nullable();

            // SEO
            $table->string('meta_title')->nullable();
            $table->text('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // Etiketler
            $table->json('tags')->nullable();

            // Yayın Tarihi
            $table->timestamp('published_at')->nullable();

            // Öne Çıkan
            $table->boolean('is_featured')->default(false);

            // Sıralama
            $table->integer('order')->default(0);

            $table->timestamps();
            $table->softDeletes();

            // Indexes
            $table->index('slug');
            $table->index('published_at');
            $table->index('is_featured');
            $table->index('order');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};
