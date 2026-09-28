<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class InventoryController extends Controller
{
    /**
     * Inventory overview.
     */
    public function index(Request $request)
    {
        $query = Product::with([
            'category',
            'brand',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        if ($request->filled('stock')) {

            if ($request->stock === 'out') {
                $query->where('quantity', '<=', 0);
            }

            if ($request->stock === 'low') {
                $query->whereColumn(
                    'quantity',
                    '<=',
                    'minimum_stock'
                )->where('quantity', '>', 0);
            }

            if ($request->stock === 'in') {
                $query->whereColumn(
                    'quantity',
                    '>',
                    'minimum_stock'
                );
            }
        }

        $products = $query
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $totalProducts = Product::count();

        $outOfStock = Product::where(
            'quantity',
            '<=',
            0
        )->count();

        $lowStock = Product::whereColumn(
            'quantity',
            '<=',
            'minimum_stock'
        )
            ->where('quantity', '>', 0)
            ->count();

        $totalUnits = Product::sum('quantity');

        return view('inventory.index', compact(
            'products',
            'totalProducts',
            'outOfStock',
            'lowStock',
            'totalUnits'
        ));
    }

    /**
     * Show Stock In form.
     */
    public function stockIn()
    {
        $products = Product::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view(
            'inventory.stock-in',
            compact('products')
        );
    }

    /**
     * Store Stock In.
     */
    public function storeStockIn(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'exists:products,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:1',
            ],

            'unit_cost' => [
                'nullable',
                'numeric',
                'min:0',
            ],

            'reference' => [
                'nullable',
                'string',
                'max:255',
            ],

            'reason' => [
                'nullable',
                'string',
                'max:1000',
            ],
        ]);

        DB::transaction(function () use ($validated) {

            $product = Product::whereKey(
                $validated['product_id']
            )
                ->lockForUpdate()
                ->firstOrFail();

            $quantityBefore = $product->quantity;

            $quantityAfter =
                $quantityBefore +
                $validated['quantity'];

            $product->update([
                'quantity' => $quantityAfter,
            ]);

            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'stock_in',
                'quantity' => $validated['quantity'],
                'quantity_before' => $quantityBefore,
                'quantity_after' => $quantityAfter,
                'reference' => $validated['reference'] ?? null,
                'reason' => $validated['reason'] ?? null,
                'unit_cost' => $validated['unit_cost'] ?? null,
                'user_id' => auth()->id(),
            ]);
        });

        return redirect()
            ->route('inventory.index')
            ->with(
                'success',
                'Stock added successfully.'
            );
    }

    /**
     * Show Stock Adjustment form.
     */
    public function adjustment()
    {
        $products = Product::where('status', 'active')
            ->orderBy('name')
            ->get();

        return view(
            'inventory.adjustment',
            compact('products')
        );
    }

    /**
     * Store Stock Adjustment.
     */
    public function storeAdjustment(Request $request)
    {
        $validated = $request->validate([
            'product_id' => [
                'required',
                'exists:products,id',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'reference' => [
                'nullable',
                'string',
                'max:255',
            ],

            'reason' => [
                'required',
                'string',
                'max:1000',
            ],
        ]);

        DB::transaction(function () use ($validated) {

            $product = Product::whereKey(
                $validated['product_id']
            )
                ->lockForUpdate()
                ->firstOrFail();

            $quantityBefore = $product->quantity;

            $quantityAfter = $validated['quantity'];

            $product->update([
                'quantity' => $quantityAfter,
            ]);

            StockMovement::create([
                'product_id' => $product->id,
                'type' => 'adjustment',

                // Difference between old and new stock.
                'quantity' =>
                    $quantityAfter -
                    $quantityBefore,

                'quantity_before' => $quantityBefore,

                'quantity_after' => $quantityAfter,

                'reference' =>
                    $validated['reference'] ?? null,

                'reason' => $validated['reason'],

                'unit_cost' => null,

                'user_id' => auth()->id(),
            ]);
        });

        return redirect()
            ->route('inventory.index')
            ->with(
                'success',
                'Stock adjusted successfully.'
            );
    }

    /**
     * Stock movement history.
     */
    public function movements(Request $request)
    {
        $query = StockMovement::with([
            'product',
            'user',
        ]);

        if ($request->filled('search')) {
            $search = $request->search;

            $query->whereHas(
                'product',
                function ($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                        ->orWhere('sku', 'like', "%{$search}%");
                }
            );
        }

        if ($request->filled('type')) {
            $query->where(
                'type',
                $request->type
            );
        }

        $movements = $query
            ->latest()
            ->paginate(20)
            ->withQueryString();

        return view(
            'inventory.movements',
            compact('movements')
        );



        
    }


    /**
 * Show Stock Out form.
 */
public function stockOut()
{
    $products = Product::where('status', 'active')
        ->where('quantity', '>', 0)
        ->orderBy('name')
        ->get();

    return view(
        'inventory.stock-out',
        compact('products')
    );
}


/**
 * Store Stock Out.
 */
public function storeStockOut(Request $request)
{
    $validated = $request->validate([
        'product_id' => [
            'required',
            'exists:products,id',
        ],

        'quantity' => [
            'required',
            'integer',
            'min:1',
        ],

        'reference' => [
            'nullable',
            'string',
            'max:255',
        ],

        'reason' => [
            'nullable',
            'string',
            'max:1000',
        ],
    ]);

    DB::transaction(function () use ($validated) {

        /*
         * Lock this product row while updating stock.
         *
         * This prevents two users from changing
         * the same stock at exactly the same time.
         */
        $product = Product::whereKey(
            $validated['product_id']
        )
            ->lockForUpdate()
            ->firstOrFail();

        $quantityBefore = $product->quantity;

        /*
         * Never allow stock to become negative.
         */
        if ($validated['quantity'] > $quantityBefore) {

            throw \Illuminate\Validation\ValidationException::withMessages([
                'quantity' => [
                    "Insufficient stock. Available stock is {$quantityBefore}."
                ],
            ]);
        }

        $quantityAfter =
            $quantityBefore -
            $validated['quantity'];

        /*
         * Update product stock.
         */
        $product->update([
            'quantity' => $quantityAfter,
        ]);

        /*
         * Create stock movement history.
         */
        StockMovement::create([
            'product_id' => $product->id,

            'type' => 'stock_out',

            'quantity' => $validated['quantity'],

            'quantity_before' => $quantityBefore,

            'quantity_after' => $quantityAfter,

            'reference' =>
                $validated['reference'] ?? null,

            'reason' =>
                $validated['reason'] ?? 'Stock Out',

            'unit_cost' => null,

            'user_id' => auth()->id(),
        ]);
    });

    return redirect()
        ->route('inventory.index')
        ->with(
            'success',
            'Stock removed successfully.'
        );
}
}
