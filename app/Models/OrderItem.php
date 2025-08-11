<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'product_id',
        'order_id',
        'name',
        'size',
        'price',
        'unit_price',
        'qty'
    ];
    
    public function product() {
        return $this->belongsTo(Product::class);
    }
}
