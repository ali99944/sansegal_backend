<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StatisticsController extends Controller
{
    /**
     * Provides the main Key Performance Indicators (KPIs) for the statistics page.
     */
    public function kpis()
    {
        $deliveredOrders = Order::where('status', 'delivered');

        $totalRevenue = (float) $deliveredOrders->sum('grand_total');
        $totalOrderCount = $deliveredOrders->count();

        $totalProductsSold = (int) OrderItem::whereHas('order', function ($query) {
            $query->where('status', 'delivered');
        })->sum('quantity');

        $averageOrderValue = $totalOrderCount > 0 ? $totalRevenue / $totalOrderCount : 0;

        return response()->json([
            'totalRevenue' => round($totalRevenue, 2),
            'totalOrders' => $totalOrderCount,
            'totalProductsSold' => $totalProductsSold,
            'averageOrderValue' => round($averageOrderValue, 2),
        ]);
    }

    /**
     * Provides data for the top-selling products chart.
     */
    public function topProducts(Request $request)
    {
        $limit = $request->query('limit', 5);

        $products = OrderItem::query()
            ->select('product_name', DB::raw('SUM(quantity) as total_sold'))
            ->join('orders', 'order_items.order_id', '=', 'orders.id')
            ->where('orders.status', 'delivered')
            ->groupBy('product_name')
            ->orderByDesc('total_sold')
            ->limit($limit)
            ->get();

        return response()->json($products);
    }

    /**
     * Provides data for the sales by city chart.
     */
    public function salesByCity(Request $request)
    {
        $limit = $request->query('limit', 6);

        $cities = Order::query()
            ->select('city', DB::raw('COUNT(id) as order_count'))
            ->where('status', 'delivered')
            ->groupBy('city')
            ->orderByDesc('order_count')
            ->limit($limit)
            ->get();

        return response()->json($cities);
    }
}
