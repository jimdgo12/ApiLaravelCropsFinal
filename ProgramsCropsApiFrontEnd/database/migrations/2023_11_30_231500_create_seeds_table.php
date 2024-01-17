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
        Schema::create('seeds', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->string('nameScientific', 200);
            $table->string('origin', 100);
            $table->string('morphology', 200);
            $table->string('type', 50);
            $table->string('quality', 50);
            $table->string('spreading', 50);
            $table->string('image');
            $table->foreignId('crop_id')->constrained('crops');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seeds');
    }
};
