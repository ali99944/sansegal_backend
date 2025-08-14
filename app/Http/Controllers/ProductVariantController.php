<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductVariantResource;
use App\Models\ProductVariant;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;

class ProductVariantController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'color' => 'required|string|max:255',
            'image' => 'required|image|max:2048',
        ]);

        $validated['image'] = $request->file('image')->store('variants', 'public');

        $variant = ProductVariant::create($validated);

        return new ProductVariantResource($variant);
    }

    /**
     * Update the specified resource in storage.
     * Note: We don't typically change the product_id of a variant.
     */
    public function update(Request $request, ProductVariant $variant)
    {
        $validated = $request->validate([
            'color' => 'sometimes|required|string|max:255',
            'image' => 'sometimes|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            Storage::disk('public')->delete($variant->image);
            $validated['image'] = $request->file('image')->store('variants', 'public');
        }

        $variant->update($validated);

        return new ProductVariantResource($variant);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductVariant $variant)
    {
        Storage::disk('public')->delete($variant->image);
        $variant->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
