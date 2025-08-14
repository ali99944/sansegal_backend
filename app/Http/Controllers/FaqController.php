<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqResource;
use App\Models\Faq;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FaqController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $faqs = Faq::where('is_visible', true)
            ->orderBy('position')
            ->get();

        return FaqResource::collection($faqs);
    }
    /**
     * Store a newly created resource in storage. (Admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'faq_category_id' => 'required|exists:faq_categories,id',
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'position' => 'sometimes|integer',
            'is_visible' => 'sometimes|boolean',
        ]);

        $faq = Faq::create($validated);
        return new FaqResource($faq);
    }

    /**
     * Update the specified resource in storage. (Admin)
     */
    public function update(Request $request, Faq $faq)
    {
        $validated = $request->validate([
            'faq_category_id' => 'sometimes|required|exists:faq_categories,id',
            'question' => 'sometimes|required|string|max:255',
            'answer' => 'sometimes|required|string',
            'position' => 'sometimes|integer',
            'is_visible' => 'sometimes|boolean',
        ]);

        $faq->update($validated);
        return new FaqResource($faq);
    }

    /**
     * Remove the specified resource from storage. (Admin)
     */
    public function destroy(Faq $faq)
    {
        $faq->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }
}
