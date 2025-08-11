<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = [
        'user_id',
        'name',
        'address',
        'email',
        'mobile',
        'city',
        'state',
        'zip',
        'grand_total',
        'subtotal',
        'shipping',
        'discount',
        'payment_status',
        'status'
    ];

    public function order_items() {
        return $this->hasMany(OrderItem::class);
    }

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime:d M Y',
        ];
    }
}
