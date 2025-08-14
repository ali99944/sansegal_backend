<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;
use App\Models\Product;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained()->onDelete('cascade');

            // Link to the original product. If product is deleted, link becomes null but the record remains.
            $table->foreignIdFor(Product::class)->nullable()->constrained()->onDelete('set null');

            // --- Product Details (Snapshot) ---
            $table->string('product_name');
            $table->string('product_image');
            $table->decimal('price', 10, 2); // The price at the time of purchase
            $table->integer('quantity');

            // Optional variant details
            $table->string('color')->nullable();
            $table->string('size')->nullable();

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
