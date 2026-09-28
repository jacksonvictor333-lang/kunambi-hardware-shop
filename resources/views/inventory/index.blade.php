@extends('layouts.app')

@section('title', 'Inventory')
@section('page-title', 'Inventory')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Inventory
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Monitor stock levels and inventory status.
                </p>
            </div>

            <div class="flex flex-wrap gap-3">

                <a
                    href="{{ route('inventory.movements') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                >
                    Movement History
                </a>

                <a
                    href="{{ route('inventory.adjustment') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-amber-200 bg-amber-50 px-5 py-3 text-sm font-semibold text-amber-700 shadow-sm transition hover:bg-amber-100"
                >
                    Stock Adjustment
                </a>

                <a
                    href="{{ route('inventory.stock-in') }}"
                    class="inline-flex items-center justify-center rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700"
                >
                    + Stock In
                </a>

            </div>

        </div>


        {{-- Success --}}
        @if (session('success'))
            <div class="rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm font-medium text-green-800">
                {{ session('success') }}
            </div>
        @endif


        {{-- Statistics --}}
        <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">
                    Total Products
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ number_format($totalProducts) }}
                </p>
            </div>


            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <p class="text-sm font-medium text-slate-500">
                    Total Units
                </p>

                <p class="mt-2 text-3xl font-bold text-slate-900">
                    {{ number_format($totalUnits) }}
                </p>
            </div>


            <div class="rounded-2xl border border-amber-200 bg-amber-50 p-5 shadow-sm">
                <p class="text-sm font-medium text-amber-700">
                    Low Stock
                </p>

                <p class="mt-2 text-3xl font-bold text-amber-900">
                    {{ number_format($lowStock) }}
                </p>
            </div>


            <div class="rounded-2xl border border-red-200 bg-red-50 p-5 shadow-sm">
                <p class="text-sm font-medium text-red-700">
                    Out of Stock
                </p>

                <p class="mt-2 text-3xl font-bold text-red-900">
                    {{ number_format($outOfStock) }}
                </p>
            </div>

        </div>


        {{-- Filters --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <form
                method="GET"
                action="{{ route('inventory.index') }}"
                class="grid gap-4 md:grid-cols-3"
            >

                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Search
                    </label>

                    <input
                        type="text"
                        name="search"
                        value="{{ request('search') }}"
                        placeholder="Search product or SKU..."
                        class="w-full rounded-xl border border-slate-200 px-4 py-2.5 text-sm outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >
                </div>


                <div>
                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Stock Status
                    </label>

                    <select
                        name="stock"
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >
                        <option value="">All Stock</option>

                        <option
                            value="in"
                            {{ request('stock') === 'in' ? 'selected' : '' }}
                        >
                            In Stock
                        </option>

                        <option
                            value="low"
                            {{ request('stock') === 'low' ? 'selected' : '' }}
                        >
                            Low Stock
                        </option>

                        <option
                            value="out"
                            {{ request('stock') === 'out' ? 'selected' : '' }}
                        >
                            Out of Stock
                        </option>
                    </select>
                </div>


                <div class="flex items-end gap-2">

                    <button
                        type="submit"
                        class="flex-1 rounded-xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white hover:bg-slate-800"
                    >
                        Filter
                    </button>

                    <a
                        href="{{ route('inventory.index') }}"
                        class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                    >
                        Reset
                    </a>

                </div>

            </form>

        </div>


        {{-- Inventory Table --}}
        <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="overflow-x-auto">

                <table class="min-w-full">

                    <thead class="border-b border-slate-200 bg-slate-50">

                        <tr>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                Product
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                Category
                            </th>

                            <th class="px-6 py-4 text-left text-xs font-bold uppercase tracking-wide text-slate-500">
                                SKU
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wide text-slate-500">
                                Current Stock
                            </th>

                            <th class="px-6 py-4 text-right text-xs font-bold uppercase tracking-wide text-slate-500">
                                Minimum
                            </th>

                            <th class="px-6 py-4 text-center text-xs font-bold uppercase tracking-wide text-slate-500">
                                Status
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100">

                        @forelse ($products as $product)

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-6 py-4">

                                    <div class="font-semibold text-slate-900">
                                        {{ $product->name }}
                                    </div>

                                    @if ($product->brand)
                                        <div class="mt-1 text-xs text-slate-500">
                                            {{ $product->brand->name }}
                                        </div>
                                    @endif

                                </td>


                                <td class="px-6 py-4 text-sm text-slate-600">
                                    {{ $product->category?->name ?? '—' }}
                                </td>


                                <td class="px-6 py-4 text-sm font-medium text-slate-700">
                                    {{ $product->sku }}
                                </td>


                                <td class="px-6 py-4 text-right">

                                    <span class="text-lg font-bold text-slate-900">
                                        {{ number_format($product->quantity) }}
                                    </span>

                                    <span class="ml-1 text-xs text-slate-500">
                                        {{ $product->unit }}
                                    </span>

                                </td>


                                <td class="px-6 py-4 text-right text-sm text-slate-600">
                                    {{ number_format($product->minimum_stock) }}
                                </td>


                                <td class="px-6 py-4 text-center">

                                    @if ($product->quantity <= 0)

                                        <span class="inline-flex rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">
                                            Out of Stock
                                        </span>

                                    @elseif ($product->quantity <= $product->minimum_stock)

                                        <span class="inline-flex rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                            Low Stock
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                            In Stock
                                        </span>

                                    @endif

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td
                                    colspan="6"
                                    class="px-6 py-12 text-center"
                                >

                                    <div class="text-4xl">
                                        📦
                                    </div>

                                    <h3 class="mt-3 font-semibold text-slate-900">
                                        No products found
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Add products first before managing inventory.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>


            @if ($products->hasPages())

                <div class="border-t border-slate-200 px-6 py-4">
                    {{ $products->links() }}
                </div>

            @endif

        </div>

    </div>

@endsection