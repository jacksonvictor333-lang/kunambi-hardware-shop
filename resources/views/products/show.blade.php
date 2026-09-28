```blade
@extends('layouts.app')

@section('title', 'Product Details')

@section('page-title', 'Product Details')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h1 class="text-2xl font-bold text-slate-900">
                Product Details
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                View complete information about this product.
            </p>

        </div>


        <div class="flex gap-2">

            <a
                href="{{ route('products.index') }}"
                class="rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
            >
                ← Back
            </a>

            <a
                href="{{ route('products.edit', $product) }}"
                class="rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700"
            >
                Edit Product
            </a>

        </div>

    </div>


    {{-- Main Card --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- Product Header --}}
        <div class="border-b border-slate-200 bg-slate-50 p-6">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">

                {{-- Product Icon --}}
                <div class="flex h-16 w-16 shrink-0 items-center justify-center rounded-2xl bg-green-100 text-2xl font-bold text-green-700">

                    {{ strtoupper(substr($product->name, 0, 1)) }}

                </div>


                {{-- Product Name --}}
                <div>

                    <h2 class="text-2xl font-bold text-slate-900">
                        {{ $product->name }}
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        SKU: {{ $product->sku }}
                    </p>

                </div>

            </div>

        </div>


        {{-- Product Details --}}
        <div class="grid gap-6 p-6 sm:grid-cols-2 lg:grid-cols-3">


            {{-- Category --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Category
                </p>

                @if($product->category)

                    <p class="mt-2 font-semibold text-green-600">
                        {{ $product->category->name }}
                    </p>

                @else

                    <p class="mt-2 text-sm text-slate-400">
                        Uncategorized
                    </p>

                @endif

            </div>


            {{-- Brand --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Brand
                </p>

                @if($product->brand)

                    <p class="mt-2 font-semibold text-blue-600">
                        {{ $product->brand->name }}
                    </p>

                @else

                    <p class="mt-2 text-sm text-slate-400">
                        No Brand
                    </p>

                @endif

            </div>


            {{-- Unit --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Unit
                </p>

                <p class="mt-2 font-semibold text-slate-900">
                    {{ strtoupper($product->unit) }}
                </p>

            </div>


            {{-- Buying Price --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Buying Price
                </p>

                <p class="mt-2 font-semibold text-slate-900">
                    TZS {{ number_format($product->buying_price, 0) }}
                </p>

            </div>


            {{-- Selling Price --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Selling Price
                </p>

                <p class="mt-2 font-semibold text-green-600">
                    TZS {{ number_format($product->selling_price, 0) }}
                </p>

            </div>


            {{-- Current Stock --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Current Stock
                </p>

                <p class="mt-2 text-xl font-bold text-slate-900">

                    {{ $product->quantity }}

                    <span class="text-sm font-medium text-slate-400">
                        {{ $product->unit }}
                    </span>

                </p>

            </div>


            {{-- Minimum Stock --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Minimum Stock
                </p>

                <p class="mt-2 font-semibold text-slate-900">
                    {{ $product->minimum_stock }}
                </p>

            </div>


            {{-- Status --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Status
                </p>

                <div class="mt-2">

                    @if($product->status === 'active')

                        <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                            Active
                        </span>

                    @else

                        <span class="rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                            Inactive
                        </span>

                    @endif

                </div>

            </div>


            {{-- Stock Status --}}
            <div>

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Stock Status
                </p>

                <div class="mt-2">

                    @if($product->stock_status === 'out')

                        <span class="rounded-lg bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                            Out of Stock
                        </span>

                    @elseif($product->stock_status === 'low')

                        <span class="rounded-lg bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                            Low Stock
                        </span>

                    @else

                        <span class="rounded-lg bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                            In Stock
                        </span>

                    @endif

                </div>

            </div>

        </div>


        {{-- Description --}}
        @if($product->description)

            <div class="border-t border-slate-200 p-6">

                <p class="text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Description
                </p>

                <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-600">
                    {{ $product->description }}
                </p>

            </div>

        @endif

    </div>


    {{-- Delete --}}
    <div class="flex justify-end">

        <form
            method="POST"
            action="{{ route('products.destroy', $product) }}"
            onsubmit="return confirm('Are you sure you want to delete this product?')"
        >

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="rounded-xl border border-red-200 bg-red-50 px-5 py-2.5 text-sm font-semibold text-red-600 transition hover:bg-red-100"
            >
                Delete Product
            </button>

        </form>

    </div>

</div>

@endsection
```
