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
            'id' => $this->id,
            'order_code' => $this->order_code,
            'status' => $this->status,
            'order_date' => $this->created_at->toDateTimeString(),
            'customer' => [
                'first_name' => $this->first_name,
                'last_name' => $this->last_name,
                'email' => $this->email,
                'phone' => $this->phone
            ],
            'shipping_address' => [
                'address' => $this->address,
                'city' => $this->city,
                'special_mark' => $this->special_mark,
            ],
            'financials' => [
                'subtotal' => (float) $this->subtotal,
                'shipping' => (float) $this->shipping_cost,
                'tax' => (float) $this->tax_amount,
                'promo_discount' => (float) $this->promo_discount,
                'grand_total' => (float) $this->grand_total,
            ],
            'items' => OrderItemResource::collection($this->whenLoaded('items')),
        ];
    }
}
