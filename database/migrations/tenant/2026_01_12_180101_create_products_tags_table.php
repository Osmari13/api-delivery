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
        Schema::create('products_tags', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->foreignUuid('product_id')
                ->constrained('products')
                ->onDelete('cascade');

            $table->foreignUuid('tag_id')
                ->constrained('tags')
                ->onDelete('cascade');

            $table->primary(['product_id', 'tag_id']); // opcional pero recomendado
            $table->timestamps(); // opcional, según tu relación
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products_tags');
    }
};
