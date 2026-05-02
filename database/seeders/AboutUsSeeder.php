<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\AboutUs;
class AboutUsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    

    public function run(): void
    {
        AboutUs::create([
            'title' => 'About Lumière',
            'short_description' => 'Premium ecommerce experience with modern design.',
            'description' => 'We are a modern ecommerce brand focused on quality, trust, and customer satisfaction...',
            'mission_title' => 'Our Mission',
            'mission_text' => 'To deliver high-quality products with a seamless shopping experience.',
            'vision_title' => 'Our Vision',
            'vision_text' => 'To become a leading ecommerce brand in Bangladesh and beyond.',
            'experience_years' => '5+',
        ]);
    }
}
