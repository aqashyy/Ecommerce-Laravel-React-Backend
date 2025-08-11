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
        public int $user_id,
        public string $name,
        public string $address,
        public string $email,
        public string $mobile,
        public string $city,
        public string $state,
        public string $zip,
        public string $grand_total,
        public string $subtotal,
        public string $shipping,
        public ?string $discount,
        public PaymentStatus $payment_status,
        public OrderStatus $status,
    )
    {
        //
    }
    public static function fromArray($data): self
    {
        return new self(
            user_id: $data['user_id'],
            name: $data['name'],
            address: $data['address'],
            email: $data['email'],
            mobile: $data['mobile'],
            city: $data['city'],
            state: $data['state'],
            zip: $data['zip'],
            grand_total: $data['grand_total'],
            subtotal: $data['subtotal'],
            shipping: $data['shipping'],
            discount: $data['discount'] ?? null,
            payment_status: PaymentStatus::from($data['payment_status']),
            status: OrderStatus::from($data['status'])

        );
    }
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
