@extends('layouts.app')

@section('title', 'Products')
@section('page-title', 'Products')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h1 class="text-2xl font-bold text-slate-900">
                    Products
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage your hardware products and inventory.
                </p>

            </div>

            <a
                href="{{ route('products.create') }}"
                class="inline-flex items-center justify-center rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700"
            >
                + Add Product
            </a>

        </div>


        {{-- Alerts --}}
        @if(session('success'))

            <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-700">
                {{ session('success') }}
            </div>

        @endif


        @if(session('error'))

            <div class="rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm font-medium text-red-700">
                {{ session('error') }}
            </div>

        @endif


        {{-- Filters --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <form
                method="GET"
                action="{{ route('products.index') }}"
                class="grid gap-4 md:grid-cols-2 lg:grid-cols-5"
            >

                {{-- Search --}}
                <div class="lg:col-span-2">

                    <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search product name or SKU..."
                        class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                    >

                </div>


                {{-- Category --}}
                <div>

                    <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Category
                    </label>

                    <select
                        name="category"
                        class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                    >

                        <option value="">
                            All Categories
                        </option>

                        @foreach($categories as $category)

                            <option
                                value="{{ $category->id }}"
                                @selected(request('category') == $category->id)
                            >
                                {{ $category->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Brand --}}
                <div>

                    <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Brand
                    </label>

                    <select
                        name="brand"
                        class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                    >

                        <option value="">
                            All Brands
                        </option>

                        @foreach($brands as $brand)

                            <option
                                value="{{ $brand->id }}"
                                @selected(request('brand') == $brand->id)
                            >
                                {{ $brand->name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Stock --}}
                <div>

                    <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Stock
                    </label>

                    <select
                        name="stock"
                        class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                    >

                        <option value="">
                            All Stock
                        </option>

                        <option
                            value="in"
                            @selected(request('stock') === 'in')
                        >
                            In Stock
                        </option>

                        <option
                            value="low"
                            @selected(request('stock') === 'low')
                        >
                            Low Stock
                        </option>

                        <option
                            value="out"
                            @selected(request('stock') === 'out')
                        >
                            Out of Stock
                        </option>

                    </select>

                </div>


                {{-- Status --}}
                <div>

                    <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                        Status
                    </label>

                    <select
                        name="status"
                        class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                    >

                        <option value="">
                            All Status
                        </option>

                        <option
                            value="active"
                            @selected(request('status') === 'active')
                        >
                            Active
                        </option>

                        <option
                            value="inactive"
                            @selected(request('status') === 'inactive')
                        >
                            Inactive
                        </option>

                    </select>

                </div>


                {{-- Buttons --}}
                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="flex-1 rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white hover:bg-green-700"
                    >
                        Filter
                    </button>

                    <a
                        href="{{ route('products.index') }}"
                        class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-600 hover:bg-slate-50"
                    >
                        Reset
                    </a>

                </div>

            </form>

        </div>


        {{-- Products Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Product
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                SKU
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Category
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Brand
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Price
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Stock
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Status
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 bg-white">

                        @forelse($products as $product)

                            <tr class="transition hover:bg-slate-50">

                                {{-- Product --}}
                                <td class="px-6 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 font-bold text-green-600">
                                            {{ strtoupper(substr($product->name, 0, 1)) }}
                                        </div>

                                        <div>

                                            <p class="font-semibold text-slate-900">
                                                {{ $product->name }}
                                            </p>

                                            <p class="text-xs text-slate-400">
                                                {{ strtoupper($product->unit) }}
                                            </p>

                                        </div>

                                    </div>

                                </td>


                                {{-- SKU --}}
                                <td class="px-6 py-4">

                                    <span class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
                                        {{ $product->sku }}
                                    </span>

                                </td>


                                {{-- Category --}}
                                <td class="px-6 py-4">

                                    @if($product->category)

                                        <span class="inline-flex rounded-lg bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                            {{ $product->category->name }}
                                        </span>

                                    @else

                                        <span class="text-xs text-slate-400">
                                            Uncategorized
                                        </span>

                                    @endif

                                </td>


                                {{-- Brand --}}
                                <td class="px-6 py-4">

                                    @if($product->brand)

                                        <span class="inline-flex rounded-lg bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                            {{ $product->brand->name }}
                                        </span>

                                    @else

                                        <span class="text-xs text-slate-400">
                                            No Brand
                                        </span>

                                    @endif

                                </td>


                                {{-- Price --}}
                                <td class="px-6 py-4">

                                    <div>

                                        <p class="font-semibold text-slate-900">
                                            TZS {{ number_format($product->selling_price, 0) }}
                                        </p>

                                        <p class="text-xs text-slate-400">
                                            Buy: TZS {{ number_format($product->buying_price, 0) }}
                                        </p>

                                    </div>

                                </td>


                                {{-- Stock --}}
                                <td class="px-6 py-4">

                                    @if($product->stock_status === 'out')

                                        <span class="inline-flex rounded-lg bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                            Out of Stock
                                        </span>

                                    @elseif($product->stock_status === 'low')

                                        <span class="inline-flex rounded-lg bg-amber-50 px-3 py-1 text-xs font-semibold text-amber-700">
                                            Low: {{ $product->quantity }}
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-lg bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                            {{ $product->quantity }} {{ $product->unit }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="px-6 py-4">

                                    @if($product->status === 'active')

                                        <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                            Active
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                            Inactive
                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="px-6 py-4">

                                    <div class="flex justify-end gap-2">

                                        <a
                                            href="{{ route('products.show', $product) }}"
                                            class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 hover:bg-slate-50"
                                        >
                                            View
                                        </a>

                                        <a
                                            href="{{ route('products.edit', $product) }}"
                                            class="rounded-lg bg-green-50 px-3 py-2 text-xs font-semibold text-green-700 hover:bg-green-100"
                                        >
                                            Edit
                                        </a>

                                        <form
                                            method="POST"
                                            action="{{ route('products.destroy', $product) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this product?')"
                                        >

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="rounded-lg bg-red-50 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-100"
                                            >
                                                Delete
                                            </button>

                                        </form>

                                    </div>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="8"
                                    class="px-6 py-12 text-center"
                                >

                                    <div class="mx-auto max-w-sm">

                                        <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-2xl">
                                            📦
                                        </div>

                                        <h3 class="mt-4 font-semibold text-slate-900">
                                            No products found
                                        </h3>

                                        <p class="mt-1 text-sm text-slate-500">
                                            Try changing your filters or add a new product.
                                        </p>

                                        <a
                                            href="{{ route('products.create') }}"
                                            class="mt-5 inline-flex rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-700"
                                        >
                                            + Add Product
                                        </a>

                                    </div>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            {{-- Pagination --}}
            @if($products->hasPages())

                <div class="border-t border-slate-200 px-6 py-4">

                    {{ $products->links() }}

                </div>

            @endif

        </div>

    </div>

@endsection