<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\ProductColor;
use App\Models\ProductType;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ProductCategory::class,
            ProductType::class,
            ProductColor::class
        ]);
    }
}
