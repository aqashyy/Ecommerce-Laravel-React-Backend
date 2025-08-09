<?php

namespace App\Services;

use App\DTO\OrderDTO;
use App\Interfaces\OrderInterface;
use App\Models\Order;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected OrderInterface $orderInterface
    )
    {
        //
    }

    public function create(OrderDTO $orderDTO): Order
    {
        return $this->orderInterface->create($orderDTO);
    }
}
