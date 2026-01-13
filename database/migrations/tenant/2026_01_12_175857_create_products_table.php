<?php

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
        Schema::create('products', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name', 150);
            $table->text('description')->nullable();
            $table->boolean('available')->default(true);
            $table->boolean('isPriority')->default(false);
            $table->decimal('price', 8, 2);
            $table->foreignUuid('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->decimal('discount', 5, 2)->default(0);
            $table->string('image_url')->nullable();
            $table->primary(['category_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
