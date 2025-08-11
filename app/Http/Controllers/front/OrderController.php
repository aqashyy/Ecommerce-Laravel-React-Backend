<?php

namespace App\Http\Controllers\front;

use App\DTO\OrderDTO;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Services\OrderService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function __construct(
        protected OrderService $orderService
    ) {}
    public function saveOrder(Request $request): JsonResponse {

        // save order
        $order = $this->orderService->create(OrderDTO::fromArray([
            ... $request->all(),
            'user_id' => $request->user()->id
        ]), $request->cart);


        return response()->json([
            'status'    =>  200,
            'id'        =>  $order->id,
            'message'   =>  "Your order placed successfully"
        ],200);
    }

    public function orderDetails(Request $request, $id): JsonResponse {

        $order = $this->orderService->getOrderDetails($request->user()->id, $id);

        if($order == null) {
            return response()->json([
                'status' => 404,
                'message'   =>  'Order Not Found!'
            ],404);
        } else {
            return response()->json([
                'status'    => 200,
                'data'  =>  $order
            ],200);
        }
    }
}
