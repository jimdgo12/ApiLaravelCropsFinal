<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Crop;
use App\Models\Seed;
use App\Models\Disease;
use App\Models\Pesticide;
use App\Models\Fertilizer;
use App\Models\CropDisease;

use App\Models\CropFertilizer;
use App\Models\DiseasePesticide;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();
        Crop::factory(10)->create();
        Seed::factory(40)->create();
        Disease::factory(10)->create();
        Pesticide::factory(10)->create();
        Fertilizer::factory(50)->create();
        CropFertilizer::factory(100)->create();
        CropDisease::factory(100)->create();
        DiseasePesticide::factory(100)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);
    }
}
