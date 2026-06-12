<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = [
    'category_id',
    'brand_id',
    'en_name',
    'slug',
    'image',
    'en_description',
    'en_shipping',
    'en_additional_info',
    'is_featured',
    'is_best_selling',
    'is_new_arrival',
    'is_onsale',
    'price',
    'stock',
    'discount',
    'discounted_price',
    'quantity',
    'status',
    'review', // ✅ must add
    ];

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
