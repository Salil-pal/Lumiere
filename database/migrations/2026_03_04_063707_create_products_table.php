<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id(); // Auto-increment primary key
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // FK to categories
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null'); // FK to brands, optional
            $table->string('en_name'); // Product name
            $table->string('slug')->unique(); // Unique slug
            $table->string('thumb')->nullable(); 
            $table->text('en_description')->nullable(); // Product description
            $table->text('en_shipping')->nullable(); // Shipping info
            $table->text('en_additional_info')->nullable(); // Additional info

            // Feature flags
            $table->boolean('is_active')->default(1);
            $table->boolean('is_featured')->default(false);
            $table->boolean('is_best_selling')->default(false);
            $table->boolean('is_new_arrival')->default(false);
            $table->boolean('is_onsale')->default(false);

            // Pricing
            $table->decimal('price', 10, 2); // Original price
            $table->decimal('discount', 5, 2)->default(0); // Discount percentage
            $table->decimal('discounted_price', 10, 2)->nullable(); // Final price after discount

            $table->integer('quantity')->default(0); // Stock quantity
            $table->boolean('status')->default(true); // Active/Inactive

            $table->float('review')->default(0);
            
            $table->timestamps(); // created_at & updated_at
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};