<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;

class DashboardController extends Controller
{
    /**
     * Display the Hardware Shop Dashboard.
     */
    public function index()
    {
        /*
        |--------------------------------------------------------------------------
        | Product Statistics
        |--------------------------------------------------------------------------
        */

        // Total products
        $totalProducts = Product::count();

        // Active products
        $activeProducts = Product::where('status', 'active')->count();

        // Inactive products
        $inactiveProducts = Product::where('status', 'inactive')->count();

        // Total quantity available in stock
        $totalStock = Product::sum('quantity');

        // Low stock products
        $lowStockProducts = Product::whereColumn(
            'quantity',
            '<=',
            'minimum_stock'
        )
        ->where('quantity', '>', 0)
        ->count();

        // Out of stock products
        $outOfStockProducts = Product::where(
            'quantity',
            '<=',
            0
        )->count();


        /*
        |--------------------------------------------------------------------------
        | Customer Statistics
        |--------------------------------------------------------------------------
        */

        $totalCustomers = Customer::count();


        /*
        |--------------------------------------------------------------------------
        | Sales Statistics
        |--------------------------------------------------------------------------
        */

        // Total number of sales
        $totalSales = Sale::count();

        // Total revenue
        // Database column is "total"
        $totalRevenue = Sale::sum('total');

        // Total amount paid
        $totalPaid = Sale::sum('paid_amount');

        // Total outstanding balance
        // Database column is "balance"
        $totalBalance = Sale::sum('balance');

        // Total discount given
        $totalDiscount = Sale::sum('discount');


        /*
        |--------------------------------------------------------------------------
        | Today's Sales
        |--------------------------------------------------------------------------
        */

        $todaySales = Sale::whereDate(
            'created_at',
            today()
        )->count();

        // Today's revenue
        $todayRevenue = Sale::whereDate(
            'created_at',
            today()
        )->sum('total');


        /*
        |--------------------------------------------------------------------------
        | This Month's Sales
        |--------------------------------------------------------------------------
        */

        $monthlySales = Sale::whereMonth(
            'created_at',
            now()->month
        )
        ->whereYear(
            'created_at',
            now()->year
        )
        ->count();

        // This month's revenue
        $monthlyRevenue = Sale::whereMonth(
            'created_at',
            now()->month
        )
        ->whereYear(
            'created_at',
            now()->year
        )
        ->sum('total');


        /*
        |--------------------------------------------------------------------------
        | Recent Sales
        |--------------------------------------------------------------------------
        */

        $recentSales = Sale::with([
            'customer',
            'user'
        ])
        ->latest()
        ->take(5)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | Recent Products
        |--------------------------------------------------------------------------
        */

        $recentProducts = Product::latest()
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Low Stock Product List
        |--------------------------------------------------------------------------
        */

        $lowStockList = Product::whereColumn(
            'quantity',
            '<=',
            'minimum_stock'
        )
        ->orderBy('quantity')
        ->take(5)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | Out of Stock Product List
        |--------------------------------------------------------------------------
        */

        $outOfStockList = Product::where(
            'quantity',
            '<=',
            0
        )
        ->orderBy('name')
        ->take(5)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | Top Products
        |--------------------------------------------------------------------------
        */

        $topProducts = Product::orderByDesc(
            'quantity'
        )
        ->take(5)
        ->get();


        /*
        |--------------------------------------------------------------------------
        | Sales by Payment Method
        |--------------------------------------------------------------------------
        */

        $cashSales = Sale::where(
            'payment_method',
            'cash'
        )->sum('total');

        $mobileMoneySales = Sale::where(
            'payment_method',
            'mobile_money'
        )->sum('total');

        $bankSales = Sale::where(
            'payment_method',
            'bank'
        )->sum('total');

        $creditSales = Sale::where(
            'payment_method',
            'credit'
        )->sum('total');


        /*
        |--------------------------------------------------------------------------
        | Sales Chart - Last 7 Days
        |--------------------------------------------------------------------------
        */

        $salesChart = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = now()->subDays($i);

            $salesChart[] = [
                'date' => $date->format('M d'),

                'sales' => Sale::whereDate(
                    'created_at',
                    $date->toDateString()
                )->count(),

                'revenue' => Sale::whereDate(
                    'created_at',
                    $date->toDateString()
                )->sum('total'),
            ];
        }


        /*
        |--------------------------------------------------------------------------
        | Dashboard View
        |--------------------------------------------------------------------------
        */

        return view('dashboard', compact(

            // Products
            'totalProducts',
            'activeProducts',
            'inactiveProducts',
            'totalStock',
            'lowStockProducts',
            'outOfStockProducts',

            // Customers
            'totalCustomers',

            // Sales
            'totalSales',
            'totalRevenue',
            'totalPaid',
            'totalBalance',
            'totalDiscount',

            // Today
            'todaySales',
            'todayRevenue',

            // Month
            'monthlySales',
            'monthlyRevenue',

            // Lists
            'recentSales',
            'recentProducts',
            'lowStockList',
            'outOfStockList',
            'topProducts',

            // Payment methods
            'cashSales',
            'mobileMoneySales',
            'bankSales',
            'creditSales',

            // Chart
            'salesChart'
        ));
    }
}
