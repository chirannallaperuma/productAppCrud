<?php

namespace Database\Seeders;

use App\Models\ProductCategory;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_categories')->truncate();

        $categories = [
            ['name' => 'Cat 1', 'description' => 'test category'],
            ['name' => 'Cat 2', 'description' => 'test category'],
            ['name' => 'Cat 3', 'description' => 'test category'],
        ];

        ProductCategory::insert($categories);
    }
}
