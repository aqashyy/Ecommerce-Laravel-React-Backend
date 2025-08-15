<?php

namespace App\Services;

use App\DTO\PaymentDTO;
use App\Interfaces\PaymentInterface;

class PaymentService
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        protected PaymentInterface $paymentInterface
    )
    {
        //
    }

    public function initiatePayment(PaymentDTO $paymentDTO): array
    {
        return $this->paymentInterface->createOrder($paymentDTO);
    }

    public function confirmPayment(array $data): bool
    {
        return $this->paymentInterface->verifySignature($data);
    }
}
