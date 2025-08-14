<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AppModelResource extends JsonResource
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
            'imageUrl' => $this->image,
            'width' => $this->width,
            'height' => $this->height,
            // 'products' => ProductResource::collection($this->whenLoaded('products'))
            'products' => [],
        ];
    }
}
