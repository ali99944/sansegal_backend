<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductResource;
use App\Models\AppModel;
use App\Models\Product;
use App\Models\ProductImage;
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
        $products = Product::with(['variants', 'models', 'images'])->latest()->get();
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
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'required_with:specifications.*.value|string|max:255',
            'specifications.*.value' => 'required_with:specifications.*.key|string|max:255',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
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
            ]);

            if (!empty($validated['specifications'])) {
                foreach ($validated['specifications'] as $spec) {
                    // Ensure both key and value exist before creating
                    if (!empty($spec['key']) && !empty($spec['value'])) {
                        $product->specifications()->create([
                            'spec_key' => $spec['key'],
                            'spec_value' => $spec['value'],
                        ]);
                    }
                }
            }

            return $product;
        });


        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $file) {
                $path = $file->store('products/gallery', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'position' => $index,
                ]);
            }
        }

        return new ProductResource($product->load(['variants', 'models', 'images', 'specifications']));
    }

    public function show(Product $product)
    {
        return new ProductResource($product->load(['variants', 'models', 'images', 'specifications']));
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
            'specifications' => 'nullable|array',
            'specifications.*.key' => 'required_with:specifications.*.value|string|max:255',
            'specifications.*.value' => 'required_with:specifications.*.key|string|max:255',
            'gallery_images' => 'nullable|array',
            'gallery_images.*' => 'image|mimes:jpeg,png,jpg,webp|max:2048'
        ]);

        if ($request->hasFile('image')) {
            // Delete the old image
            Storage::disk('public')->delete($product->image);
            // Store the new one
            $validated['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($validated);

        $product->specifications()->delete();

        if (!empty($validated['specifications'])) {
            foreach ($validated['specifications'] as $spec) {
                if (!empty($spec['key']) && !empty($spec['value'])) {
                    $product->specifications()->create([
                        'spec_key' => $spec['key'],
                        'spec_value' => $spec['value'],
                    ]);
                }
            }
        }

        // Handle newly added images
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $file) {
                $path = $file->store('products/gallery', 'public');
                $product->images()->create([
                    'image_path' => $path,
                    'position' => $index + $product->images()->count(), // Append to the end
                ]);
            }
        }

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


    /**
     * Fetch products that may be of interest to a customer viewing a specific product.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Product $product The product currently being viewed.
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function relatedProducts(Request $request, Product $product)
    {
        // 1. Define the number of products to return (can be customized via query param)
        $limit = (int) $request->query('limit', 4);

        // 2. Get the values of the current product's specifications
        $currentSpecValues = $product->specifications()->pluck('spec_value');

        // 3. Build the query to find related products
        $relatedProducts = Product::query()
            // Exclude the current product from the results
            ->where('id', '!=', $product->id)
            // Eager load relationships to avoid N+1 query problems
            ->with(['images', 'specifications'])
            // Create a "relevance_score" based on how many specifications are shared
            ->withCount(['specifications as relevance_score' => function ($query) use ($currentSpecValues) {
                $query->whereIn('spec_value', $currentSpecValues);
            }])
            // Prioritize products with a higher relevance score
            ->orderByDesc('relevance_score')
            // Randomize the order for products with the same score to keep it fresh
            ->inRandomOrder()
            // Limit the number of results
            ->limit($limit)
            ->get();

        // 4. Return the results using the consistent ProductResource
        return ProductResource::collection($relatedProducts);
    }
}
