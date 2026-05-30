<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('carts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('cascade');
            $table->string('session_id')->nullable()->index();
            $table->timestamps();
        });

        Schema::create('cart_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cart_id')->constrained()->onDelete('cascade');
            $table->foreignId('shoe_design_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('shoe_id')->constrained()->onDelete('cascade');
            $table->json('design_snapshot'); // frozen copy of design_json at time of add
            $table->string('design_thumbnail')->nullable();
            $table->decimal('size', 4, 1);
            $table->integer('quantity')->default(1);
            $table->decimal('price_snapshot', 10, 2);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cart_items');
        Schema::dropIfExists('carts');
    }
};
