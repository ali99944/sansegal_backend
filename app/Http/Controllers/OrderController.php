<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Http\Resources\OrderResource;
use App\Models\CartItem;
use App\Models\Order;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class OrderController extends Controller
{
    /**
     * Display a paginated listing of the resource for the control panel.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        // Fetch the latest orders and paginate them
        // $orders = Order::latest()->paginate(15);
        $orders = Order::all();
        return OrderResource::collection($orders);
    }

    /**
     * Store a newly created order in storage.
     * (Stock decrement logic has been removed as per your instruction).
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'secondary_phone' => 'nullable|string|max:20',
            'address' => 'required|string|max:255',
            'secondary_address' => 'nullable|string|max:255',
            'city' => 'required|string|max:100',
            'special_mark' => 'nullable|string|max:1000',
            'promo_code' => 'nullable|string',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }
        $validatedCustomerData = $validator->validated();

        $cartToken = $request->header('X-Cart-Token');
        if (!$cartToken) {
            return response()->json(['message' => 'Cart identifier missing.'], 400);
        }

        $cartItems = CartItem::with('product')->guest($cartToken)->get();

        if ($cartItems->isEmpty()) {
            return response()->json(['message' => 'Your cart is empty.'], 400);
        }

        try {
            $order = DB::transaction(function () use ($cartItems, $validatedCustomerData, $cartToken) {
                // Recalculate Totals on Backend
                $subtotal = $cartItems->sum(fn($item) => $item->product->original_price * $item->quantity);
                $shipping = $subtotal > 200 ? 0 : 15;
                $tax = $subtotal * 0.08;
                $promoDiscount = 0; // Your promo logic here
                $grandTotal = $subtotal + $shipping + $tax - $promoDiscount;

                // Create the Order
                $order = Order::create([
                    'order_code' => 'SG' . strtoupper(Str::random(8)),
                    'status' => 'pending',
                    'first_name' => $validatedCustomerData['first_name'],
                    'last_name' => $validatedCustomerData['last_name'],
                    'email' => $validatedCustomerData['email'],
                    'phone' => $validatedCustomerData['phone'],
                    'secondary_phone' => $validatedCustomerData['secondary_phone'] ?? null,
                    'address' => $validatedCustomerData['address'],
                    'secondary_address' => $validatedCustomerData['secondary_address'] ?? null,
                    'city' => $validatedCustomerData['city'],
                    'special_mark' => $validatedCustomerData['special_mark'] ?? null,
                    'subtotal' => $subtotal,
                    'shipping_cost' => $shipping,
                    'tax_amount' => $tax,
                    'promo_code' => $validatedCustomerData['promo_code'] ?? null,
                    'promo_discount' => $promoDiscount,
                    'grand_total' => $grandTotal,
                ]);

                // Create Order Items
                foreach ($cartItems as $item) {
                    $order->items()->create([
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->en_name,
                        'product_image' => $item->product->image,
                        'price' => $item->product->original_price,
                        'quantity' => $item->quantity,
                        'color' => $item->product->color ?? null,
                        'size' => $item->product->size ?? null,
                    ]);
                }

                // Clear the cart
                CartItem::where('guest_cart_token', $cartToken)->delete();

                return $order;
            });

            return response()->json([
                'message' => 'Order placed successfully!',
                'order_code' => $order->order_code,
            ], 201);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to place order. Please try again.', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * Display the specified resource for the control panel.
     *
     * @param \App\Models\Order $order
     * @return \App\Http\Resources\OrderResource
     */
    public function show(Order $order)
    {
        // Eager load the items relationship to include all order items
        return new OrderResource($order->load('items'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Order $order
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $order)
    {
        // The onDelete('cascade') in the migration will handle deleting related order_items
        $order->delete();

        return response("", Response::HTTP_NO_CONTENT);
    }

    /**
     * Find and return a specific order for public tracking.
     */
    public function track(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'order_code' => 'required|string',
            'email' => 'required|email',
        ]);

        if ($validator->fails()) {
            return response()->json(['errors' => $validator->errors()], 422);
        }

        $validated = $validator->validated();

        try {
            $order = Order::where('order_code', $validated['order_code'])
                          ->where('email', $validated['email'])
                          ->firstOrFail();

            return new OrderResource($order->load('items'));

        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found or email does not match the order record.'], 404);
        }
    }


    /**
     * Update the status of a specific order.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Models\Order $order
     * @return \App\Http\Resources\OrderResource
     */
    public function updateStatus(Request $request, Order $order)
    {
        $validator = Validator::make($request->all(), [
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $order->status = $request->input('status');
        $order->save();

        return new OrderResource($order);
    }
}
