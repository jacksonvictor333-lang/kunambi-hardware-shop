@extends('layouts.app')

@section('title', 'Products')

@section('content')

@php
    $currentUser = auth()->user();

    $canViewProducts = $currentUser?->hasPermission('view-products') ?? false;
    $canCreateProducts = $currentUser?->hasPermission('create-products') ?? false;
    $canEditProducts = $currentUser?->hasPermission('edit-products') ?? false;
    $canDeleteProducts = $currentUser?->hasPermission('delete-products') ?? false;

    $totalProducts = $products->total();

    $activeProducts = $products->where('status', 'active')->count();
    $inactiveProducts = $products->where('status', 'inactive')->count();
@endphp

<div class="min-h-screen bg-slate-50">

    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <div class="flex items-center gap-3">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M20 7.5 12 3 4 7.5m16 0v9L12 21l-8-4.5v-9m16 0L12 12 4 7.5m8 4.5v9"/>
                    </svg>
                </div>

                <div>
                    <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                        Products
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Manage your hardware shop products and stock information.
                    </p>
                </div>
            </div>
        </div>

        {{-- Add Product --}}
        @if($canCreateProducts)

            <a href="{{ route('products.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 hover:shadow-md">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 4v16m8-8H4"/>
                </svg>

                Add Product
            </a>

        @else

            <button type="button"
                    disabled
                    title="You don't have permission to add products"
                    class="inline-flex cursor-not-allowed items-center justify-center gap-2 rounded-xl bg-slate-200 px-5 py-3 text-sm font-semibold text-slate-400 opacity-70">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 4v16m8-8H4"/>
                </svg>

                Add Product

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-4 w-4"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <rect width="16"
                          height="11"
                          x="4"
                          y="10"
                          rx="2"/>
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M8 10V7a4 4 0 0 1 8 0v3"/>
                </svg>
            </button>

        @endif

    </div>


    {{-- Permission Notice --}}
    @if(!$canCreateProducts || !$canEditProducts || !$canDeleteProducts)

        <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3">
            <div class="flex items-start gap-3">

                <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-lg bg-amber-100 text-amber-600">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-5 w-5"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 9v4m0 4h.01M10.3 3.9 2.7 18a2 2 0 0 0 1.7 3h15.2a2 2 0 0 0 1.7-3L13.7 3.9a2 2 0 0 0-3.4 0Z"/>
                    </svg>
                </div>

                <div>
                    <p class="text-sm font-semibold text-amber-900">
                        Limited Product Access
                    </p>

                    <p class="mt-1 text-sm text-amber-800">
                        Your current account can view products, but some product management actions are restricted.
                    </p>
                </div>

            </div>
        </div>

    @endif


    {{-- Statistics --}}
    <div class="mb-6 grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-3">

        {{-- Total Products --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Products
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ number_format($totalProducts) }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.8">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M20 7.5 12 3 4 7.5m16 0v9L12 21l-8-4.5v-9m16 0L12 12 4 7.5m8 4.5v9"/>
                    </svg>
                </div>

            </div>
        </div>


        {{-- Active --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Active Products
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ number_format($activeProducts) }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m5 12 4 4L19 6"/>
                    </svg>
                </div>

            </div>
        </div>


        {{-- Inactive --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Inactive Products
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ number_format($inactiveProducts) }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-slate-100 text-slate-500">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M18 12H6"/>
                    </svg>
                </div>

            </div>
        </div>

    </div>


    {{-- Filters --}}
    <div class="mb-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

        <form method="GET"
              action="{{ route('products.index') }}"
              class="grid grid-cols-1 gap-3 md:grid-cols-4">

            {{-- Search --}}
            <div class="md:col-span-2">

                <label for="search"
                       class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Search Products
                </label>

                <div class="relative">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="pointer-events-none absolute left-3 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>

                    <input type="text"
                           id="search"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Search by name, SKU..."
                           class="w-full rounded-xl border border-slate-200 bg-slate-50 py-2.5 pl-10 pr-4 text-sm text-slate-900 outline-none transition focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-100">

                </div>

            </div>


            {{-- Category --}}
            <div>

                <label for="category"
                       class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Category
                </label>

                <select name="category"
                        id="category"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-100">

                    <option value="">
                        All Categories
                    </option>

                    @if(isset($categories))

                        @foreach($categories as $category)

                            <option value="{{ $category->id }}"
                                {{ (string) request('category') === (string) $category->id ? 'selected' : '' }}>
                                {{ $category->name }}
                            </option>

                        @endforeach

                    @endif

                </select>

            </div>


            {{-- Status --}}
            <div>

                <label for="status"
                       class="mb-1.5 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                    Status
                </label>

                <select name="status"
                        id="status"
                        class="w-full rounded-xl border border-slate-200 bg-slate-50 px-3 py-2.5 text-sm text-slate-700 outline-none transition focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-100">

                    <option value="">
                        All Status
                    </option>

                    <option value="active"
                        {{ request('status') === 'active' ? 'selected' : '' }}>
                        Active
                    </option>

                    <option value="inactive"
                        {{ request('status') === 'inactive' ? 'selected' : '' }}>
                        Inactive
                    </option>

                </select>

            </div>


            {{-- Filter Buttons --}}
            <div class="flex items-end gap-2 md:col-span-4">

                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="m21 21-4.35-4.35m1.35-5.65a7 7 0 1 1-14 0 7 7 0 0 1 14 0Z"/>
                    </svg>

                    Search
                </button>

                <a href="{{ route('products.index') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- Products Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- Table Header --}}
        <div class="flex flex-col gap-2 border-b border-slate-200 px-5 py-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="text-base font-bold text-slate-900">
                    Product List
                </h2>

                <p class="mt-0.5 text-sm text-slate-500">
                    View and manage available products.
                </p>
            </div>

            <span class="inline-flex w-fit items-center rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                {{ $products->total() }} products
            </span>

        </div>


        @if($products->count())

            {{-- Desktop Table --}}
            <div class="hidden overflow-x-auto md:block">

                <table class="min-w-full divide-y divide-slate-200">

                    <thead class="bg-slate-50">

                        <tr>

                            <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Product
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                SKU
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Category
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Price
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Stock
                            </th>

                            <th class="px-5 py-3 text-left text-xs font-bold uppercase tracking-wider text-slate-500">
                                Status
                            </th>

                            <th class="px-5 py-3 text-right text-xs font-bold uppercase tracking-wider text-slate-500">
                                Actions
                            </th>

                        </tr>

                    </thead>


                    <tbody class="divide-y divide-slate-100 bg-white">

                        @foreach($products as $product)

                            <tr class="transition hover:bg-slate-50">

                                {{-- Product --}}
                                <td class="whitespace-nowrap px-5 py-4">

                                    <div class="flex items-center gap-3">

                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-5 w-5"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 stroke-width="1.8">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M20 7.5 12 3 4 7.5m16 0v9L12 21l-8-4.5v-9m16 0L12 12 4 7.5m8 4.5v9"/>
                                            </svg>

                                        </div>

                                        <div>
                                            <p class="font-semibold text-slate-900">
                                                {{ $product->name }}
                                            </p>

                                            @if(isset($product->brand) && $product->brand)
                                                <p class="text-xs text-slate-500">
                                                    {{ $product->brand->name }}
                                                </p>
                                            @endif
                                        </div>

                                    </div>

                                </td>


                                {{-- SKU --}}
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                    {{ $product->sku ?? '—' }}
                                </td>


                                {{-- Category --}}
                                <td class="whitespace-nowrap px-5 py-4 text-sm text-slate-600">
                                    {{ $product->category->name ?? '—' }}
                                </td>


                                {{-- Price --}}
                                <td class="whitespace-nowrap px-5 py-4 text-sm font-semibold text-slate-800">
                                    {{ number_format((float) ($product->selling_price ?? $product->price ?? 0), 2) }}
                                </td>


                                {{-- Stock --}}
                                <td class="whitespace-nowrap px-5 py-4">

                                    @php
                                        $stock = (int) ($product->stock_quantity ?? $product->quantity ?? $product->stock ?? 0);
                                    @endphp

                                    @if($stock <= 0)

                                        <span class="inline-flex rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-600">
                                            Out of Stock
                                        </span>

                                    @elseif($stock <= 10)

                                        <span class="inline-flex rounded-full bg-amber-50 px-2.5 py-1 text-xs font-semibold text-amber-600">
                                            {{ number_format($stock) }} Low
                                        </span>

                                    @else

                                        <span class="inline-flex rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-600">
                                            {{ number_format($stock) }}
                                        </span>

                                    @endif

                                </td>


                                {{-- Status --}}
                                <td class="whitespace-nowrap px-5 py-4">

                                    @if(($product->status ?? 'active') === 'active')

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">

                                            <span class="h-1.5 w-1.5 rounded-full bg-emerald-500"></span>

                                            Active

                                        </span>

                                    @else

                                        <span class="inline-flex items-center gap-1.5 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">

                                            <span class="h-1.5 w-1.5 rounded-full bg-slate-400"></span>

                                            Inactive

                                        </span>

                                    @endif

                                </td>


                                {{-- Actions --}}
                                <td class="whitespace-nowrap px-5 py-4">

                                    <div class="flex items-center justify-end gap-2">

                                        {{-- View --}}
                                        @if($canViewProducts)

                                            <a href="{{ route('products.show', $product) }}"
                                               title="View Product"
                                               class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 bg-white text-slate-600 transition hover:border-green-200 hover:bg-green-50 hover:text-green-600">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-4 w-4"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor"
                                                     stroke-width="2">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12Z"/>
                                                    <circle cx="12"
                                                            cy="12"
                                                            r="3"/>
                                                </svg>

                                            </a>

                                        @endif


                                        {{-- Edit --}}
                                        @if($canEditProducts)

                                            <a href="{{ route('products.edit', $product) }}"
                                               title="Edit Product"
                                               class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-blue-200 bg-blue-50 text-blue-600 transition hover:bg-blue-100">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-4 w-4"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor"
                                                     stroke-width="2">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L9.832 16.82a4.5 4.5 0 0 1-1.897 1.13l-2.775.832.832-2.775a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"/>
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="M19.5 7.125 16.875 4.5"/>
                                                </svg>

                                            </a>

                                        @else

                                            <button type="button"
                                                    disabled
                                                    title="You don't have permission to edit products"
                                                    class="inline-flex h-9 w-9 cursor-not-allowed items-center justify-center rounded-lg border border-slate-100 bg-slate-50 text-slate-300 opacity-70">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-4 w-4"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor"
                                                     stroke-width="2">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L9.832 16.82a4.5 4.5 0 0 1-1.897 1.13l-2.775.832.832-2.775a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"/>
                                                </svg>

                                            </button>

                                        @endif


                                        {{-- Delete --}}
                                        @if($canDeleteProducts)

                                            <form action="{{ route('products.destroy', $product) }}"
                                                  method="POST"
                                                  onsubmit="return confirm('Are you sure you want to delete this product?');">

                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
                                                        title="Delete Product"
                                                        class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 bg-red-50 text-red-600 transition hover:bg-red-100">

                                                    <svg xmlns="http://www.w3.org/2000/svg"
                                                         class="h-4 w-4"
                                                         fill="none"
                                                         viewBox="0 0 24 24"
                                                         stroke="currentColor"
                                                         stroke-width="2">
                                                        <path stroke-linecap="round"
                                                              stroke-linejoin="round"
                                                              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-1.327L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-9.496 0a48.1 48.1 0 0 1 3.478-.397m0 0V4.5A2.25 2.25 0 0 1 12 2.25h0a2.25 2.25 0 0 1 2.25 2.25v.893m-6.75 0h9"/>
                                                    </svg>

                                                </button>

                                            </form>

                                        @else

                                            <button type="button"
                                                    disabled
                                                    title="You don't have permission to delete products"
                                                    class="inline-flex h-9 w-9 cursor-not-allowed items-center justify-center rounded-lg border border-slate-100 bg-slate-50 text-slate-300 opacity-70">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-4 w-4"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor"
                                                     stroke-width="2">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-1.327L4.772 5.79m14.456 0a48.108 48.108 0 0 0-3.478-.397m-9.496 0a48.1 48.1 0 0 1 3.478-.397m0 0V4.5A2.25 2.25 0 0 1 12 4.5v.893m-6.75 0h9"/>
                                                </svg>

                                            </button>

                                        @endif

                                    </div>

                                </td>

                            </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>


            {{-- Mobile Cards --}}
            <div class="divide-y divide-slate-100 md:hidden">

                @foreach($products as $product)

                    @php
                        $mobileStock = (int) ($product->stock_quantity ?? $product->quantity ?? $product->stock ?? 0);
                    @endphp

                    <div class="p-4">

                        <div class="flex items-start justify-between gap-3">

                            <div class="flex min-w-0 items-center gap-3">

                                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-50 text-green-600">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-5 w-5"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="1.8">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M20 7.5 12 3 4 7.5m16 0v9L12 21l-8-4.5v-9m16 0L12 12 4 7.5m8 4.5v9"/>
                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <p class="truncate font-semibold text-slate-900">
                                        {{ $product->name }}
                                    </p>

                                    <p class="truncate text-xs text-slate-500">
                                        {{ $product->sku ?? 'No SKU' }}
                                    </p>

                                </div>

                            </div>


                            @if(($product->status ?? 'active') === 'active')

                                <span class="shrink-0 rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                    Active
                                </span>

                            @else

                                <span class="shrink-0 rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">
                                    Inactive
                                </span>

                            @endif

                        </div>


                        <div class="mt-4 grid grid-cols-2 gap-3 text-sm">

                            <div>
                                <p class="text-xs text-slate-400">
                                    Category
                                </p>

                                <p class="mt-1 font-medium text-slate-700">
                                    {{ $product->category->name ?? '—' }}
                                </p>
                            </div>


                            <div>
                                <p class="text-xs text-slate-400">
                                    Price
                                </p>

                                <p class="mt-1 font-semibold text-slate-800">
                                    {{ number_format((float) ($product->selling_price ?? $product->price ?? 0), 2) }}
                                </p>
                            </div>


                            <div>
                                <p class="text-xs text-slate-400">
                                    Stock
                                </p>

                                @if($mobileStock <= 0)

                                    <p class="mt-1 font-semibold text-red-600">
                                        Out of Stock
                                    </p>

                                @elseif($mobileStock <= 10)

                                    <p class="mt-1 font-semibold text-amber-600">
                                        {{ number_format($mobileStock) }} Low
                                    </p>

                                @else

                                    <p class="mt-1 font-semibold text-emerald-600">
                                        {{ number_format($mobileStock) }}
                                    </p>

                                @endif

                            </div>


                            <div>
                                <p class="text-xs text-slate-400">
                                    Brand
                                </p>

                                <p class="mt-1 font-medium text-slate-700">
                                    {{ $product->brand->name ?? '—' }}
                                </p>
                            </div>

                        </div>


                        {{-- Mobile Actions --}}
                        <div class="mt-4 flex items-center gap-2">

                            @if($canViewProducts)

                                <a href="{{ route('products.show', $product) }}"
                                   class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-3 py-2.5 text-sm font-semibold text-slate-600 transition hover:bg-slate-50">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M2.25 12s3.75-7.5 9.75-7.5 9.75 7.5 9.75 7.5-3.75 7.5-9.75 7.5S2.25 12 2.25 12Z"/>
                                        <circle cx="12"
                                                cy="12"
                                                r="3"/>
                                    </svg>

                                    View

                                </a>

                            @endif


                            @if($canEditProducts)

                                <a href="{{ route('products.edit', $product) }}"
                                   class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-blue-200 bg-blue-50 text-blue-600 transition hover:bg-blue-100">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L9.832 16.82a4.5 4.5 0 0 1-1.897 1.13l-2.775.832.832-2.775a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"/>
                                    </svg>

                                </a>

                            @else

                                <button type="button"
                                        disabled
                                        title="You don't have permission to edit products"
                                        class="inline-flex h-11 w-11 cursor-not-allowed items-center justify-center rounded-xl border border-slate-100 bg-slate-50 text-slate-300 opacity-70">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="m16.862 4.487 1.687-1.688a1.875 1.875 0 1 1 2.652 2.652L9.832 16.82a4.5 4.5 0 0 1-1.897 1.13l-2.775.832a4.5 4.5 0 0 1 1.13-1.897L16.862 4.487Z"/>
                                    </svg>

                                </button>

                            @endif


                            @if($canDeleteProducts)

                                <form action="{{ route('products.destroy', $product) }}"
                                      method="POST"
                                      onsubmit="return confirm('Are you sure you want to delete this product?');">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            title="Delete Product"
                                            class="inline-flex h-11 w-11 items-center justify-center rounded-xl border border-red-200 bg-red-50 text-red-600 transition hover:bg-red-100">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-1.327L4.772 5.79"/>
                                        </svg>

                                    </button>

                                </form>

                            @else

                                <button type="button"
                                        disabled
                                        title="You don't have permission to delete products"
                                        class="inline-flex h-11 w-11 cursor-not-allowed items-center justify-center rounded-xl border border-slate-100 bg-slate-50 text-slate-300 opacity-70">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-4 w-4"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="m14.74 9-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673A2.25 2.25 0 0 1 15.916 21H8.084a2.25 2.25 0 0 1-2.244-1.327L4.772 5.79"/>
                                    </svg>

                                </button>

                            @endif

                        </div>

                    </div>

                @endforeach

            </div>


            {{-- Pagination --}}
            @if($products->hasPages())

                <div class="border-t border-slate-200 px-5 py-4">
                    {{ $products->withQueryString()->links() }}
                </div>

            @endif

        @else

            {{-- Empty State --}}
            <div class="px-6 py-16 text-center">

                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-8 w-8"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="1.6">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M20 7.5 12 3 4 7.5m16 0v9L12 21l-8-4.5v-9m16 0L12 12 4 7.5m8 4.5v9"/>
                    </svg>

                </div>

                <h3 class="mt-4 text-lg font-bold text-slate-900">
                    No products found
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                    No products match your current search or filter criteria.
                </p>

                @if($canCreateProducts)

                    <a href="{{ route('products.create') }}"
                       class="mt-5 inline-flex items-center gap-2 rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-4 w-4"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 4v16m8-8H4"/>
                        </svg>

                        Add Product

                    </a>

                @endif

            </div>

        @endif

    </div>

</div>

@endsection