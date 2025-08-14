<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OrderResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'orderCode' => $this->order_code,
            'status' => $this->status,
            'orderDate' => $this->created_at->toDateTimeString(),
            'customer' => [
                'firstName' => $this->first_name,
                'lastName' => $this->last_name,
                'email' => $this->email,
            ],
            'shippingAddress' => [
                'address' => $this->address,
                'city' => $this->city,
                'specialMark' => $this->special_mark,
            ],
            'financials' => [
                'subtotal' => (float) $this->subtotal,
                'shipping' => (float) $this->shipping_cost,
                'tax' => (float) $this->tax_amount,
                'promoDiscount' => (float) $this->promo_discount,
                'grandTotal' => (float) $this->grand_total,
            ],
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
