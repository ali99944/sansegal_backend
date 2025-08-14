<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class FaqCategoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            // Load the collection of FAQs using the FaqResource
            'faqs' => FaqResource::collection($this->whenLoaded('faqs')),
        ];
    }
}
