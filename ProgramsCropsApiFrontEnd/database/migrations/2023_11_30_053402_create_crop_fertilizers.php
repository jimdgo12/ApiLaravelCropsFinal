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
        Schema::create('crop_fertilizers', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained('crops');
            $table->foreignId('fertilizer_id')->constrained('fertilizers');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crop_fertilizers', function (Blueprint $table) {
            // Borra la relación
            $table->dropConstrainedForeignId('crop_id');
            $table->dropConstrainedForeignId('fertilizer_id');
        });
        Schema::dropIfExists('crop_fertilizers');
    }
};
