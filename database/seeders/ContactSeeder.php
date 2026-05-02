<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Contact;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    

    public function run(): void
    {
        Contact::create([
            'title' => 'Contact Lumière',
            'description' => 'We are here to help you anytime.',
            'email' => 'support@lumiere.com',
            'phone' => '+880 1XXXXXXXXX',
            'address' => 'Dhaka, Bangladesh',
            'map_embed' => '<iframe src="https://www.google.com/maps/embed?..."></iframe>',
        ]);
    }
}
