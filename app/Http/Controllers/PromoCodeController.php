<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\PromoCodeResource;
use App\Models\PromoCode;
use Illuminate\Http\Request;
use Illuminate\Http\Response;

class PromoCodeController extends Controller
{
    public function index()
    {
        return PromoCodeResource::collection(PromoCode::latest()->get());
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|unique:promo_codes,code|max:255',
            'type' => 'required|in:percentage,fixed',
            'value' => 'required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
        ]);

        $promoCode = PromoCode::create($validated);
        return new PromoCodeResource($promoCode);
    }

    public function show(PromoCode $promoCode)
    {
        return new PromoCodeResource($promoCode);
    }

    public function update(Request $request, PromoCode $promoCode)
    {
        $validated = $request->validate([
            'code' => 'sometimes|required|string|unique:promo_codes,code,' . $promoCode->id . '|max:255',
            'type' => 'sometimes|required|in:percentage,fixed',
            'value' => 'sometimes|required|numeric|min:0',
            'max_uses' => 'nullable|integer|min:1',
            'expires_at' => 'nullable|date',
            'is_active' => 'sometimes|boolean',
        ]);

        $promoCode->update($validated);
        return new PromoCodeResource($promoCode);
    }

    public function destroy(PromoCode $promoCode)
    {
        $promoCode->delete();
        return response(null, Response::HTTP_NO_CONTENT);
    }


    public function getByCode(Request $request)
    {
        $validated = $request->validate([
            'code' => 'required|string|max:255'
        ]);

        $promoCode = PromoCode::where('code', $validated['code'])
            ->where(function ($query) {
                $query->where('expires_at', '>', now())
                    ->orWhereNull('expires_at');
            })
            ->where('is_active', true)
            ->first();

        if (!$promoCode) {
            return response()->json([
                'message' => 'Invalid or expired promo code'
            ], Response::HTTP_NOT_FOUND);
        }

        return new PromoCodeResource($promoCode);
    }
}
