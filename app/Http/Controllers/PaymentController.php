<?php

namespace App\Http\Controllers;

use App\DTO\PaymentDTO;
use App\Services\PaymentService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    public function __construct(
        protected PaymentService $paymentService
    ) {
        
    }


    public function createOrder(Request $request)
    {
        $validator = Validator::make($request->all(),[
            'amount'    =>  'required|numeric'
        ]);

        if($validator->fails()) {
            return response()->json([
                'status'    => 400,
                'errors'    =>  $validator->errors()
            ],400);
        }
        
        $order = $this->paymentService->initiatePayment(PaymentDTO::fromArray([
            'order_id'  =>  uniqid('order_'),
            'amount'    =>  $request->amount * 100, //convert to paise
            'currency'  =>  'INR',
            'receipt'   =>  'receipt_'. time()
        ]));

        return response()->json([
            'status'    =>  200,
            'order_id'  =>  $order['id'],
            'amount'    =>  $order['amount'],
            'currency'  =>  $order['currency'],
            'receipt'   =>  $order['receipt'],
            'key'       =>  config('services.razorpay.key')
        ],200);
    }

    public function verifyPayment(Request $request)
    {
        $verified = $this->paymentService->confirmPayment([
            'razorpay_order_id'   => $request->razorpay_order_id,
            'razorpay_payment_id' => $request->razorpay_payment_id,
            'razorpay_signature'  => $request->razorpay_signature
        ]);

        return response()->json(['success' => $verified],200);
    }
}
