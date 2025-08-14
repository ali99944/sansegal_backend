<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\SeoResource;
use App\Models\Seo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SeoController extends Controller
{
    // For the control panel list page
    public function index()
    {
        return SeoResource::collection(Seo::all());
    }

    // For fetching a single record in the control panel edit page
    public function show(Seo $seo)
    {
        return new SeoResource($seo);
    }

    // For the public-facing website to fetch SEO by key
    public function showByKey(string $key)
    {
        $seo = Seo::where('key', $key)->firstOrFail();
        return new SeoResource($seo);
    }

    // The ONLY update endpoint
    public function update(Request $request, Seo $seo)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string|max:500',
            'keywords' => 'nullable|string|max:255',
            'canonicalUrl' => 'nullable|url',
            'ogTitle' => 'nullable|string|max:255',
            'ogDescription' => 'nullable|string|max:500',
            'ogImage' => 'nullable|image|max:2048', // Validate if a new image is uploaded
            'ogType' => 'nullable|string|max:50',
            'structuredData' => 'nullable|json',
        ]);

        $updateData = [
            'title' => $validated['title'],
            'description' => $validated['description'],
            'keywords' => $validated['keywords'] ?? null,
            'canonical_url' => $validated['canonicalUrl'] ?? null,
            'og_title' => $validated['ogTitle'] ?? $validated['title'],
            'og_description' => $validated['ogDescription'] ?? $validated['description'],
            'og_type' => $validated['ogType'] ?? 'website',
            'structured_data' => isset($validated['structuredData']) ? json_decode($validated['structuredData'], true) : null,
        ];

        if ($request->hasFile('ogImage')) {
            // Delete old image if it exists
            if ($seo->og_image) {
                Storage::disk('public')->delete($seo->og_image);
            }
            // Store new one
            $updateData['og_image'] = $request->file('ogImage')->store('seo', 'public');
        }

        $seo->update($updateData);

        return new SeoResource($seo);
    }
}
