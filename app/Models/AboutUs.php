<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AboutUs extends Model
{
    protected $fillable = [
        'title',
        'short_description',
        'description',
        'image',
        'mission_title',
        'mission_text',
        'vision_title',
        'vision_text',
        'experience_years',
    ];
}
