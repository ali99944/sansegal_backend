<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void {
        Schema::create('promo_codes', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique();
            $table->enum('type', ['percentage', 'fixed'])->default('percentage');
            $table->decimal('value', 10, 2); // The discount value (e.g., 15 for 15% or 50 for 50 EGP)
            $table->unsignedInteger('max_uses')->nullable(); // Max uses for this code in total
            $table->unsignedInteger('uses')->default(0); // How many times this code has been used
            $table->timestamp('expires_at')->nullable(); // Expiration date
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('promo_codes');
    }
};
