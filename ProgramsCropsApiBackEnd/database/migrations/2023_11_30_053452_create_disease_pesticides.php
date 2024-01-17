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
        Schema::create('disease_pesticides', function (Blueprint $table) {
            $table->id();
            $table->foreignId('disease_id')->constrained('diseases');
            $table->foreignId('pesticide_id')->constrained('pesticides');


            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void

    {
        Schema::table('disease_pesticides', function (Blueprint $table) {
            // Borra la relación
            $table->dropConstrainedForeignId('disease_id');
            $table->dropConstrainedForeignId('pesticide_id');
        });
        Schema::dropIfExists('disease_pesticides');
    }
};
