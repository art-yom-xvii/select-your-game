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
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->text('short_description')->nullable();
            $table->decimal('price', 10, 2);
            $table->decimal('compare_at_price', 10, 2)->nullable();
            $table->string('sku')->unique();
            $table->integer('stock')->default(0);
            $table->boolean('is_digital')->default(false);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_active')->default(true);

            // Video game specific fields
            $table->foreignId('platform_id')->nullable()->constrained()->nullOnDelete();
            $table->string('publisher')->nullable();
            $table->string('developer')->nullable();
            $table->date('release_date')->nullable();
            $table->enum('product_type', ['game', 'merchandise'])->default('game');
            $table->string('esrb_rating')->nullable();

            // Merchandise specific fields
            $table->string('dimensions')->nullable(); // For physical products
            $table->string('weight')->nullable(); // For shipping calculations
            $table->string('material')->nullable(); // For posters, figures etc.

            $table->timestamps();
        });

        // Many-to-many relationship between products and categories
        Schema::create('category_product', function (Blueprint $table) {
            $table->foreignId('category_id')->constrained()->cascadeOnDelete();
            $table->foreignId('product_id')->constrained()->cascadeOnDelete();
            $table->primary(['category_id', 'product_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('category_product');
        Schema::dropIfExists('products');
    }
};
