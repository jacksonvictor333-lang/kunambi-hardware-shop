<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        $filter = $request->get('filter', 'month');

        $today = Carbon::today();

        switch ($filter) {

            case 'today':
                $from = $today->copy()->startOfDay();
                $to = $today->copy()->endOfDay();
                break;

            case 'week':
                $from = $today->copy()->startOfWeek();
                $to = $today->copy()->endOfWeek();
                break;

            case 'last_month':
                $from = $today->copy()
                    ->subMonth()
                    ->startOfMonth();

                $to = $today->copy()
                    ->subMonth()
                    ->endOfMonth();
                break;

            case 'year':
                $from = $today->copy()->startOfYear();
                $to = $today->copy()->endOfYear();
                break;

            case 'custom':

                $from = $request->filled('from')
                    ? Carbon::parse($request->from)->startOfDay()
                    : $today->copy()->startOfMonth();

                $to = $request->filled('to')
                    ? Carbon::parse($request->to)->endOfDay()
                    : $today->copy()->endOfDay();

                break;

            case 'month':
            default:
                $from = $today->copy()->startOfMonth();
                $to = $today->copy()->endOfMonth();
                break;
        }

        $salesQuery = Sale::query()
            ->whereBetween('created_at', [$from, $to]);

        if ($request->filled('payment_method')) {
            $salesQuery->where(
                'payment_method',
                $request->payment_method
            );
        }

        $totalSales = (clone $salesQuery)->sum('total');

        $numberOfSales = (clone $salesQuery)->count();

        $averageSale = $numberOfSales > 0
            ? $totalSales / $numberOfSales
            : 0;

        $totalPaid = (clone $salesQuery)->sum('paid_amount');

        $totalBalance = (clone $salesQuery)->sum('balance');

        $totalDiscount = (clone $salesQuery)->sum('discount');

        $totalProducts = Product::count();

        $totalCustomers = Customer::count();

        $paymentBreakdown = (clone $salesQuery)
            ->select(
                'payment_method',
                DB::raw('COUNT(*) as sales_count'),
                DB::raw('SUM(total) as total_amount')
            )
            ->groupBy('payment_method')
            ->orderByDesc('total_amount')
            ->get();

        $dailySales = (clone $salesQuery)
            ->select(
                DB::raw('DATE(created_at) as sale_date'),
                DB::raw('SUM(total) as total_amount'),
                DB::raw('COUNT(*) as sales_count')
            )
            ->groupBy(DB::raw('DATE(created_at)'))
            ->orderBy('sale_date')
            ->get();

        $topProducts = DB::table('sale_items')
            ->join(
                'sales',
                'sales.id',
                '=',
                'sale_items.sale_id'
            )
            ->join(
                'products',
                'products.id',
                '=',
                'sale_items.product_id'
            )
            ->whereBetween(
                'sales.created_at',
                [$from, $to]
            )
            ->select(
                'products.id',
                'products.name',
                'products.sku',
                DB::raw(
                    'SUM(sale_items.quantity) as quantity_sold'
                ),
                DB::raw(
                    'SUM(sale_items.subtotal) as sales_amount'
                )
            )
            ->groupBy(
                'products.id',
                'products.name',
                'products.sku'
            )
            ->orderByDesc('quantity_sold')
            ->limit(10)
            ->get();

        $recentSales = (clone $salesQuery)
            ->with([
                'customer',
                'user'
            ])
            ->latest()
            ->limit(10)
            ->get();

        return view(
            'reports.index',
            compact(
                'filter',
                'from',
                'to',
                'totalSales',
                'numberOfSales',
                'averageSale',
                'totalPaid',
                'totalBalance',
                'totalDiscount',
                'totalProducts',
                'totalCustomers',
                'paymentBreakdown',
                'dailySales',
                'topProducts',
                'recentSales'
            )
        );
    }

    public function exportCsv(Request $request): StreamedResponse
    {
        $filter = $request->get('filter', 'month');

        $today = Carbon::today();

        switch ($filter) {

            case 'today':
                $from = $today->copy()->startOfDay();
                $to = $today->copy()->endOfDay();
                break;

            case 'week':
                $from = $today->copy()->startOfWeek();
                $to = $today->copy()->endOfWeek();
                break;

            case 'last_month':
                $from = $today->copy()
                    ->subMonth()
                    ->startOfMonth();

                $to = $today->copy()
                    ->subMonth()
                    ->endOfMonth();
                break;

            case 'year':
                $from = $today->copy()->startOfYear();
                $to = $today->copy()->endOfYear();
                break;

            case 'custom':

                $from = $request->filled('from')
                    ? Carbon::parse($request->from)->startOfDay()
                    : $today->copy()->startOfMonth();

                $to = $request->filled('to')
                    ? Carbon::parse($request->to)->endOfDay()
                    : $today->copy()->endOfDay();

                break;

            case 'month':
            default:
                $from = $today->copy()->startOfMonth();
                $to = $today->copy()->endOfMonth();
                break;
        }

        $query = Sale::query()
            ->with([
                'customer',
                'user'
            ])
            ->whereBetween(
                'created_at',
                [$from, $to]
            );

        if ($request->filled('payment_method')) {
            $query->where(
                'payment_method',
                $request->payment_method
            );
        }

        $sales = $query
            ->latest()
            ->get();

        $filename =
            'KUNAMBI-HARDWARE-SALES-' .
            now()->format('Y-m-d-H-i-s') .
            '.csv';

        return response()->streamDownload(
            function () use ($sales) {

                $handle = fopen(
                    'php://output',
                    'w'
                );

                fputcsv($handle, [
                    'Invoice Number',
                    'Date',
                    'Customer',
                    'Cashier',
                    'Payment Method',
                    'Subtotal',
                    'Discount',
                    'Total',
                    'Paid Amount',
                    'Balance',
                ]);

                foreach ($sales as $sale) {

                    $invoiceNumber =
                        $sale->invoice_number
                        ?? 'SALE-' .
                        str_pad(
                            $sale->id,
                            6,
                            '0',
                            STR_PAD_LEFT
                        );

                    $date = optional(
                        $sale->created_at
                    )->format('Y-m-d H:i');

                    $customerName =
                        optional(
                            $sale->customer
                        )->name
                        ?? 'Walk-in Customer';

                    $cashierName =
                        optional(
                            $sale->user
                        )->name
                        ?? 'System';

                    $paymentMethod =
                        ucwords(
                            str_replace(
                                '_',
                                ' ',
                                $sale->payment_method
                            )
                        );

                    fputcsv($handle, [
                        $invoiceNumber,
                        $date,
                        $customerName,
                        $cashierName,
                        $paymentMethod,
                        $sale->subtotal ?? 0,
                        $sale->discount ?? 0,
                        $sale->total ?? 0,
                        $sale->paid_amount ?? 0,
                        $sale->balance ?? 0,
                    ]);
                }

                fclose($handle);

            },
            $filename,
            [
                'Content-Type' =>
                    'text/csv; charset=UTF-8',
            ]
        );
    }
}
