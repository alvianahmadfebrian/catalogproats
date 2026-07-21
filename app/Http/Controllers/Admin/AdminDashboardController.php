<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $lowStockCount = Product::where('stock', '<', 15)->count();

        // Real order data from database
        $totalOrders = Order::where('status', 'completed')->count();
        $totalRevenue = Order::where('status', 'completed')->sum('total_price');
        $totalItemsSold = Order::where('status', 'completed')->sum('quantity');
        $pendingOrders = Order::where('status', 'pending')->count();

        // Monthly sales from orders table (grouped by month - driver compatible for SQLite & MySQL)
        $driver = DB::getDriverName();
        $monthExpr = $driver === 'sqlite' ? "strftime('%m', created_at)" : "DATE_FORMAT(created_at, '%m')";

        $monthlySales = Order::where('status', 'completed')
            ->selectRaw("{$monthExpr} as month_num, COUNT(*) as total_orders, SUM(quantity) as total_qty, SUM(total_price) as total_revenue")
            ->groupByRaw($monthExpr)
            ->orderByRaw($monthExpr)
            ->get()
            ->map(function ($row) {
                $monthNum = str_pad($row->month_num, 2, '0', STR_PAD_LEFT);
                $monthNames = ['01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'Mei','06'=>'Jun','07'=>'Jul','08'=>'Agu','09'=>'Sep','10'=>'Okt','11'=>'Nov','12'=>'Des'];
                return [
                    'month' => $monthNames[$monthNum] ?? $monthNum,
                    'orders' => (int) $row->total_orders,
                    'qty' => (int) $row->total_qty,
                    'revenue' => (float) $row->total_revenue,
                ];
            });

        // Category sales from orders table (joined with products)
        $categoryStats = Category::withCount('products')
            ->get()
            ->map(function ($cat) {
                $catSold = Order::where('status', 'completed')
                    ->whereHas('product', fn($q) => $q->where('category_id', $cat->id))
                    ->sum('quantity');
                $catRevenue = Order::where('status', 'completed')
                    ->whereHas('product', fn($q) => $q->where('category_id', $cat->id))
                    ->sum('total_price');
                $cat->total_sold = $catSold;
                $cat->total_revenue = $catRevenue;
                return $cat;
            });

        // Top selling products by real order quantity
        $topProducts = Product::select('products.*')
            ->selectRaw("(SELECT COALESCE(SUM(orders.quantity),0) FROM orders WHERE orders.product_id = products.id AND orders.status = 'completed') as real_sold")
            ->orderByDesc('real_sold')
            ->take(5)
            ->get();

        $recentProducts = Product::with('category')->latest()->take(5)->get();

        // Recent orders
        $recentOrders = Order::with('product')->latest()->take(5)->get();

        return view('admin.dashboard', compact(
            'totalProducts',
            'totalCategories',
            'lowStockCount',
            'totalOrders',
            'totalRevenue',
            'totalItemsSold',
            'pendingOrders',
            'monthlySales',
            'categoryStats',
            'topProducts',
            'recentProducts',
            'recentOrders'
        ));
    }
}
