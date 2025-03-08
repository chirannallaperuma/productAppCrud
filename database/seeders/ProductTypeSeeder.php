<?php

namespace Database\Seeders;

use App\Models\ProductType;
use Illuminate\Database\Seeder;

class ProductTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            ['name' => 'Type 1', 'api_unique_number' => '111'],
            ['name' => 'Type 2', 'api_unique_number' => '222'],
            ['name' => 'Type 3', 'api_unique_number' => '333'],
        ];

        foreach ($types as $type) {
            ProductType::create($type);
        }
    }
}
