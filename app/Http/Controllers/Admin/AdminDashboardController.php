<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Order;
use App\Models\Product;
use App\Models\User;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalOrders = Order::count();
        $totalRevenue = Order::where('status', '!=', 'cancelled')->sum('total');
        $totalUsers = User::count();

        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        $topProducts = Product::select('products.*', DB::raw('SUM(order_items.quantity) as total_sold'))
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        $lowStockCount = Product::where('stock', '<', 10)->count();
        $pendingOrdersCount = Order::where('status', 'pending')->count();
        $categoryCount = Category::count();

        // 7-day revenue data
        $dailyRevenueData = [];
        $dailyRevenueLabels = [];
        $dayNames = ['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu', 'Minggu'];
        
        for ($i = 6; $i >= 0; $i--) {
            $date = now()->subDays($i)->toDateString();
            $dayIndex = now()->subDays($i)->dayOfWeek;
            // Convert to 1-7 (Monday-Sunday) for day name indexing
            $dayIndex = $dayIndex === 0 ? 6 : $dayIndex - 1;
            
            $dailyRevenueLabels[] = $dayNames[$dayIndex];
            
            $revenue = Order::where('status', '!=', 'cancelled')
                ->whereDate('created_at', $date)
                ->sum('total');
            
            $dailyRevenueData[] = (int)$revenue;
        }

        return view('admin.dashboard', compact(
            'totalProducts', 'totalOrders', 'totalRevenue', 'totalUsers',
            'recentOrders', 'topProducts', 'dailyRevenueLabels', 'dailyRevenueData',
            'lowStockCount', 'pendingOrdersCount', 'categoryCount'
        ));
    }
}
