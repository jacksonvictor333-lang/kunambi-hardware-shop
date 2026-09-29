<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class ProductController extends Controller
{
    /**
     * Display a listing of products.
     */
    public function index(Request $request)
    {
        abort_unless(
            auth()->user()?->hasPermission('view-products'),
            403
        );

        $query = Product::with([
            'category',
            'brand',
        ]);

        // Search
        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('sku', 'like', "%{$search}%");
            });
        }

        // Category filter
        if ($request->filled('category')) {
            $query->where(
                'category_id',
                $request->category
            );
        }

        // Brand filter
        if ($request->filled('brand')) {
            $query->where(
                'brand_id',
                $request->brand
            );
        }

        // Stock filter
        if ($request->filled('stock')) {

            if ($request->stock === 'out') {
                $query->where(
                    'quantity',
                    '<=',
                    0
                );
            }

            if ($request->stock === 'low') {
                $query->whereColumn(
                    'quantity',
                    '<=',
                    'minimum_stock'
                )->where(
                    'quantity',
                    '>',
                    0
                );
            }

            if ($request->stock === 'in') {
                $query->whereColumn(
                    'quantity',
                    '>',
                    'minimum_stock'
                );
            }
        }

        // Status filter
        if ($request->filled('status')) {
            $query->where(
                'status',
                $request->status
            );
        }

        $products = $query
            ->latest()
            ->paginate(10)
            ->withQueryString();

        $categories = Category::where(
            'status',
            'active'
        )
            ->orderBy('name')
            ->get();

        $brands = Brand::where(
            'status',
            'active'
        )
            ->orderBy('name')
            ->get();

        return view(
            'products.index',
            compact(
                'products',
                'categories',
                'brands'
            )
        );
    }

    /**
     * Show the form for creating a new product.
     */
    public function create()
    {
        abort_unless(
            auth()->user()?->hasPermission('create-products'),
            403
        );

        $categories = Category::where(
            'status',
            'active'
        )
            ->orderBy('name')
            ->get();

        $brands = Brand::where(
            'status',
            'active'
        )
            ->orderBy('name')
            ->get();

        return view(
            'products.create',
            compact(
                'categories',
                'brands'
            )
        );
    }

    /**
     * Store a newly created product.
     */
    public function store(Request $request)
    {
        abort_unless(
            auth()->user()?->hasPermission('create-products'),
            403
        );

        $validated = $request->validate([
            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'brand_id' => [
                'nullable',
                'exists:brands,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'sku' => [
                'required',
                'string',
                'max:100',
                'unique:products,sku',
            ],

            'unit' => [
                'required',
                'string',
                'max:50',
            ],

            'buying_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'selling_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'minimum_stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ]);

        Product::create($validated);

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product added successfully.'
            );
    }

    /**
     * Display the specified product.
     */
    public function show(Product $product)
    {
        abort_unless(
            auth()->user()?->hasPermission('view-products'),
            403
        );

        $product->load([
            'category',
            'brand',
        ]);

        return view(
            'products.show',
            compact('product')
        );
    }

    /**
     * Show the form for editing the specified product.
     */
    public function edit(Product $product)
    {
        abort_unless(
            auth()->user()?->hasPermission('edit-products'),
            403
        );

        $categories = Category::where(
            'status',
            'active'
        )
            ->orderBy('name')
            ->get();

        $brands = Brand::where(
            'status',
            'active'
        )
            ->orderBy('name')
            ->get();

        return view(
            'products.edit',
            compact(
                'product',
                'categories',
                'brands'
            )
        );
    }

    /**
     * Update the specified product.
     */
    public function update(
        Request $request,
        Product $product
    ) {
        abort_unless(
            auth()->user()?->hasPermission('edit-products'),
            403
        );

        $validated = $request->validate([
            'category_id' => [
                'nullable',
                'exists:categories,id',
            ],

            'brand_id' => [
                'nullable',
                'exists:brands,id',
            ],

            'name' => [
                'required',
                'string',
                'max:255',
            ],

            'sku' => [
                'required',
                'string',
                'max:100',
                Rule::unique(
                    'products',
                    'sku'
                )->ignore($product->id),
            ],

            'unit' => [
                'required',
                'string',
                'max:50',
            ],

            'buying_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'selling_price' => [
                'required',
                'numeric',
                'min:0',
            ],

            'quantity' => [
                'required',
                'integer',
                'min:0',
            ],

            'minimum_stock' => [
                'required',
                'integer',
                'min:0',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                Rule::in([
                    'active',
                    'inactive',
                ]),
            ],
        ]);

        $product->update($validated);

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product updated successfully.'
            );
    }

    /**
     * Remove the specified product.
     */
    public function destroy(Product $product)
    {
        abort_unless(
            auth()->user()?->hasPermission('delete-products'),
            403
        );

        $product->delete();

        return redirect()
            ->route('products.index')
            ->with(
                'success',
                'Product deleted successfully.'
            );
    }
}