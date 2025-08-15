<?php

namespace App\Repositories;

use App\DTO\PaymentDTO;
use App\Interfaces\PaymentInterface;
use Razorpay\Api\Api;

class PaymentRepository implements PaymentInterface
{
    protected Api $razorpay;

    public function __construct()
    {
        $this->razorpay = new Api(
            config('services.razorpay.key'),
            config('services.razorpay.secret')
        );
    }
    public function createOrder(PaymentDTO $paymentDTO): array
    {
        $order = $this->razorpay->order->create([
            'reciept'   =>  $paymentDTO->reciept,
            'amount'    =>  $paymentDTO->amount, //in paise
            'currency'  =>  $paymentDTO->currency,
        ]);

        return $order->toArray();
    }

    public function verifySignature(array $attributes): bool
    {
        try {
            $this->razorpay->utility->verifyPaymentSignature($attributes);
            return true;
        } catch (\Exception $th) {
            return false;
        }
    }
}
