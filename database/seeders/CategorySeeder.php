<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;
use Illuminate\Support\Str;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Electronics',
                'short_info' => 'Latest gadgets and devices',
                'icon' => 'fa-tv',
                'desc' => 'All kinds of electronic products',
            ],
            [
                'name' => 'Fashion',
                'short_info' => 'Trendy clothing & accessories',
                'icon' => 'fa-shirt',
                'desc' => 'Clothing, shoes, and fashion accessories',
            ],
            [
                'name' => 'Home Appliances',
                'short_info' => 'Appliances for your home',
                'icon' => 'fa-blender',
                'desc' => 'Kitchen and household appliances',
            ],
            [
                'name' => 'Sports',
                'short_info' => 'Gear for all sports',
                'icon' => 'fa-football',
                'desc' => 'Equipment, apparel, and accessories for sports',
            ],
        ];

        foreach ($categories as $category) {
            Category::create([
                'en_category_name' => $category['name'],
                'slug' => Str::slug($category['name']),
                'icon' => $category['icon'],
                'desc' => $category['desc'],
                'en_short_info' => $category['short_info'],
                'status' => true,
            ]);
        }
    }
}