<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('coupon_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('delivery_option_id')->nullable()->constrained('delivery_options')->onDelete('set null');
            $table->enum('status', [
                'pending', 'confirmed', 'crafting', 'quality_check',
                'shipped', 'out_for_delivery', 'delivered',
                'cancelled', 'return_initiated', 'returned', 'refunded'
            ])->default('pending');
            $table->decimal('subtotal', 10, 2);
            $table->decimal('discount', 10, 2)->default(0);
            $table->decimal('delivery_fee', 10, 2)->default(0);
            $table->decimal('total', 10, 2);
            $table->text('shipping_address');
            $table->string('shipping_city', 100);
            $table->string('shipping_state', 100)->nullable();
            $table->string('shipping_zip', 20);
            $table->string('shipping_country', 100);
            $table->string('shipping_phone', 20)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });

        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade');
            $table->foreignId('shoe_id')->constrained()->onDelete('cascade');
            $table->foreignId('shoe_design_id')->nullable()->constrained()->onDelete('set null');
            $table->json('design_snapshot');
            $table->string('design_thumbnail')->nullable();
            $table->decimal('size', 4, 1);
            $table->integer('quantity')->default(1);
            $table->decimal('price_snapshot', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
