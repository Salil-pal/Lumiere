<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            'Apple',
            'Samsung',
            'Nike',
            'Sony',
        ];

        foreach ($brands as $brand) {
            Brand::create([
                'en_brand_name' => $brand,
                'slug' => Str::slug($brand),
                'status' => true,
            ]);
        }
    }
}
