<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ContactMessageResource extends JsonResource
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
            'fullName' => $this->full_name,
            'email' => $this->email,
            'subject' => $this->subject,
            'message' => $this->message,
            'isRead' => $this->read_at !== null,
            'receivedAt' => $this->created_at->toDateTimeString(),
        ];
    }
}
