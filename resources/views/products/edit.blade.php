@extends('layouts.app')

@section('title', 'Edit Product')

@section('page-title', 'Edit Product')

@section('content')

<div class="space-y-6">


{{-- Header --}}
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            Edit Product
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Update product information.
        </p>
    </div>

    <a
        href="{{ route('products.index') }}"
        class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
    >
        ← Back to Products
    </a>
</div>

{{-- Validation Errors --}}
@if ($errors->any())
    <div class="rounded-2xl border border-red-200 bg-red-50 p-5">
        <h3 class="font-semibold text-red-800">
            Please correct the following errors:
        </h3>

        <ul class="mt-2 list-inside list-disc text-sm text-red-700">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

{{-- Form --}}
<form
    method="POST"
    action="{{ route('products.update', $product) }}"
    class="space-y-6"
>
    @csrf
    @method('PUT')

    {{-- Basic Information --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <div class="mb-6">
            <h2 class="text-lg font-bold text-slate-900">
                Basic Information
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Update the basic details of this product.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">

            {{-- Product Name --}}
            <div class="md:col-span-2">
                <label
                    for="name"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Product Name
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name', $product->name) }}"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                    required
                >

                @error('name')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Category --}}
            <div>
                <label
                    for="category_id"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Category
                </label>

                <select
                    id="category_id"
                    name="category_id"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                >
                    <option value="">
                        Select Category
                    </option>

                    @foreach($categories as $category)
                        <option
                            value="{{ $category->id }}"
                            @selected(old('category_id', $product->category_id) == $category->id)
                        >
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>

                @error('category_id')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Brand --}}
            <div>
                <label
                    for="brand_id"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Brand
                </label>

                <select
                    id="brand_id"
                    name="brand_id"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                >
                    <option value="">
                        Select Brand
                    </option>

                    @foreach($brands as $brand)
                        <option
                            value="{{ $brand->id }}"
                            @selected(old('brand_id', $product->brand_id) == $brand->id)
                        >
                            {{ $brand->name }}
                        </option>
                    @endforeach
                </select>

                @error('brand_id')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- SKU --}}
            <div>
                <label
                    for="sku"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    SKU
                </label>

                <input
                    type="text"
                    id="sku"
                    name="sku"
                    value="{{ old('sku', $product->sku) }}"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                    required
                >

                @error('sku')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Unit --}}
            <div>
                <label
                    for="unit"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Unit
                </label>

                <select
                    id="unit"
                    name="unit"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                >
                    <option
                        value="pcs"
                        @selected(old('unit', $product->unit) === 'pcs')
                    >
                        Pieces (pcs)
                    </option>

                    <option
                        value="box"
                        @selected(old('unit', $product->unit) === 'box')
                    >
                        Box
                    </option>

                    <option
                        value="pack"
                        @selected(old('unit', $product->unit) === 'pack')
                    >
                        Pack
                    </option>

                    <option
                        value="kg"
                        @selected(old('unit', $product->unit) === 'kg')
                    >
                        Kilogram (kg)
                    </option>

                    <option
                        value="meter"
                        @selected(old('unit', $product->unit) === 'meter')
                    >
                        Meter
                    </option>

                    <option
                        value="litre"
                        @selected(old('unit', $product->unit) === 'litre')
                    >
                        Litre
                    </option>

                    <option
                        value="roll"
                        @selected(old('unit', $product->unit) === 'roll')
                    >
                        Roll
                    </option>
                </select>

                @error('unit')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>
    </div>

    {{-- Pricing & Stock --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <div class="mb-6">
            <h2 class="text-lg font-bold text-slate-900">
                Pricing & Stock
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Update pricing and inventory information.
            </p>
        </div>

        <div class="grid gap-6 md:grid-cols-2">

            {{-- Buying Price --}}
            <div>
                <label
                    for="buying_price"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Buying Price
                </label>

                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-medium text-slate-400">
                        TZS
                    </span>

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        id="buying_price"
                        name="buying_price"
                        value="{{ old('buying_price', $product->buying_price) }}"
                        class="w-full rounded-xl border-slate-300 pl-14 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                        required
                    >
                </div>

                @error('buying_price')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Selling Price --}}
            <div>
                <label
                    for="selling_price"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Selling Price
                </label>

                <div class="relative">
                    <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm font-medium text-slate-400">
                        TZS
                    </span>

                    <input
                        type="number"
                        step="0.01"
                        min="0"
                        id="selling_price"
                        name="selling_price"
                        value="{{ old('selling_price', $product->selling_price) }}"
                        class="w-full rounded-xl border-slate-300 pl-14 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                        required
                    >
                </div>

                @error('selling_price')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Quantity --}}
            <div>
                <label
                    for="quantity"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Quantity
                </label>

                <input
                    type="number"
                    min="0"
                    id="quantity"
                    name="quantity"
                    value="{{ old('quantity', $product->quantity) }}"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                    required
                >

                @error('quantity')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Minimum Stock --}}
            <div>
                <label
                    for="minimum_stock"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Minimum Stock
                </label>

                <input
                    type="number"
                    min="0"
                    id="minimum_stock"
                    name="minimum_stock"
                    value="{{ old('minimum_stock', $product->minimum_stock) }}"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                    required
                >

                @error('minimum_stock')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>
    </div>

    {{-- Additional Information --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <h2 class="mb-6 text-lg font-bold text-slate-900">
            Additional Information
        </h2>

        <div class="space-y-6">

            {{-- Status --}}
            <div>
                <label
                    for="status"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Status
                </label>

                <select
                    id="status"
                    name="status"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                >
                    <option
                        value="active"
                        @selected(old('status', $product->status) === 'active')
                    >
                        Active
                    </option>

                    <option
                        value="inactive"
                        @selected(old('status', $product->status) === 'inactive')
                    >
                        Inactive
                    </option>
                </select>

                @error('status')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

            {{-- Description --}}
            <div>
                <label
                    for="description"
                    class="mb-2 block text-sm font-semibold text-slate-700"
                >
                    Description
                </label>

                <textarea
                    id="description"
                    name="description"
                    rows="4"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                >{{ old('description', $product->description) }}</textarea>

                @error('description')
                    <p class="mt-1 text-sm text-red-600">
                        {{ $message }}
                    </p>
                @enderror
            </div>

        </div>
    </div>

    {{-- Actions --}}
    <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

        <a
            href="{{ route('products.index') }}"
            class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
        >
            Cancel
        </a>

        <button
            type="submit"
            class="inline-flex items-center justify-center rounded-xl bg-green-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
        >
            Update Product
        </button>

    </div>

</form>


</div>

@endsection
