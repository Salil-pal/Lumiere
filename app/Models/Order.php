<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
    'order_number',
    'name',
    'user_id',
    'email',
    'phone',
    'address',
    'total',
    'status',
    'payment_method'
];

public function items()
{
    return $this->hasMany(\App\Models\OrderItem::class);
}
public function user()
{
    return $this->belongsTo(\App\Models\User::class);
}

}

