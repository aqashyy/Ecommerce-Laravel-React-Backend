<?php

namespace App\Interfaces;

use App\DTO\PaymentDTO;

interface PaymentInterface
{
    public function createOrder(PaymentDTO $paymentDTO): array;
    
    public function verifySignature(array $attributes): bool;
}
