<?php

use App\Models\ProductCategory;
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
        Schema::create('product_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('external_url')->nullable();
            $table->timestamps();
        });

        ProductCategory::insert([
            ['name' => 'Category 1', 'description' => 'Description for Category 1'],
            ['name' => 'Category 2', 'description' => 'Description for Category 2'],
            ['name' => 'Category 3', 'description' => 'Description for Category 3'],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_categories');
    }
};
