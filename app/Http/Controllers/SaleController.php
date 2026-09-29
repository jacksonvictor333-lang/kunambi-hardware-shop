<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use App\Models\SaleItem;
use App\Models\StockMovement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class SaleController extends Controller
{
    /**
     * POS PAGE
     */
    public function index()
    {
        $products = Product::where('status', 'active')
            ->where('quantity', '>', 0)
            ->orderBy('name')
            ->get();

        $customers = Customer::orderBy('name')->get();

        $invoiceNumber = $this->generateInvoiceNumber();

        return view('sales.pos', compact('products', 'customers', 'invoiceNumber'));
    }


    /**
     * STORE NEW SALE
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'invoice_number' => ['nullable', 'string', 'regex:/^INV-\d{8}-[A-Z0-9]{6}$/'],

            'customer_id' => [
                'nullable',
                function ($attribute, $value, $fail) {
                    if (
                        !empty($value) &&
                        $value !== 'walk-in' &&
                        !Customer::whereKey($value)->exists()
                    ) {
                        $fail('The selected customer is invalid.');
                    }
                },
            ],

            'discount' => ['nullable', 'numeric', 'min:0'],

            'payment_method' => ['required', 'in:cash,mobile_money,bank,credit'],

            'paid_amount' => ['nullable', 'numeric', 'min:0'],

            'items' => ['required', 'array', 'min:1'],

            'items.*.product_id' => ['required', 'integer', 'exists:products,id'],

            'items.*.quantity' => ['required', 'integer', 'min:1'],
        ]);

        $customerId = (!empty($validated['customer_id']) && $validated['customer_id'] !== 'walk-in')
            ? (int) $validated['customer_id']
            : null;

        $discount         = (float) ($validated['discount'] ?? 0);
        $paidAmount       = (float) ($validated['paid_amount'] ?? 0);
        $paymentMethod    = $validated['payment_method'];
        $requestedInvoice = $validated['invoice_number'] ?? null;

        // Combine duplicate product lines so stock is checked against the real total.
        $requested = collect($validated['items'])
            ->groupBy('product_id')
            ->map(fn ($rows) => (int) $rows->sum('quantity'));

        try {

            $sale = DB::transaction(function () use (
                $requested,
                $customerId,
                $discount,
                $paidAmount,
                $paymentMethod,
                $requestedInvoice
            ) {

                // Lock every product involved in this sale.
                $products = Product::whereIn('id', $requested->keys())
                    ->lockForUpdate()
                    ->get()
                    ->keyBy('id');

                $subtotal  = 0;
                $cartItems = [];

                foreach ($requested as $productId => $quantity) {

                    $product = $products->get($productId);

                    if (!$product) {
                        throw new \RuntimeException('One of the selected products no longer exists.');
                    }

                    if ($product->status !== 'active') {
                        throw new \RuntimeException("Product \"{$product->name}\" is inactive and cannot be sold.");
                    }

                    if ($product->quantity < $quantity) {
                        throw new \RuntimeException(
                            "Insufficient stock for {$product->name}. Available: {$product->quantity}, requested: {$quantity}."
                        );
                    }

                    // Always use the price stored in the database.
                    $unitPrice = (float) $product->selling_price;
                    $itemTotal = $unitPrice * $quantity;

                    $subtotal += $itemTotal;

                    $cartItems[] = [
                        'product'    => $product,
                        'quantity'   => $quantity,
                        'unit_price' => $unitPrice,
                        'total'      => $itemTotal,
                    ];
                }

                // Discount can never exceed the subtotal.
                $discount    = min($discount, $subtotal);
                $totalAmount = max(0, $subtotal - $discount);

                if ($totalAmount <= 0) {
                    throw new \RuntimeException('Sale total must be greater than zero.');
                }

                $balanceAmount = 0;

                if ($paymentMethod === 'credit') {

                    if (!$customerId) {
                        throw new \RuntimeException('Select a customer for credit sales.');
                    }

                    $balanceAmount = max(0, $totalAmount - $paidAmount);

                } else {

                    if ($paidAmount < $totalAmount) {
                        throw new \RuntimeException('Paid amount is less than the sale total.');
                    }
                }

                // Tumia namba iliyoonekana kwenye POS kama bado ni huru,
                // vinginevyo tengeneza mpya.
                $invoiceNumber = ($requestedInvoice && !Sale::where('invoice_number', $requestedInvoice)->exists())
                    ? $requestedInvoice
                    : $this->generateInvoiceNumber();

                $sale = Sale::create([
                    'invoice_number' => $invoiceNumber,
                    'customer_id'    => $customerId,
                    'user_id'        => auth()->id(),
                    'subtotal'       => $subtotal,
                    'discount'       => $discount,
                    'total'          => $totalAmount,   // column halisi: "total"
                    'paid_amount'    => $paidAmount,
                    'balance'        => $balanceAmount, // column halisi: "balance"
                    'payment_method' => $paymentMethod,
                    'status'         => $balanceAmount > 0 ? 'pending' : 'completed',
                ]);

                foreach ($cartItems as $cartItem) {

                    $product  = $cartItem['product'];
                    $quantity = $cartItem['quantity'];

                    SaleItem::create([
                        'sale_id'    => $sale->id,
                        'product_id' => $product->id,
                        'quantity'   => $quantity,
                        'unit_price' => $cartItem['unit_price'],
                        'subtotal'   => $cartItem['total'],
                    ]);

                    $quantityBefore = $product->quantity;
                    $quantityAfter  = $quantityBefore - $quantity;

                    $product->update(['quantity' => $quantityAfter]);

                    StockMovement::create([
                        'product_id'      => $product->id,
                        'type'            => 'stock_out',
                        'quantity'        => $quantity,
                        'quantity_before' => $quantityBefore,
                        'quantity_after'  => $quantityAfter,
                        'reference'       => $sale->invoice_number,
                        'reason'          => 'Sale ' . $sale->invoice_number,
                        'unit_cost'       => null,
                        'user_id'         => auth()->id(),
                    ]);
                }

                return $sale;
            });

            return redirect()
                ->route('sales.receipt', $sale)
                ->with('success', "Sale {$sale->invoice_number} completed successfully.");

        } catch (\RuntimeException $e) {

            return back()
                ->withInput()
                ->withErrors(['sale' => $e->getMessage()]);

        } catch (\Throwable $e) {

            report($e);

            return back()
                ->withInput()
                ->withErrors(['sale' => 'Something went wrong while saving the sale. Please try again.']);
        }
    }


    /**
     * SALES LIST
     */
    public function history(Request $request)
    {
        $search = $request->input('search');

        $sales = Sale::with(['customer', 'user'])
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('invoice_number', 'like', "%{$search}%")
                        ->orWhereHas('customer', function ($customerQuery) use ($search) {
                            $customerQuery
                                ->where('name', 'like', "%{$search}%")
                                ->orWhere('phone', 'like', "%{$search}%");
                        });
                });
            })
            ->latest()
            ->paginate(15)
            ->withQueryString();

        return view('sales.history', compact('sales', 'search'));
    }


    /**
     * SHOW SALE
     */
    public function show(Sale $sale)
    {
        $sale->load(['customer', 'user', 'items.product']);

        return view('sales.show', compact('sale'));
    }


    /**
     * RECEIPT
     */
    public function receipt(Sale $sale)
    {
        $sale->load(['customer', 'user', 'items.product']);

        return view('sales.receipt', compact('sale'));
    }


    /**
     * DELETE / VOID SALE
     */
    public function destroy(Sale $sale)
    {
        try {

            DB::transaction(function () use ($sale) {

                $sale->load('items');

                foreach ($sale->items as $item) {

                    $product = Product::whereKey($item->product_id)
                        ->lockForUpdate()
                        ->first();

                    if (!$product) {
                        continue;
                    }

                    $quantityBefore = $product->quantity;
                    $quantityAfter  = $quantityBefore + $item->quantity;

                    $product->update(['quantity' => $quantityAfter]);

                    StockMovement::create([
                        'product_id'      => $product->id,
                        'type'            => 'stock_in',
                        'quantity'        => $item->quantity,
                        'quantity_before' => $quantityBefore,
                        'quantity_after'  => $quantityAfter,
                        'reference'       => 'VOID-' . $sale->invoice_number,
                        'reason'          => 'Sale voided: ' . $sale->invoice_number,
                        'unit_cost'       => null,
                        'user_id'         => auth()->id(),
                    ]);
                }

                $sale->items()->delete();
                $sale->delete();
            });

            return redirect()
                ->route('sales.history')
                ->with('success', 'Sale deleted and stock restored successfully.');

        } catch (\Throwable $e) {

            report($e);

            return back()->withErrors([
                'sale' => 'Could not delete the sale. Please try again.',
            ]);
        }
    }


    /**
     * GENERATE UNIQUE INVOICE NUMBER
     */
    private function generateInvoiceNumber(): string
    {
        do {
            $invoiceNumber = 'INV-' . now()->format('Ymd') . '-' . strtoupper(Str::random(6));
        } while (Sale::where('invoice_number', $invoiceNumber)->exists());

        return $invoiceNumber;
    }
}
