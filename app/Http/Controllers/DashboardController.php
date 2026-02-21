<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Item;
use App\Models\Order;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Summary counts
        $totalCategories = Category::count();
        $totalItems = Item::count();
        $totalUsers = User::count();
        $totalOrders = Order::count();

        // Revenue (settled orders only)
        $totalRevenue = Order::where('status', 'settlement')->sum('grand_total');
        $todayRevenue = Order::where('status', 'settlement')
            ->whereDate('created_at', today())
            ->sum('grand_total');

        // Orders by status
        $pendingOrders = Order::where('status', 'pending')->count();
        $cookedOrders = Order::where('status', 'cooked')->count();
        $settledOrders = Order::where('status', 'settlement')->count();

        // Recent orders (latest 5)
        $recentOrders = Order::with('user')
            ->latest()
            ->take(5)
            ->get();

        // Top selling items (by order item count)
        $topItems = Item::withCount('orderItems')
            ->orderByDesc('order_items_count')
            ->take(5)
            ->get();

        // Monthly revenue for chart (last 6 months)
        $monthlyRevenue = Order::where('status', 'settlement')
            ->where('created_at', '>=', now()->subMonths(6)->startOfMonth())
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, SUM(grand_total) as total')
            ->groupByRaw('YEAR(created_at), MONTH(created_at)')
            ->orderByRaw('YEAR(created_at), MONTH(created_at)')
            ->get();

        return view('admin.dashboard', compact(
            'totalCategories',
            'totalItems',
            'totalUsers',
            'totalOrders',
            'totalRevenue',
            'todayRevenue',
            'pendingOrders',
            'cookedOrders',
            'settledOrders',
            'recentOrders',
            'topItems',
            'monthlyRevenue',
        ));
    }

    public function create()
    {
        return redirect()->route('dashboard.index');
    }
    public function store(Request $request)
    {
        return redirect()->route('dashboard.index');
    }
    public function show(string $id)
    {
        return redirect()->route('dashboard.index');
    }
    public function edit(string $id)
    {
        return redirect()->route('dashboard.index');
    }
    public function update(Request $request, string $id)
    {
        return redirect()->route('dashboard.index');
    }
    public function destroy(string $id)
    {
        return redirect()->route('dashboard.index');
    }
}

