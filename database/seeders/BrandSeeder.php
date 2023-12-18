<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::create([
            'name' => 'Q7',
            'category_id' => 1,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Brand::create([
            'name' => 'F10',
            'category_id' => 2,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
        Brand::create([
            'name' => 'S600',
            'category_id' => 3,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
