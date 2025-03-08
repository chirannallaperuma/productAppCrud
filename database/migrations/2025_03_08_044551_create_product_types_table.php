<?php

use App\Models\ProductType;
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
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('api_unique_number')->unique();
            $table->timestamps();
        });

        ProductType::insert([
            ['name' => 'Type 1', 'api_unique_number' => '111'],
            ['name' => 'Type 2', 'api_unique_number' => '222'],
            ['name' => 'Type 3', 'api_unique_number' => '333'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_types');
    }
};
