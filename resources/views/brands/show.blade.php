@extends('layouts.app')

@section('title', 'Brand Details')
@section('page-title', 'Brand Details')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-4">

            <div class="flex h-14 w-14 items-center justify-center rounded-2xl bg-green-50 text-green-600">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-7 w-7"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M20 7l-8-4-8 4m16 0v10l-8 4-8-4V7m16 0l-8 4m0 0L4 7m8 4v10"/>

                </svg>

            </div>

            <div>

                <h1 class="text-2xl font-bold text-slate-900">
                    {{ $brand->name }}
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $brand->slug }}
                </p>

            </div>

        </div>


        <div class="flex gap-2">

            <a
                href="{{ route('brands.index') }}"
                class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
            >
                ← Back
            </a>

            <a
                href="{{ route('brands.edit', $brand) }}"
                class="rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-700"
            >
                Edit Brand
            </a>

        </div>

    </div>


    {{-- Stats --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <p class="text-sm text-slate-500">
                Brand
            </p>

            <p class="mt-2 text-xl font-bold text-slate-900">
                {{ $brand->name }}
            </p>

        </div>


        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <p class="text-sm text-slate-500">
                Products
            </p>

            <p class="mt-2 text-xl font-bold text-slate-900">
                {{ $brand->products->count() }}
            </p>

        </div>


        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <p class="text-sm text-slate-500">
                Status
            </p>

            <div class="mt-2">

                @if($brand->status === 'active')

                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                        Active
                    </span>

                @else

                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                        Inactive
                    </span>

                @endif

            </div>

        </div>

    </div>


    {{-- Description --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="text-lg font-bold text-slate-900">
            Description
        </h2>

        <p class="mt-3 text-sm leading-7 text-slate-600">
            {{ $brand->description ?: 'No description provided.' }}
        </p>

    </div>


    {{-- Products --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="text-lg font-bold text-slate-900">
                Products under this Brand
            </h2>

        </div>

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            Product
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase text-slate-500">
                            SKU
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase text-slate-500">
                            Selling Price
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase text-slate-500">
                            Stock
                        </th>

                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($brand->products as $product)

                        <tr class="hover:bg-slate-50">

                            <td class="px-6 py-4">

                                <a
                                    href="{{ route('products.show', $product) }}"
                                    class="font-semibold text-green-600 hover:text-green-700"
                                >
                                    {{ $product->name }}
                                </a>

                            </td>

                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $product->sku }}
                            </td>

                            <td class="px-6 py-4 text-right text-sm font-semibold text-slate-700">
                                TSh {{ number_format($product->selling_price, 2) }}
                            </td>

                            <td class="px-6 py-4 text-center">
                                <span class="font-semibold text-slate-700">
                                    {{ $product->quantity }}
                                </span>
                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="4" class="px-6 py-12 text-center">

                                <p class="text-sm text-slate-500">
                                    No products have been assigned to this brand yet.
                                </p>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>


    {{-- Delete --}}
    <div class="flex justify-end">

        <form
            method="POST"
            action="{{ route('brands.destroy', $brand) }}"
            onsubmit="return confirm('Are you sure you want to delete this brand?')"
        >

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="rounded-xl border border-red-200 px-5 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50"
            >
                Delete Brand
            </button>

        </form>

    </div>

</div>

@endsection