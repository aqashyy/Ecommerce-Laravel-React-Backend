<?php

namespace App\DTO;

use App\Enums\OrderStatus;
use App\Enums\PaymentStatus;

readonly class OrderDTO
{
    /**
     * Create a new class instance.
     */
    public function __construct(
        public int $userId,
        public string $name,
        public string $address,
        public string $email,
        public string $mobile,
        public string $city,
        public string $state,
        public string $zip,
        public string $grandTotal,
        public string $subtotal,
        public string $shipping,
        public ?string $discount,
        public PaymentStatus $paymentStatus,
        public OrderStatus $status,
    )
    {
        //
    }
    public static function fromArray($data): self
    {
        return new self(
            userId: $data['user_id'],
            name: $data['name'],
            address: $data['address'],
            email: $data['email'],
            mobile: $data['mobile'],
            city: $data['city'],
            state: $data['state'],
            zip: $data['zip'],
            grandTotal: $data['grand_total'],
            subtotal: $data['subtotal'],
            shipping: $data['shipping'],
            discount: $data['discount'] ?? null,
            paymentStatus: $data['payment_status'],
            status: $data['status']

        );
    }
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
