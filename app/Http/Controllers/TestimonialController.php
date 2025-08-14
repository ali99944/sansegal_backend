<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\TestimonialResource;
use App\Models\Product;
use App\Models\Testimonial;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class TestimonialController extends Controller
{
    public function index()
    {
        $testimonials = Testimonial::with('product')
            ->where('is_visible', true)
            ->latest()
            ->get();

        return TestimonialResource::collection($testimonials);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'location' => 'nullable|string|max:255',
            'review' => 'required|string',
            'product_id' => 'nullable|exists:products,id',
            'is_visible' => 'sometimes|boolean',
        ]);

        // --- NEW LOGIC ---
        // If a product_id is provided, find the product and store its name.
        if (!empty($validated['product_id'])) {
            $product = Product::find($validated['product_id']);
            $validated['product_name'] = $product->en_name; // Or ar_name, as needed
        } else {
            // Handle cases where a product name is submitted without an ID
            $validated['product_name'] = $request->input('product_name', 'General Feedback');
        }

        $testimonial = Testimonial::create($validated);

        return new TestimonialResource($testimonial->load('product'));
    }

    public function show(Testimonial $testimonial)
    {
        return new TestimonialResource($testimonial->load('product'));
    }

    public function update(Request $request, Testimonial $testimonial)
    {
        $validated = $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'location' => 'nullable|string|max:255',
            'review' => 'sometimes|required|string',
            'product_id' => 'nullable|exists:products,id',
            'is_visible' => 'sometimes|boolean',
        ]);

        // --- NEW LOGIC ---
        // If the product_id is being updated, we must also update the product_name.
        if ($request->has('product_id')) {
            if (!empty($validated['product_id'])) {
                $product = Product::find($validated['product_id']);
                $validated['product_name'] = $product->en_name;
            } else {
                // If product_id is explicitly set to null, we keep the old name
                // unless a new one is provided.
                $validated['product_name'] = $request->input('product_name', $testimonial->product_name);
            }
        }

        $testimonial->update($validated);

        return new TestimonialResource($testimonial->load('product'));
    }

    public function destroy(Testimonial $testimonial)
    {
        $testimonial->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
