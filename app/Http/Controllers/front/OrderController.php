<?php

namespace App\Http\Controllers\front;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function saveOrder(Request $request) {

        // save order
        $order = new Order();

        $order->user_id         = $request->user()->id;
        $order->name            =   $request->name;
        $order->address         =   $request->address;
        $order->email           =   $request->email;
        $order->mobile          =   $request->mobile;
        $order->city            =   $request->city;
        $order->state           =   $request->state;
        $order->zip             =   $request->zip;
        $order->grand_total     =   $request->grand_total;
        $order->subtotal        =   $request->subtotal;
        $order->shipping        =   $request->shipping;
        $order->discount        =   $request->discount;
        $order->payment_status  =   $request->payment_status;
        $order->status          =   $request->status;
        $order->save();

        // save order Item

        foreach($request->cart as $item) {

            $orderItem = new OrderItem();
            $orderItem->product_id  =   $item['product_id'];
            $orderItem->order_id    =   $order->id;
            $orderItem->name        =   $item['name'];
            $orderItem->size        =   $item['size'];
            $orderItem->price       =   $item['price'];
            $orderItem->unit_price  =   $item['unit_price'];
            $orderItem->qty         =   $item['qty'];
            $orderItem->save();
        }

        return response()->json([
            'status'    =>  200,
            'message'   =>  "Your order placed successfully"
        ],200);
    }
}
