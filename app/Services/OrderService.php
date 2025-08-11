<?php

namespace App\Services;

use App\DTO\OrderDTO;
use App\DTO\OrderItemDTO;
use App\Interfaces\OrderInterface;
use App\Interfaces\OrderItemInterface;
use App\Models\Order;

class OrderService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected OrderInterface $orderInterface,
        protected OrderItemInterface $orderItemInterface
    )
    {
        //
    }

    public function create(OrderDTO $orderDTO, array $orderItems): Order
    {
        // store order details
        $order =  $this->orderInterface->create($orderDTO);

        foreach ($orderItems as $item)
        {
            $orderItemDTO = OrderItemDTO::fromArray([
                'product_id'    =>  $item['product_id'],
                'order_id'      =>  $order->id,
                'name'          =>  $item['title'],
                'size'          =>  $item['size'],
                'price'         =>  $item['qty'] * $item['price'],
                'unit_price'    =>  $item['price'],
                'qty'           =>  $item['qty']
            ]);
            // store order items
            $this->orderItemInterface->create($orderItemDTO);

        }
        return $order;

    }
    public function getOrderDetails(int $userId, int $orderId): ?Order
    {
        $order = $this->orderInterface->findById($orderId);
        if(!$order) return null;

        if($order->user_id != $userId) return null;

        return $order;
    }
}
