<?php
namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderTrackingController extends Controller
{
    /**
     * Store a new tracking event for an order.
     * This also updates the parent order's status.
     */
    public function store(Request $request, Order $order)
    {
        $validated = $request->validate([
            'status' => 'required|string|in:pending,processing,shipped,delivered,cancelled',
            'location' => 'nullable|string|max:255',
            'description' => 'required|string|max:1000',
        ]);

        DB::transaction(function () use ($order, $validated) {
            // 1. Create the new tracking history entry
            $order->trackingHistory()->create($validated);

            // 2. Update the parent order's main status to match
            $order->status = $validated['status'];
            $order->save();
        });

        // Return the updated order with its full tracking history
        return new \App\Http\Resources\OrderResource($order->load('items', 'trackingHistory'));
    }
}
