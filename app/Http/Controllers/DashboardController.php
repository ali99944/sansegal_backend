<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class DashboardController extends Controller
{
    /**
     * Fetch Key Performance Indicators (KPIs) for the main dashboard view.
     */
    public function kpis()
    {
        // Calculate total revenue from successfully delivered orders
        $totalRevenue = Order::where('status', 'delivered')->sum('grand_total');

        // Count new orders placed today
        $newOrdersToday = Order::whereDate('created_at', Carbon::today())->count();

        // Count unread contact messages
        $pendingMessages = ContactMessage::whereNull('read_at')->count();

        // Count total products in the catalog
        $totalProducts = Product::count();

        return response()->json([
            'totalRevenue' => (float) $totalRevenue,
            'newOrdersToday' => $newOrdersToday,
            'pendingMessages' => $pendingMessages,
            'totalProducts' => $totalProducts,
        ]);
    }

    /**
     * Fetch the 5 most recent orders to display on the dashboard.
     */
    public function recentOrders()
    {
        $orders = Order::latest() // Orders by the newest first
            ->take(5) // Limit to 5 results
            ->get(['id', 'order_code', 'first_name', 'last_name', 'grand_total', 'status', 'created_at']);

        // Map the results to match the 'RecentOrder' type on the frontend
        $formattedOrders = $orders->map(function ($order) {
            return [
                'id' => $order->id,
                'order_code' => $order->order_code,
                'customer_name' => $order->first_name . ' ' . $order->last_name,
                'grand_total' => (float) $order->grand_total,
                'status' => $order->status,
                'created_at' => $order->created_at->toDateTimeString(),
            ];
        });

        return response()->json($formattedOrders);
    }

    /**
     * Fetch the top 5 best-selling products.
     */
    public function topProducts()
    {
        $topProductsData = OrderItem::query()
            ->select('product_id', DB::raw('SUM(quantity) as sales_count'))
            // Eager load the product details we need, improving performance
            ->with('product:id,en_name,image')
            ->groupBy('product_id')
            ->orderByRaw('sales_count DESC')
            ->take(5)
            ->get();

        // Map the results to match the 'TopProduct' type
        $formattedProducts = $topProductsData->map(function ($item) {
            if (!$item->product) return null; // Skip if product has been deleted
            return [
                'id' => $item->product->id,
                'name' => $item->product->en_name, // Using English name as an example
                'image' => $item->product->image,
                'sales_count' => (int) $item->sales_count,
            ];
        })->filter(); // filter() removes any null values

        return response()->json($formattedProducts);
    }

    /**
     * Fetch sales data for a chart over a specified time range.
     */
    public function salesOverTime(Request $request)
    {
        $range = $request->query('range', '30d'); // Default to 30 days

        $days = (int) filter_var($range, FILTER_SANITIZE_NUMBER_INT);
        $startDate = Carbon::now()->subDays($days)->startOfDay();

        $sales = Order::query()
            ->select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(grand_total) as revenue')
            )
            ->where('created_at', '>=', $startDate)
            // It's often best to only count revenue from completed orders
            ->whereIn('status', ['shipped', 'delivered'])
            ->groupBy('date')
            ->orderBy('date', 'asc')
            ->get();

        return response()->json($sales);
    }
}
