<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $fillable = [
        'en_brand_name',
        'slug',
        'image',
        'status',
    ];

    /**
     * Relationship: Brand has many products
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
}