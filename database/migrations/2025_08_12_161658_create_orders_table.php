<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Customer; // If you have a Customer model

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            // Use your own Customer model if it exists, otherwise this can be omitted
            // $table->foreignIdFor(Customer::class)->nullable()->constrained()->onDelete('set null');

            $table->string('order_code')->unique(); // The user-facing code like "SG123456ABC"
            $table->string('status')->default('pending'); // Ex: pending, processing, shipped, delivered, cancelled

            // --- Customer Information (Snapshot) ---
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');
            $table->string('secondary_phone')->nullable();
            $table->string('address');
            $table->string('secondary_address')->nullable();
            $table->string('city');
            $table->text('special_mark')->nullable();

            // --- Financials (Snapshot) ---
            $table->decimal('subtotal', 10, 2);
            $table->decimal('shipping_cost', 10, 2);
            $table->decimal('tax_amount', 10, 2);
            $table->string('promo_code')->nullable();
            $table->decimal('promo_discount', 10, 2)->default(0);
            $table->decimal('grand_total', 10, 2);

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
