<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromotionResource;
use App\Models\Promotion;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PromotionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return PromotionResource::collection(Promotion::where('is_active', true)->get());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'text' => 'required|string|max:255',
            'bg_color' => 'required|string|max:50',
            'text_color' => 'required|string|max:50',
            'is_active' => 'boolean',
        ]);

        $promotion = Promotion::create($request->all());

        return new PromotionResource($promotion);
    }


    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Promotion $promotion)
    {
        $request->validate([
            'text' => 'sometimes|required|string|max:255',
            'bg_color' => 'sometimes|required|string|max:50',
            'text_color' => 'sometimes|required|string|max:50',
            'is_active' => 'sometimes|boolean',
        ]);

        $promotion->update($request->all());

        return new PromotionResource($promotion);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Promotion $promotion)
    {
        $promotion->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
