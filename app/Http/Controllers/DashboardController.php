<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\SaleItem;

class DashboardController extends Controller
{
    /**
     * Kiwango cha "Low Stock" kinachotumika endapo bidhaa haina "minimum_stock" yake yenyewe.
     */
    private const DEFAULT_MIN_STOCK = 5;

    /**
     * Display the Hardware Shop Dashboard.
     */
    public function index()
    {
        $now            = now();
        $monthStart     = $now->copy()->startOfMonth();
        $lastMonthStart = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $lastMonthEnd   = $lastMonthStart->copy()->endOfMonth();

        /*
        |--------------------------------------------------------------------------
        | Product Statistics
        |--------------------------------------------------------------------------
        */

        $totalProducts    = Product::count();
        $activeProducts   = Product::where('status', 'active')->count();
        $inactiveProducts = Product::where('status', 'inactive')->count();
        $totalStock       = (int) Product::sum('quantity');

        // "Bidhaa hazina 'minimum_stock' yake" zinatumia kiwango cha kudumu (COALESCE),
        // vinginevyo zisingewahi kuonekana kwenye Low Stock hata kama stock yake ni ndogo.
        $lowStockBase = fn () => Product::where('quantity', '>', 0)
            ->whereRaw('quantity <= COALESCE(minimum_stock, ?)', [self::DEFAULT_MIN_STOCK]);

        $outOfStockBase = fn () => Product::where('quantity', '<=', 0);

        $lowStockProducts   = $lowStockBase()->count();
        $outOfStockProducts = $outOfStockBase()->count();


        /*
        |--------------------------------------------------------------------------
        | Customer Statistics
        |--------------------------------------------------------------------------
        */

        $totalCustomers = Customer::count();


        /*
        |--------------------------------------------------------------------------
        | Sales Statistics (query moja badala ya 9)
        |--------------------------------------------------------------------------
        */

        $agg = Sale::selectRaw(
            "COUNT(*) as total_sales,
             COALESCE(SUM(total), 0)        as total_revenue,
             COALESCE(SUM(paid_amount), 0)  as total_paid,
             COALESCE(SUM(balance), 0)      as total_balance,
             COALESCE(SUM(discount), 0)     as total_discount,
             COUNT(CASE WHEN DATE(created_at) = ? THEN 1 END) as today_sales,
             COALESCE(SUM(CASE WHEN DATE(created_at) = ? THEN total ELSE 0 END), 0) as today_revenue,
             COUNT(CASE WHEN created_at >= ? THEN 1 END) as monthly_sales,
             COALESCE(SUM(CASE WHEN created_at >= ? THEN total ELSE 0 END), 0) as monthly_revenue",
            [$now->toDateString(), $now->toDateString(), $monthStart, $monthStart]
        )->first();

        $totalSales     = (int) $agg->total_sales;
        $totalRevenue   = (float) $agg->total_revenue;
        $totalPaid      = (float) $agg->total_paid;
        $totalBalance   = (float) $agg->total_balance;
        $totalDiscount  = (float) $agg->total_discount;

        $todaySales     = (int) $agg->today_sales;
        $todayRevenue   = (float) $agg->today_revenue;

        $monthlySales   = (int) $agg->monthly_sales;
        $monthlyRevenue = (float) $agg->monthly_revenue;

        // Ziada: wastani wa mauzo, na ukuaji wa mapato dhidi ya mwezi uliopita.
        $averageSaleValue = $totalSales > 0 ? $totalRevenue / $totalSales : 0;

        $lastMonthRevenue = (float) Sale::whereBetween('created_at', [$lastMonthStart, $lastMonthEnd])->sum('total');
        $revenueGrowth    = $this->percentChange($monthlyRevenue, $lastMonthRevenue);


        /*
        |--------------------------------------------------------------------------
        | Recent Sales / Recent Products
        |--------------------------------------------------------------------------
        */

        $recentSales = Sale::with(['customer:id,name,phone', 'user:id,name'])
            ->latest()
            ->take(5)
            ->get();

        $recentProducts = Product::latest()->take(5)->get();


        /*
        |--------------------------------------------------------------------------
        | Low / Out of Stock Lists (kichujio kinafanana na namba hapo juu)
        |--------------------------------------------------------------------------
        */

        $lowStockList = $lowStockBase()
            ->select(['id', 'name', 'sku', 'quantity', 'minimum_stock', 'unit'])
            ->orderBy('quantity')
            ->orderBy('name')
            ->take(5)
            ->get();

        $outOfStockList = $outOfStockBase()
            ->select(['id', 'name', 'sku'])
            ->orderBy('name')
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Top Products kwa Stock (bidhaa zenye idadi kubwa zaidi ghalani)
        |--------------------------------------------------------------------------
        */

        $topProducts = Product::orderByDesc('quantity')->take(5)->get();


        /*
        |--------------------------------------------------------------------------
        | Best Selling Products (ziada: bidhaa zinazouzwa zaidi mwezi huu)
        |--------------------------------------------------------------------------
        */

        $bestSellingProducts = SaleItem::selectRaw('product_id, SUM(quantity) as qty_sold, SUM(subtotal) as revenue')
            ->whereHas('sale', fn ($q) => $q->where('created_at', '>=', $monthStart))
            ->groupBy('product_id')
            ->orderByDesc('qty_sold')
            ->with('product:id,name,unit')
            ->take(5)
            ->get();


        /*
        |--------------------------------------------------------------------------
        | Sales by Payment Method (query moja badala ya 4)
        |--------------------------------------------------------------------------
        */

        $payments = Sale::selectRaw('payment_method, SUM(total) as total')
            ->groupBy('payment_method')
            ->pluck('total', 'payment_method');

        $cashSales        = (float) ($payments['cash'] ?? 0);
        $mobileMoneySales = (float) ($payments['mobile_money'] ?? 0);
        $bankSales        = (float) ($payments['bank'] ?? 0);
        $creditSales      = (float) ($payments['credit'] ?? 0);


        /*
        |--------------------------------------------------------------------------
        | Sales Chart - Last 7 Days (query moja badala ya 14)
        |--------------------------------------------------------------------------
        */

        $chartStart = $now->copy()->subDays(6)->startOfDay();

        $rows = Sale::selectRaw('DATE(created_at) as d, COUNT(*) as cnt, SUM(total) as total')
            ->where('created_at', '>=', $chartStart)
            ->groupBy('d')
            ->get()
            ->keyBy('d');

        $salesChart = [];

        for ($i = 6; $i >= 0; $i--) {

            $date = $now->copy()->subDays($i);
            $key  = $date->toDateString();
            $row  = $rows->get($key);

            $salesChart[] = [
                'date'    => $date->format('M d'),
                'sales'   => (int) ($row->cnt ?? 0),
                'revenue' => (float) ($row->total ?? 0),
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
            'averageSaleValue',
            'revenueGrowth',

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
            'bestSellingProducts',

            // Payment methods
            'cashSales',
            'mobileMoneySales',
            'bankSales',
            'creditSales',

            // Chart
            'salesChart'
        ));
    }

    /**
     * Asilimia ya mabadiliko kati ya thamani mbili. Inarudisha null kama hapakuwa
     * na kitu cha kulinganisha (mwezi uliopita hakuna mauzo kabisa).
     */
    private function percentChange(float $current, float $previous): ?float
    {
        if ($previous <= 0) {
            return $current > 0 ? null : 0.0;
        }

        return round((($current - $previous) / $previous) * 100, 1);
    }
}