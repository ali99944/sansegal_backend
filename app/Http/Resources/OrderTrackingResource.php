<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class OrderTrackingResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'status' => $this->status,
            'location' => $this->location,
            'description' => $this->description,
            'event_date' => $this->created_at->toIso8601String(),
        ];
    }
}
