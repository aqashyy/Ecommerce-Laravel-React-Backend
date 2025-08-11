<?php

namespace App\Interfaces;

use App\DTO\OrderItemDTO;
use App\Models\OrderItem;
use Illuminate\Database\Eloquent\Collection;
use PhpParser\Node\Expr\FuncCall;

interface OrderItemInterface
{
    public function all(): Collection;
    public function findByOrderId(int $id): ?Collection;
    public function create(OrderItemDTO $orderItemDTO): OrderItem;
}
