<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use App\Models\ProductColor;
use App\Models\ProductType;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        $this->call([
            ProductCategory::class,
            ProductType::class,
            ProductColor::class
        ]);
    }
}
