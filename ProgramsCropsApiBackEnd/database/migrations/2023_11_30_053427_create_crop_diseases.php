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
        Schema::create('crop_diseases', function (Blueprint $table) {
            $table->id();
            $table->foreignId('crop_id')->constrained('crops');
            $table->foreignId('disease_id')->constrained('diseases');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('crop_diseases', function (Blueprint $table) {
            // Borra la relación
            $table->dropConstrainedForeignId('crop_id');
            $table->dropConstrainedForeignId('disease_id');
        });
        Schema::dropIfExists('crop_diseases');
    }
};
