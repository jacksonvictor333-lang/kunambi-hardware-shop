@extends('layouts.app')

@section('title', 'Product Details')

@section('content')

@php
    $currentUser = auth()->user();

    $canViewProducts = $currentUser?->hasPermission('view-products') ?? false;
    $canEditProducts = $currentUser?->hasPermission('edit-products') ?? false;
    $canDeleteProducts = $currentUser?->hasPermission('delete-products') ?? false;

    $stock = (int) ($product->stock_quantity ?? $product->quantity ?? $product->stock ?? 0);

    $sellingPrice = (float) ($product->selling_price ?? $product->price ?? 0);
    $buyingPrice = (float) ($product->buying_price ?? $product->cost_price ?? 0);
@endphp


<div class="min-h-screen bg-slate-50">

    {{-- Page Header --}}
    <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">

            <a href="{{ route('products.index') }}"
               class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:bg-slate-50">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M15 19l-7-7 7-7"/>
                </svg>

            </a>


            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    Product Details
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    View complete information about this product.
                </p>
            </div>

        </div>


        {{-- Top Actions --}}
        <div class="flex items-center gap-2">

            {{-- Edit --}}
            @if($canEditProducts)

                <a href="{{ route('products.edit', $product) }}"
                   class="inline-flex items-center gap-2 rounded-xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-blue-700">

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

                    Edit Product

                </a>

            @else

                <button type="button"
                        disabled
                        title="You don't have permission to edit products"
                        class="inline-flex cursor-not-allowed items-center gap-2 rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-400 opacity-70">

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

                    Edit Product

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


            {{-- Delete --}}
            @if($canDeleteProducts)

                <form action="{{ route('products.destroy', $product) }}"
                      method="POST"
                      onsubmit="return confirm('Are you sure you want to delete this product?');">

                    @csrf
                    @method('DELETE')

                    <button type="submit"
                            class="inline-flex items-center gap-2 rounded-xl bg-red-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-red-700">

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

                        Delete

                    </button>

                </form>

            @else

                <button type="button"
                        disabled
                        title="You don't have permission to delete products"
                        class="inline-flex cursor-not-allowed items-center gap-2 rounded-xl border border-slate-200 bg-slate-100 px-4 py-2.5 text-sm font-semibold text-slate-400 opacity-70">

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

                    Delete

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

    </div>


    {{-- Permission Notice --}}
    @if(!$canEditProducts || !$canDeleteProducts)

        <div class="mb-6 rounded-2xl border border-amber-200 bg-amber-50 px-4 py-3">

            <div class="flex items-start gap-3">

                <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-amber-100 text-amber-600">

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
                        Limited Access
                    </p>

                    <p class="mt-1 text-sm text-amber-800">
                        You can view this product, but editing and deleting products is restricted for your account.
                    </p>

                </div>

            </div>

        </div>

    @endif


    {{-- Product Main Card --}}
    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- Product Information --}}
        <div class="xl:col-span-2">

            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                {{-- Card Header --}}
                <div class="border-b border-slate-200 px-6 py-5">

                    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-4">

                            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-green-100 text-green-700">

                                <svg xmlns="http://www.w3.org/2000/svg"
                                     class="h-7 w-7"
                                     fill="none"
                                     viewBox="0 0 24 24"
                                     stroke="currentColor"
                                     stroke-width="1.7">
                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          d="M20 7.5 12 3 4 7.5m16 0v9L12 21l-8-4.5v-9m16 0L12 12 4 7.5m8 4.5v9"/>
                                </svg>

                            </div>


                            <div>

                                <h2 class="text-xl font-bold text-slate-900">
                                    {{ $product->name }}
                                </h2>

                                <p class="mt-1 text-sm text-slate-500">
                                    SKU: {{ $product->sku ?? 'Not assigned' }}
                                </p>

                            </div>

                        </div>


                        {{-- Status --}}
                        @if(($product->status ?? 'active') === 'active')

                            <span class="inline-flex w-fit items-center gap-2 rounded-full bg-emerald-50 px-3 py-1.5 text-xs font-semibold text-emerald-700">

                                <span class="h-2 w-2 rounded-full bg-emerald-500"></span>

                                Active

                            </span>

                        @else

                            <span class="inline-flex w-fit items-center gap-2 rounded-full bg-slate-100 px-3 py-1.5 text-xs font-semibold text-slate-600">

                                <span class="h-2 w-2 rounded-full bg-slate-400"></span>

                                Inactive

                            </span>

                        @endif

                    </div>

                </div>


                {{-- Product Details --}}
                <div class="p-6">

                    <div class="grid grid-cols-1 gap-x-8 gap-y-6 sm:grid-cols-2">

                        {{-- Product Name --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Product Name
                            </p>

                            <p class="mt-2 font-semibold text-slate-800">
                                {{ $product->name }}
                            </p>
                        </div>


                        {{-- SKU --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                SKU
                            </p>

                            <p class="mt-2 font-semibold text-slate-800">
                                {{ $product->sku ?? '—' }}
                            </p>
                        </div>


                        {{-- Category --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Category
                            </p>

                            <p class="mt-2 font-semibold text-slate-800">
                                {{ $product->category->name ?? '—' }}
                            </p>
                        </div>


                        {{-- Brand --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Brand
                            </p>

                            <p class="mt-2 font-semibold text-slate-800">
                                {{ $product->brand->name ?? '—' }}
                            </p>
                        </div>


                        {{-- Buying Price --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Buying Price
                            </p>

                            <p class="mt-2 text-lg font-bold text-slate-900">
                                {{ number_format($buyingPrice, 2) }}
                            </p>
                        </div>


                        {{-- Selling Price --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Selling Price
                            </p>

                            <p class="mt-2 text-lg font-bold text-green-600">
                                {{ number_format($sellingPrice, 2) }}
                            </p>
                        </div>


                        {{-- Stock --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Current Stock
                            </p>

                            @if($stock <= 0)

                                <p class="mt-2 font-bold text-red-600">
                                    Out of Stock
                                </p>

                            @elseif($stock <= 10)

                                <p class="mt-2 font-bold text-amber-600">
                                    {{ number_format($stock) }} units
                                </p>

                            @else

                                <p class="mt-2 font-bold text-emerald-600">
                                    {{ number_format($stock) }} units
                                </p>

                            @endif

                        </div>


                        {{-- Unit --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Unit
                            </p>

                            <p class="mt-2 font-semibold text-slate-800">
                                {{ $product->unit ?? 'Piece' }}
                            </p>
                        </div>


                        {{-- Created --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Created
                            </p>

                            <p class="mt-2 font-medium text-slate-700">
                                {{ $product->created_at?->format('d M Y, h:i A') ?? '—' }}
                            </p>
                        </div>


                        {{-- Updated --}}
                        <div>
                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Last Updated
                            </p>

                            <p class="mt-2 font-medium text-slate-700">
                                {{ $product->updated_at?->format('d M Y, h:i A') ?? '—' }}
                            </p>
                        </div>

                    </div>


                    {{-- Description --}}
                    @if(!empty($product->description))

                        <div class="mt-8 border-t border-slate-200 pt-6">

                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Description
                            </p>

                            <p class="mt-3 whitespace-pre-line text-sm leading-6 text-slate-600">
                                {{ $product->description }}
                            </p>

                        </div>

                    @endif

                </div>

            </div>

        </div>


        {{-- Right Side Summary --}}
        <div class="space-y-6">

            {{-- Stock Card --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex items-center justify-between">

                    <div>
                        <p class="text-sm font-medium text-slate-500">
                            Current Stock
                        </p>

                        <p class="mt-2 text-3xl font-bold text-slate-900">
                            {{ number_format($stock) }}
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            {{ $product->unit ?? 'units' }}
                        </p>
                    </div>


                    <div class="flex h-12 w-12 items-center justify-center rounded-xl
                        {{ $stock <= 0 ? 'bg-red-100 text-red-600' : ($stock <= 10 ? 'bg-amber-100 text-amber-600' : 'bg-emerald-100 text-emerald-600') }}">

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


                <div class="mt-5">

                    @if($stock <= 0)

                        <div class="rounded-xl bg-red-50 px-4 py-3">
                            <p class="text-sm font-semibold text-red-700">
                                Out of Stock
                            </p>

                            <p class="mt-1 text-xs text-red-600">
                                This product needs stock replenishment.
                            </p>
                        </div>

                    @elseif($stock <= 10)

                        <div class="rounded-xl bg-amber-50 px-4 py-3">
                            <p class="text-sm font-semibold text-amber-700">
                                Low Stock
                            </p>

                            <p class="mt-1 text-xs text-amber-600">
                                Consider restocking this product soon.
                            </p>
                        </div>

                    @else

                        <div class="rounded-xl bg-emerald-50 px-4 py-3">
                            <p class="text-sm font-semibold text-emerald-700">
                                Stock Available
                            </p>

                            <p class="mt-1 text-xs text-emerald-600">
                                Current stock level is available.
                            </p>
                        </div>

                    @endif

                </div>

            </div>


            {{-- Price Card --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <p class="text-sm font-medium text-slate-500">
                    Selling Price
                </p>

                <p class="mt-2 text-3xl font-bold text-green-600">
                    {{ number_format($sellingPrice, 2) }}
                </p>

                <div class="mt-5 flex items-center justify-between border-t border-slate-100 pt-4">

                    <span class="text-sm text-slate-500">
                        Buying Price
                    </span>

                    <span class="text-sm font-semibold text-slate-800">
                        {{ number_format($buyingPrice, 2) }}
                    </span>

                </div>

            </div>


            {{-- Access Card --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="flex items-center gap-3">

                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-slate-100 text-slate-600">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor"
                             stroke-width="2">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  d="M12 15v2m-6 4h12a2 2 0 0 0 2-2v-7a2 2 0 0 0-2-2H6a2 2 0 0 0-2 2v7a2 2 0 0 0 2 2Zm10-11V7a4 4 0 0 0-8 0v3h8Z"/>
                        </svg>

                    </div>

                    <div>
                        <p class="font-semibold text-slate-900">
                            Account Access
                        </p>

                        <p class="text-xs text-slate-500">
                            Product permissions
                        </p>
                    </div>

                </div>


                <div class="mt-5 space-y-3">

                    {{-- View --}}
                    <div class="flex items-center justify-between">

                        <span class="text-sm text-slate-600">
                            View Product
                        </span>

                        @if($canViewProducts)

                            <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                Allowed
                            </span>

                        @else

                            <span class="rounded-full bg-red-50 px-2.5 py-1 text-xs font-semibold text-red-600">
                                Restricted
                            </span>

                        @endif

                    </div>


                    {{-- Edit --}}
                    <div class="flex items-center justify-between">

                        <span class="text-sm text-slate-600">
                            Edit Product
                        </span>

                        @if($canEditProducts)

                            <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                Allowed
                            </span>

                        @else

                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                                Restricted
                            </span>

                        @endif

                    </div>


                    {{-- Delete --}}
                    <div class="flex items-center justify-between">

                        <span class="text-sm text-slate-600">
                            Delete Product
                        </span>

                        @if($canDeleteProducts)

                            <span class="rounded-full bg-emerald-50 px-2.5 py-1 text-xs font-semibold text-emerald-700">
                                Allowed
                            </span>

                        @else

                            <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-500">
                                Restricted
                            </span>

                        @endif

                    </div>

                </div>

            </div>

        </div>

    </div>

</div>

@endsection