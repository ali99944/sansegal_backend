<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\FaqCategoryResource;
use App\Models\FaqCategory;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class FaqCategoryController extends Controller
{
    /**
     * Display a listing of all categories with their visible FAQs.
     * This is the main endpoint for the FAQ page.
     */
    public function index()
    {
        $categories = FaqCategory::orderBy('position')
            ->with(['faqs' => function ($query) {
                $query->where('is_visible', true)->orderBy('position');
            }])
            ->get();

        return FaqCategoryResource::collection($categories);
    }

    /**
     * Store a newly created resource in storage. (Admin)
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:faq_categories,name',
            'position' => 'sometimes|integer',
        ]);

        $category = FaqCategory::create($validated);
        return new FaqCategoryResource($category);
    }

    // ... Other admin methods: show, update, destroy
}
