<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Product;

return new class extends Migration {
    public function up(): void {
        Schema::create('product_specifications', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Product::class)->constrained()->onDelete('cascade');
            $table->string('spec_key'); // The name of the spec, e.g., "Material"
            $table->string('spec_value'); // The value of the spec, e.g., "Full-grain Leather"
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('product_specifications');
    }
};
