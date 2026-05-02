<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;
use Illuminate\Support\Str;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        for ($i = 1; $i <= 16; $i++) {

            $price = rand(50, 500);
            $discount = rand(0, 20);
            $discounted = round($price - ($price * $discount / 100), 2);
            // $discounted = $price - ($price * $discount / 100);

            Product::create([
                'category_id' => rand(1,4),
                'brand_id' => rand(1,4),
                'en_name' => "Product $i",
                'slug' => Str::slug("Product $i"),
                'en_description' => "Description for product $i",
                'en_shipping' => "Standard shipping available",
                'en_additional_info' => "Additional information for product $i",
                'is_featured' => rand(0,1),
                'is_best_selling' => rand(0,1),
                'is_new_arrival' => rand(0,1),
                'is_onsale' => rand(0,1),
                'price' => $price,
                'discount' => $discount,
                'discounted_price' => $discounted,
                'quantity' => rand(5,100),
                'status' => true,
                'review' => rand(10,50) / 10, // gives 1.0 → 5.0 like 4.3
            ]);
        }
    }
}