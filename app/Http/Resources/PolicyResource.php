<?php
namespace App\Http\Resources;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
class PolicyResource extends JsonResource {
    public function toArray(Request $request): array {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'content' => $this->content, // The raw Markdown content
            'is_published' => $this->is_published,
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
