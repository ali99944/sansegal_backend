<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\AppModel;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    public function index()
    {
        // Eager load relationships for efficiency
        // $products = Product::with(['variants', 'models'])->latest()->paginate(10);
        $products = Product::with(['variants', 'models'])->latest()->get();
        return ProductResource::collection($products);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'en_name' => 'required|string|max:255',
            'ar_name' => 'required|string|max:255',
            'en_description' => 'required|string',
            'ar_description' => 'required|string',
            'image' => 'required|image|max:2048', // Example validation
            'original_price' => 'required|numeric',
            'discount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:percentage,fixed',
            'specifications' => 'required|json',
            // 'initial_variant_color' => 'required|string|max:255',
            // 'initial_variant_image' => 'required|image|max:2048',
        ]);

        Log::info($validated);

        // Use a transaction to ensure data integrity
        $product = DB::transaction(function () use ($request, $validated) {
            $imagePath = $request->file('image')->store('products', 'public');
            // $variantImagePath = $request->file('initial_variant_image')->store('variants', 'public');

            $product = Product::create([
                'en_name' => $validated['en_name'],
                'ar_name' => $validated['ar_name'],
                'en_description' => $validated['en_description'],
                'ar_description' => $validated['ar_description'],
                'image' => $imagePath,
                'original_price' => $validated['original_price'],
                'discount' => $validated['discount'] ?? null,
                'discount_type' => $validated['discount_type'] ?? null,
                'specifications' => json_decode($validated['specifications']),
            ]);

            // $product->variants()->create([
            //     'color' => $validated['initial_variant_color'],
            //     'image' => $variantImagePath,
            // ]);

            return $product;
        });

        return new ProductResource($product->load(['variants', 'models']));
    }

    public function show(Product $product)
    {
        return new ProductResource($product->load(['variants', 'models']));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $validated = $request->validate([
            'en_name' => 'sometimes|required|string|max:255',
            'ar_name' => 'sometimes|required|string|max:255',
            'en_description' => 'sometimes|required|string',
            'ar_description' => 'sometimes|required|string',
            'image' => 'sometimes|image|max:2048', // Image is optional on update
            'original_price' => 'sometimes|required|numeric|min:0',
            'discount' => 'nullable|numeric',
            'discount_type' => 'nullable|in:percentage,fixed',
            'specifications' => 'sometimes|required|json',
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image
            Storage::disk('public')->delete($product->image);
            // Store the new one
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        return new ProductResource($product->load(['variants', 'models']));
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        // Delete the main product image
        Storage::disk('public')->delete($product->image);

        // Delete images for each variant
        foreach ($product->variants as $variant) {
            Storage::disk('public')->delete($variant->image);
        }

        // The database records for variants and the pivot table
        // entries will be deleted automatically because of the
        // onDelete('cascade') we set in the migrations.
        $product->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    /**
     * Attach a model to a product.
     */
    public function attachModel(Product $product, AppModel $appModel)
    {
        $product->models()->syncWithoutDetaching([$appModel->id]);
        return new ProductResource($product->load('models'));
    }

    /**
     * Detach a model from a product.
     */
    public function detachModel(Product $product, AppModel $appModel)
    {
        $product->models()->detach($appModel->id);
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
