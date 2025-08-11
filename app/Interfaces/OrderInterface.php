<?php

namespace App\Interfaces;

use App\DTO\OrderDTO;
use App\Models\Order;
use Illuminate\Database\Eloquent\Collection;

interface OrderInterface
{
    public function all(): Collection;

    public function findById(int $id): ?Order;

    public function findByUser(int $id): ?Collection;

    public function create(OrderDTO $orderDTO): Order;

    public function update(Order $order, array $data): Order;

    public function delete(Order $order): void;
}
