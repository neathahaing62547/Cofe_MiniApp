<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Customer;
use App\Models\Product;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();
        $totalCustomers = Customer::count();
        $orderCount = Cart::count();
        $revenue = (float) Cart::sum('total_price');
        $totalReports = 0;
        $lowStockProducts = Product::where('stock_quantity', '<=', 5)
            ->orderBy('stock_quantity', 'asc')
            ->take(5)
            ->get();
        $recentOrders = Cart::latest()->take(5)->get();
        $productSales = Cart::selectRaw('product_name, SUM(quantity) as total_quantity, SUM(total_price) as total_revenue')
            ->groupBy('product_name')
            ->orderByDesc('total_quantity')
            ->take(5)
            ->get();

        $chartLabels = $productSales->pluck('product_name')->toArray();
        $chartValues = array_map(static fn($value) => (int) $value, $productSales->pluck('total_quantity')->toArray());
        $chartRevenue = array_map(static fn($value) => (float) $value, $productSales->pluck('total_revenue')->toArray());

        if (empty($chartLabels)) {
            $fallbackProducts = Product::query()
                ->orderByDesc('stock_quantity')
                ->take(5)
                ->get();

            if ($fallbackProducts->isEmpty()) {
                $fallbackProducts = collect([
                    ['product_name' => 'Latte', 'stock_quantity' => 24, 'price' => 4.50],
                    ['product_name' => 'Americano', 'stock_quantity' => 18, 'price' => 3.50],
                    ['product_name' => 'Cappuccino', 'stock_quantity' => 15, 'price' => 5.00],
                    ['product_name' => 'Mocha', 'stock_quantity' => 12, 'price' => 5.50],
                ]);
            }

            $chartLabels = $fallbackProducts->pluck('product_name')->toArray();
            $chartValues = array_map(static fn($value) => (int) $value, $fallbackProducts->pluck('stock_quantity')->toArray());
            $chartRevenue = array_map(static fn($value) => (float) $value, $fallbackProducts->pluck('price')->toArray());
        }

        return view('dashboard.index', compact(
            'totalProducts',
            'totalCustomers',
            'orderCount',
            'revenue',
            'totalReports',
            'lowStockProducts',
            'recentOrders',
            'productSales',
            'chartLabels',
            'chartValues',
            'chartRevenue'
        ));
    }
}
