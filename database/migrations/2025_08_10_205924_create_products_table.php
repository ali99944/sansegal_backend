<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('en_name');
            $table->string('ar_name');
            $table->text('en_description');
            $table->text('ar_description');
            $table->string('image'); // Main product image
            $table->decimal('original_price', 8, 2);
            $table->decimal('discount', 8, 2)->nullable();
            $table->enum('discount_type', ['percentage', 'fixed'])->nullable();
            $table->json('specifications'); // For key-value specs
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
