<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\CartItemResource;
use App\Models\CartItem;
use App\Models\Customer; // Your Customer model
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str; // For random generation

class CartController extends Controller
{

    /**
     * Display the user's or guest's cart items.
     */
    public function index(Request $request)
    {
        $guestToken = $request->header('X-Cart-Token');

        if (!$guestToken) {
            return response()->json(['data' => [], 'guest_cart_token' => null, 'total' => 0.00]);
        }

        $cartItems = CartItem::with('product')
                            ->guest($guestToken)
                            ->get();

        $total = $cartItems->sum(function ($item) {
             return round(($item->product->original_price ?? 0) * $item->quantity, 2);
        });

        return response()->json([
             'data' => CartItemResource::collection($cartItems),
             'guest_cart_token' => $guestToken, // Return token so frontend can store it
             'total' => round($total, 2)
        ]);
    }

    /**
     * Add an item to the cart.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
            // 'addons_data' => 'nullable|array', // If using addons
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();
        $productId = $validated['product_id'];
        $quantity = $validated['quantity'];

        $guestToken = $request->header('X-Cart-Token');

        // --- Find or Create Cart Item ---
        $cartItem = CartItem::query()
            ->guest($guestToken)
            ->where('product_id', $productId)
            // Add addon checks here if necessary to treat items with different addons as distinct
            ->first();

        if ($cartItem) {
            // Item exists, update quantity
            $newQuantity = $cartItem->quantity + $quantity;

            $cartItem->quantity = $newQuantity;
            $cartItem->save();
        } else {
            // Item doesn't exist, create new entry
            $cartItemData = [
                'product_id' => $productId,
                'quantity' => $quantity
            ];
            $cartItemData['guest_cart_token'] = $guestToken;
            $cartItem = CartItem::create($cartItemData);
        }

        return $this->index($request)->setStatusCode(201); // Use 201 for successful creation/addition
    }

    /**
     * Update the quantity of a specific cart item.
     */
    public function update(Request $request, $cartItemId) // Pass Cart Item ID
    {
        $validator = Validator::make($request->all(), [
            'quantity' => 'required|integer|min:1',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $quantity = $request->input('quantity');
        $guestToken = $request->header('X-Cart-Token');

        $cartItem = CartItem::query()
            ->guest( $guestToken)
            ->find($cartItemId);

        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found.'], 404);
        }

        $product = $cartItem->product; // Get related product
        if (!$product) {
             $cartItem->delete(); // Clean up orphan cart item
             return response()->json(['message' => 'Associated product not found.'], 404);
        }

        $cartItem->quantity = $quantity;
        $cartItem->save();

         // Return updated cart
        return $this->index($request);
    }

    /**
     * Remove a specific item from the cart.
     */
    public function destroy(Request $request, $cartItemId)
    {
        $guestToken = $request->header('X-Cart-Token');

        $cartItem = CartItem::query()
            ->guest($guestToken)
            ->find($cartItemId);

        if (!$cartItem) {
            return response()->json(['message' => 'Cart item not found.'], 404);
        }

        $cartItem->delete();

         // Return updated cart or just success
        return $this->index($request);
        // return response()->json(null, 204); // No Content
    }

    /**
     * Clear all items from the cart.
     */
    public function clear(Request $request)
    {
        $guestToken = $request->header('X-Cart-Token');

         if (!$guestToken) {
             return response()->json(['message' => 'Cart token missing.'], 401);
         }

         CartItem::query()
            ->guest( $guestToken)
            ->delete();

        return response()->json(['data' => [], 'guest_cart_token' => $guestToken, 'total' => 0.00]);
    }
}
