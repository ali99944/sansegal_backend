<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Models\Order;

return new class extends Migration {
    public function up(): void {
        Schema::create('order_trackings', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(Order::class)->constrained()->onDelete('cascade');

            // The status should match the main Order status enum for consistency
            $table->string('status');

            $table->string('location')->nullable();
            $table->text('description')->nullable();

            // We use created_at as the event date by default
            $table->timestamps();
        });
    }
    public function down(): void {
        Schema::dropIfExists('order_trackings');
    }
};
