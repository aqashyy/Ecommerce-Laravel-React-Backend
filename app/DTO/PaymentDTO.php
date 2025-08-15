<?php

namespace App\DTO;

readonly class PaymentDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public string $order_id,
        public int $amount,
        public string $currency = 'INR',
        public string $reciept,
        public string $status = 'created'
    )
    {
        //
    }

    public static function fromArray(array $data): self
    {
        return new self(
            order_id: $data['order_id'],
            amount: $data['amount'],
            currency: $data['currency'],
            reciept: $data['reciept'],
            status: $data['status'] ?? 'created'
        );
    }

    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
