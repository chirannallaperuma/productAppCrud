<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            ['name' => 'Cat 1', 'description' => 'test category'],
            ['name' => 'Cat 2', 'description' => 'test category'],
            ['name' => 'Cat 3', 'description' => 'test category'],
        ];

        foreach ($categories as $category) {
            ProductCategory::create($category);
        }
    }
}
