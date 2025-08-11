<?php

namespace App\Repositories;

use App\DTO\OrderItemDTO;
use App\Interfaces\OrderItemInterface;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;

class OrderItemRepository implements OrderItemInterface
{

    public function all(): Collection
    {
        return OrderItem::all();
    }

    public function findByOrderId(int $id): ?Collection
    {
        return OrderItem::where('order_id', $id)->get();
    }
    public function create(OrderItemDTO $orderItemDTO): OrderItem
    {
        return OrderItem::create($orderItemDTO->toArray());
    }
}
