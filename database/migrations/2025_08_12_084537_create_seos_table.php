<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seos', function (Blueprint $table) {
            $table->id();
            // The unique key for the page (e.g., 'home', 'contact', 'products.index')
            $table->string('key')->unique();

            // --- Standard SEO Meta Tags ---
            $table->string('title', 255);
            $table->string('description', 500);
            $table->string('keywords', 255)->nullable();
            $table->string('canonical_url')->nullable();

            // --- Open Graph (for Facebook, LinkedIn, etc.) ---
            $table->string('og_title', 255)->nullable();
            $table->string('og_description', 500)->nullable();
            $table->string('og_image')->nullable(); // URL to the image
            $table->string('og_type')->default('website'); // e.g., 'website', 'article', 'product'

            // --- Structured Data (JSON-LD) ---
            $table->json('structured_data')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seos');
    }
};
