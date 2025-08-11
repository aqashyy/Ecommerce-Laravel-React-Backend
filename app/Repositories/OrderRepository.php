<?php

namespace App\Repositories;

use App\DTO\OrderDTO;
use App\Interfaces\OrderInterface;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

class OrderRepository implements OrderInterface
{
    public function all(): Collection
    {
        return Order::all();
    }
    public function findById(int $id): Order|null
    {
        return Order::with('order_items','order_items.product')->find($id);
    }

    public function findByUser(int $id): ?Collection
    {
        return Order::where('user_id', $id)
                ->with('order_items','order_items.product')
                ->get();
    }

    public function create(OrderDTO $orderDTO): Order
    {
        return Order::create($orderDTO->toArray());
    }
    public function update(Order $order, array $data): Order
    {
        $order->update($data);
        return $order;
    }
    public function delete(Order $order): void
    {
        $order->delete();
    }
}
