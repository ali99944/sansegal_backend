<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => [
                'en' => $this->en_name,
                'ar' => $this->ar_name,
            ],
            'description' => [
                'en' => $this->en_description,
                'ar' => $this->ar_description,
            ],
            'image' => $this->image,
            'price' => $this->original_price,
            'discount' => $this->discount,
            'discountType' => $this->discount_type,
            'specifications' => $this->specifications,
            'variants' => ProductVariantResource::collection($this->whenLoaded('variants')),
            'models' => AppModelResource::collection($this->whenLoaded('models')),
        ];
    }
}
