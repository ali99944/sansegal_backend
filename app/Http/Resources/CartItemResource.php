<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CartItemResource extends JsonResource
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
            'guest_cart_token' => $this->guest_cart_token,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'product_id' => $this->product_id,
            'quantity' => $this->quantity,
            'product' => new ProductResource($this->whenLoaded('product'))
        ];
    }
}
