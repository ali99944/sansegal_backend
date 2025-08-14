<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class OrderItemResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'productName' => $this->product_name,
            'productImage' => $this->product_image ? Storage::url($this->product_image) : null,
            'price' => (float) $this->price,
            'quantity' => $this->quantity,
            'color' => $this->color,
            'size' => $this->size,
        ];
    }
}
