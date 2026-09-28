<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Product;
use App\Models\Customer;

class ReportController extends Controller
{
    public function index()
    {
        $totalSales = Sale::sum('total_amount');

        $totalProducts = Product::count();

        $totalCustomers = Customer::count();

        return view('reports.index', compact(
            'totalSales',
            'totalProducts',
            'totalCustomers'
        ));
    }
}