<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'en_category_name',
        'slug',
        'icon',
        'desc',
        'en_short_info',
        'status',
    ];

    /**
     * Relationship: Category has many products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}