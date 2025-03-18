<?php

namespace Database\Seeders;

use App\Models\ProductColor;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductColorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('product_colors')->truncate();

        $colors = [
            ['name' => 'Red', 'hex_code' => '#FF0000', 'description' => 'red color'],
            ['name' => 'Green', 'hex_code' => '#00FF00', 'description' => 'green color'],
            ['name' => 'Blue', 'hex_code' => '#0000FF', 'description' => 'blue color'],
        ];

        ProductColor::insert($colors);
    }
}
