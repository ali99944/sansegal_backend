<?php
namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SeoResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'key' => $this->key,
            'title' => $this->title,
            'description' => $this->description,
            'keywords' => $this->keywords,
            'canonicalUrl' => $this->canonical_url,
            'ogTitle' => $this->og_title,
            'ogDescription' => $this->og_description,
            'ogImage' => $this->og_image,
            'ogType' => $this->og_type,
            'structuredData' => $this->structured_data,
        ];
    }
}
