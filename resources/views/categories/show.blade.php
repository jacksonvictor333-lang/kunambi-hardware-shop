@extends('layouts.app')

@section('title', 'Category Details')
@section('page-title', 'Category Details')

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
                          d="M3 7.5L12 3l9 4.5v9L12 21l-9-4.5v-9z" />

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 21v-9m9-4.5l-9 4.5-9-4.5" />

                </svg>

            </div>

            <div>

                <h1 class="text-2xl font-bold text-slate-900">
                    {{ $category->name }}
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    {{ $category->slug }}
                </p>

            </div>

        </div>


        <div class="flex gap-2">

            <a
                href="{{ route('categories.index') }}"
                class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
            >
                ← Back
            </a>

            <a
                href="{{ route('categories.edit', $category) }}"
                class="rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-700"
            >
                Edit Category
            </a>

        </div>

    </div>


    {{-- Information --}}
    <div class="grid grid-cols-1 gap-6 lg:grid-cols-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <p class="text-sm text-slate-500">
                Category
            </p>

            <p class="mt-2 text-xl font-bold text-slate-900">
                {{ $category->name }}
            </p>

        </div>


        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <p class="text-sm text-slate-500">
                Products
            </p>

            <p class="mt-2 text-xl font-bold text-slate-900">
                {{ $category->products->count() }}
            </p>

        </div>


        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <p class="text-sm text-slate-500">
                Status
            </p>

            <div class="mt-2">

                @if($category->status === 'active')

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
            {{ $category->description ?: 'No description provided.' }}
        </p>

    </div>


    {{-- Products --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="text-lg font-bold text-slate-900">
                Products in this Category
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

                    @forelse($category->products as $product)

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
                                    No products have been assigned to this category yet.
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
            action="{{ route('categories.destroy', $category) }}"
            onsubmit="return confirm('Are you sure you want to delete this category?')"
        >

            @csrf
            @method('DELETE')

            <button
                type="submit"
                class="rounded-xl border border-red-200 px-5 py-2.5 text-sm font-semibold text-red-600 hover:bg-red-50"
            >
                Delete Category
            </button>

        </form>

    </div>

</div>

@endsection