<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('shoe_designs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('shoe_id')->constrained()->onDelete('cascade');
            $table->json('design_json'); // full configurator state
            $table->string('share_token', 64)->nullable()->unique();
            $table->string('thumbnail_url')->nullable();
            $table->string('name')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('shoe_designs');
    }
};
