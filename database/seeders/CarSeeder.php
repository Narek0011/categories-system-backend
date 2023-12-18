<?php

namespace Database\Seeders;

use App\Models\Car;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Car::create([
            'brand' => 'Q7',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Car::create([
            'brand' => 'F10',
            'category_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Car::create([
            'brand' => 'S600',
            'category_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
