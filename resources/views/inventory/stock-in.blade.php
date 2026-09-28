@extends('layouts.app')

@section('title', 'Stock In')
@section('page-title', 'Stock In')

@section('content')

    <div class="space-y-6">

        {{-- Header --}}
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="flex items-center gap-2 text-sm text-slate-500">
                    <a
                        href="{{ route('inventory.index') }}"
                        class="hover:text-green-600"
                    >
                        Inventory
                    </a>

                    <span>/</span>

                    <span>Stock In</span>
                </div>

                <h1 class="mt-2 text-2xl font-bold text-slate-900">
                    Stock In
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Add new stock to your inventory.
                </p>
            </div>

            <a
                href="{{ route('inventory.index') }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
            >
                ← Back to Inventory
            </a>

        </div>


        {{-- Validation Errors --}}
        @if ($errors->any())
            <div class="rounded-2xl border border-red-200 bg-red-50 p-4">

                <div class="flex gap-3">

                    <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100 text-red-600">
                        !
                    </div>

                    <div>
                        <h3 class="font-semibold text-red-800">
                            Please fix the following errors
                        </h3>

                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>

                </div>

            </div>
        @endif


        {{-- Form --}}
        <form
            method="POST"
            action="{{ route('inventory.stock-in.store') }}"
            class="space-y-6"
        >

            @csrf


            {{-- Product --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="mb-6">
                    <h2 class="text-lg font-bold text-slate-900">
                        Product Information
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Select the product you want to add into stock.
                    </p>
                </div>


                <div>
                    <label
                        for="product_id"
                        class="mb-2 block text-sm font-semibold text-slate-700"
                    >
                        Product
                    </label>

                    <select
                        name="product_id"
                        id="product_id"
                        required
                        class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >
                        <option value="">
                            Select product
                        </option>

                        @foreach ($products as $product)
                            <option
                                value="{{ $product->id }}"
                                {{ old('product_id') == $product->id ? 'selected' : '' }}
                            >
                                {{ $product->name }}
                                — {{ $product->sku }}
                                — Current Stock: {{ $product->quantity }}
                            </option>
                        @endforeach
                    </select>

                    @error('product_id')
                        <p class="mt-2 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror
                </div>

            </div>


            {{-- Stock Details --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

                <div class="mb-6">
                    <h2 class="text-lg font-bold text-slate-900">
                        Stock Details
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Enter the quantity and purchase information.
                    </p>
                </div>


                <div class="grid gap-6 md:grid-cols-2">

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
                            name="quantity"
                            id="quantity"
                            min="1"
                            value="{{ old('quantity') }}"
                            required
                            placeholder="e.g. 50"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                        >

                        @error('quantity')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Unit Cost --}}
                    <div>
                        <label
                            for="unit_cost"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Unit Cost
                            <span class="font-normal text-slate-400">
                                (Optional)
                            </span>
                        </label>

                        <div class="relative">

                            <span class="absolute left-4 top-1/2 -translate-y-1/2 text-sm text-slate-400">
                                TZS
                            </span>

                            <input
                                type="number"
                                name="unit_cost"
                                id="unit_cost"
                                min="0"
                                step="0.01"
                                value="{{ old('unit_cost') }}"
                                placeholder="0.00"
                                class="w-full rounded-xl border border-slate-200 py-3 pl-14 pr-4 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                            >

                        </div>

                        @error('unit_cost')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Reference --}}
                    <div>
                        <label
                            for="reference"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Reference
                            <span class="font-normal text-slate-400">
                                (Optional)
                            </span>
                        </label>

                        <input
                            type="text"
                            name="reference"
                            id="reference"
                            value="{{ old('reference') }}"
                            placeholder="e.g. INV-2026-001"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                        >

                        @error('reference')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>


                    {{-- Reason --}}
                    <div>
                        <label
                            for="reason"
                            class="mb-2 block text-sm font-semibold text-slate-700"
                        >
                            Reason
                            <span class="font-normal text-slate-400">
                                (Optional)
                            </span>
                        </label>

                        <input
                            type="text"
                            name="reason"
                            id="reason"
                            value="{{ old('reason') }}"
                            placeholder="e.g. New supplier delivery"
                            class="w-full rounded-xl border border-slate-200 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                        >

                        @error('reason')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                </div>

            </div>


            {{-- Information --}}
            <div class="rounded-2xl border border-green-200 bg-green-50 p-5">

                <div class="flex gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-full bg-green-100 text-green-700">
                        ✓
                    </div>

                    <div>
                        <h3 class="font-semibold text-green-900">
                            Stock Update
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-green-800">
                            When you save this transaction, the product stock
                            quantity will automatically increase and a stock
                            movement record will be created.
                        </p>
                    </div>

                </div>

            </div>


            {{-- Actions --}}
            <div class="flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('inventory.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-6 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="inline-flex items-center justify-center rounded-xl bg-green-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
                >
                    + Add Stock
                </button>

            </div>

        </form>

    </div>

@endsection