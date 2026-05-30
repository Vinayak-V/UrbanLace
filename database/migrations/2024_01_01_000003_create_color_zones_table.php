<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('color_zones', function (Blueprint $table) {
            $table->id();
            $table->foreignId('shoe_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->string('mesh_name');
            $table->string('default_color', 7)->default('#FFFFFF');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('color_zones');
    }
};
