<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class TestimonialResource extends JsonResource
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
            'name' => $this->name,
            'location' => $this->location,
            'review' => $this->review,

            // This provides everything the frontend needs for the product link
            'product' => [
                'name' => $this->product_name, // The name will always be here
                'id' => $this->product_id,     // The ID, which can be null
                'isActive' => $this->product()->exists(), // A boolean to easily check if the link should be active
            ],

            'isVisible' => $this->is_visible,
        ];
    }
}
