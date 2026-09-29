@extends('layouts.app')

@section('title', 'Point of Sale')
@section('page-title', 'Point of Sale')

@section('content')

@php
    $posProducts = collect($products ?? [])->map(function ($product) {
        return [
            'id'    => $product->id,
            'name'  => $product->name,
            'sku'   => $product->sku,
            'price' => (float) ($product->selling_price ?? 0),
            'stock' => (int) ($product->quantity ?? 0),
            'unit'  => $product->unit ?? 'pcs',
        ];
    })->values();

    // Namba ya invoice inatoka kwenye controller ($invoiceNumber).
    // Fallback hii inatumika tu endapo controller haijaipitisha.
    $invoiceNo = $invoiceNumber ?? ('INV-' . now()->format('Ymd') . '-' . strtoupper(\Illuminate\Support\Str::random(4)));
@endphp

<div x-data="posSystem()" x-init="init()" class="space-y-6">

    {{-- PAGE HEADER --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">
        <div class="flex items-center gap-3">
            <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-100 text-green-700">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.8"
                          d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 2h12m-9 4a1 1 0 100-2 1 1 0 000 2zm8 0a1 1 0 100-2 1 1 0 000 2z"/>
                </svg>
            </div>
            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">Point of Sale</h1>
                <p class="text-sm text-slate-500">Create a new customer sale</p>
            </div>
        </div>

        <a href="{{ route('sales.history') }}"
           class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 2m6-2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            Sales History
        </a>
    </div>

    {{-- SUCCESS --}}
    @if(session('success'))
        <div class="flex items-start gap-3 rounded-2xl border border-green-200 bg-green-50 px-4 py-4 text-green-800">
            <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-green-100">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-green-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                </svg>
            </div>
            <div>
                <p class="font-semibold">Sale completed</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif

    {{-- ERRORS --}}
    @if($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800">
            <p class="font-semibold">Please correct the following errors.</p>
            <ul class="mt-2 list-disc space-y-1 pl-6 text-sm">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- MAIN FORM --}}
    <form method="POST" action="{{ route('sales.store') }}" @submit="prepareSale($event)">
        @csrf

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-12">

            {{-- ===================== LEFT ===================== --}}
            <div class="space-y-6 xl:col-span-8">

                {{-- INVOICE INFO --}}
                <div class="grid grid-cols-1 gap-4 rounded-2xl border border-slate-200 bg-white p-5 shadow-sm md:grid-cols-3">

                    {{-- Invoice number (auto) --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Invoice No.</label>
                        <div class="relative">
                            <input type="text"
                                   name="invoice_number"
                                   value="{{ old('invoice_number', $invoiceNo) }}"
                                   readonly
                                   class="w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-50 py-3 pl-4 pr-20 text-sm font-bold text-green-700 outline-none">
                            <span class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full bg-green-100 px-2 py-0.5 text-[11px] font-semibold text-green-700">Auto</span>
                        </div>
                    </div>

                    {{-- Date --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Date</label>
                        <input type="text" value="{{ now()->format('d M Y, H:i') }}" readonly
                               class="w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-700 outline-none">
                    </div>

                    {{-- Customer --}}
                    <div>
                        <label class="mb-2 block text-sm font-medium text-slate-700">Customer</label>
                        <select name="customer_id" x-model="customerId"
                                class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100">
                            <option value="">Walk-in Customer</option>
                            @foreach($customers ?? [] as $customer)
                                <option value="{{ $customer->id }}">
                                    {{ $customer->name }}@if($customer->phone) — {{ $customer->phone }}@endif
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>

                {{-- PRODUCT SEARCH DROPDOWN --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                    <div class="mb-4 flex items-center justify-between gap-3">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">Add Product</h2>
                            <p class="text-sm text-slate-500">Type a name or SKU, then choose from the list</p>
                        </div>
                        <div class="rounded-xl bg-green-50 px-3 py-2 text-sm font-semibold text-green-700">
                            <span x-text="cartQuantity"></span> item(s)
                        </div>
                    </div>

                    <div class="relative" @click.outside="open = false">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="pointer-events-none absolute left-3.5 top-1/2 h-5 w-5 -translate-y-1/2 text-slate-400"
                             fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"/>
                        </svg>

                        <input
                            x-ref="searchInput"
                            type="text"
                            x-model="search"
                            @focus="open = true"
                            @input="open = true; highlighted = 0"
                            @keydown.arrow-down.prevent="move(1)"
                            @keydown.arrow-up.prevent="move(-1)"
                            @keydown.enter.prevent="selectHighlighted()"
                            @keydown.escape="open = false"
                            autocomplete="off"
                            placeholder="Search product name or SKU..."
                            class="w-full rounded-xl border border-slate-200 bg-slate-50 py-3.5 pl-11 pr-10 text-sm text-slate-900 outline-none transition focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-100"
                        >

                        <button type="button" x-show="search" @click="search = ''; $refs.searchInput.focus()"
                                class="absolute right-3 top-1/2 -translate-y-1/2 rounded-full p-1 text-slate-400 hover:bg-slate-100 hover:text-slate-600"
                                title="Clear">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>

                        {{-- DROPDOWN --}}
                        <div x-show="open" x-transition.opacity.duration.100ms x-cloak
                             class="absolute z-30 mt-2 max-h-96 w-full overflow-y-auto rounded-2xl border border-slate-200 bg-white p-1.5 shadow-xl">

                            <template x-for="(p, i) in filtered" :key="p.id">
                                <button type="button"
                                        @click="selectProduct(p)"
                                        @mouseenter="highlighted = i"
                                        :disabled="p.stock <= 0"
                                        :class="highlighted === i ? 'bg-green-50' : 'bg-white'"
                                        class="flex w-full items-center justify-between gap-3 rounded-xl px-3 py-2.5 text-left transition disabled:cursor-not-allowed disabled:opacity-50">

                                    <div class="flex min-w-0 items-center gap-3">
                                        <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-lg bg-green-100 text-sm font-bold text-green-700"
                                             x-text="p.name.charAt(0).toUpperCase()"></div>
                                        <div class="min-w-0">
                                            <p class="truncate text-sm font-semibold text-slate-900" x-text="p.name"></p>
                                            <p class="text-xs text-slate-500">
                                                SKU: <span x-text="p.sku || 'N/A'"></span>
                                                <template x-if="inCart(p.id)">
                                                    <span class="ml-2 font-semibold text-green-700">• in cart (<span x-text="inCart(p.id).quantity"></span>)</span>
                                                </template>
                                            </p>
                                        </div>
                                    </div>

                                    <div class="shrink-0 text-right">
                                        <p class="text-sm font-bold text-green-700">TSh <span x-text="formatMoney(p.price)"></span></p>
                                        <p class="text-xs" :class="p.stock > 0 ? 'text-slate-500' : 'font-semibold text-red-600'">
                                            <span x-show="p.stock > 0"><span x-text="p.stock"></span> <span x-text="p.unit"></span> left</span>
                                            <span x-show="p.stock <= 0">Out of stock</span>
                                        </p>
                                    </div>
                                </button>
                            </template>

                            <div x-show="filtered.length === 0" class="px-4 py-8 text-center">
                                <p class="text-sm font-semibold text-slate-700">No products found</p>
                                <p class="mt-1 text-xs text-slate-500">Try a different name or SKU.</p>
                            </div>
                        </div>
                    </div>

                    <p class="mt-3 text-xs text-slate-400">Tip: use ↑ ↓ to move and Enter to add the highlighted product.</p>
                </div>

                {{-- CART --}}
                <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

                    <div class="flex items-center justify-between border-b border-slate-100 p-5">
                        <div>
                            <h2 class="text-lg font-bold text-slate-900">Shopping Cart</h2>
                            <p class="text-sm text-slate-500">Review your selected products</p>
                        </div>
                        <button type="button" x-show="cart.length > 0" @click="clearCart()"
                                class="rounded-lg px-3 py-2 text-sm font-semibold text-red-600 transition hover:bg-red-50">
                            Clear Cart
                        </button>
                    </div>

                    {{-- Desktop --}}
                    <div x-show="cart.length > 0" class="hidden overflow-x-auto md:block">
                        <table class="w-full">
                            <thead class="bg-slate-50">
                                <tr class="text-left text-xs font-semibold text-slate-500">
                                    <th class="px-5 py-3">Product</th>
                                    <th class="px-5 py-3">Price</th>
                                    <th class="px-5 py-3">Quantity</th>
                                    <th class="px-5 py-3 text-right">Total</th>
                                    <th class="px-5 py-3"></th>
                                </tr>
                            </thead>
                            <tbody class="divide-y divide-slate-100">
                                <template x-for="(item, index) in cart" :key="item.id">
                                    <tr>
                                        <td class="px-5 py-4">
                                            <p class="font-semibold text-slate-900" x-text="item.name"></p>
                                            <p class="mt-1 text-xs text-slate-500">SKU: <span x-text="item.sku || 'N/A'"></span></p>
                                        </td>
                                        <td class="px-5 py-4 text-sm font-medium text-slate-700">
                                            TSh <span x-text="formatMoney(item.price)"></span>
                                        </td>
                                        <td class="px-5 py-4">
                                            <div class="flex w-fit items-center overflow-hidden rounded-xl border border-slate-200">
                                                <button type="button" @click="decreaseQty(index)" class="px-3 py-2 text-slate-600 transition hover:bg-slate-50">−</button>
                                                <input type="number" min="1" :max="item.stock"
                                                       x-model.number="item.quantity" @change="validateQty(index)"
                                                       class="w-14 border-x border-slate-200 py-2 text-center text-sm font-semibold text-slate-900 outline-none">
                                                <button type="button" @click="increaseQty(index)" class="px-3 py-2 text-slate-600 transition hover:bg-slate-50">+</button>
                                            </div>
                                            <p class="mt-1 text-xs text-slate-400">Max: <span x-text="item.stock"></span></p>
                                        </td>
                                        <td class="px-5 py-4 text-right font-bold text-slate-900">
                                            TSh <span x-text="formatMoney(item.price * item.quantity)"></span>
                                        </td>
                                        <td class="px-5 py-4 text-right">
                                            <button type="button" @click="removeItem(index)" class="rounded-lg p-2 text-red-500 transition hover:bg-red-50" title="Remove">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4h6v3m-9 0h12"/>
                                                </svg>
                                            </button>
                                        </td>
                                    </tr>
                                </template>
                            </tbody>
                        </table>
                    </div>

                    {{-- Mobile --}}
                    <div x-show="cart.length > 0" class="space-y-3 p-4 md:hidden">
                        <template x-for="(item, index) in cart" :key="'m-' + item.id">
                            <div class="rounded-2xl border border-slate-200 p-4">
                                <div class="flex items-start justify-between gap-3">
                                    <div class="min-w-0">
                                        <h3 class="font-semibold text-slate-900" x-text="item.name"></h3>
                                        <p class="mt-1 text-xs text-slate-500" x-text="item.sku || 'N/A'"></p>
                                    </div>
                                    <button type="button" @click="removeItem(index)" class="text-xs font-semibold text-red-500">Remove</button>
                                </div>
                                <div class="mt-4 flex items-center justify-between">
                                    <div class="text-sm text-slate-500">TSh <span x-text="formatMoney(item.price)"></span></div>
                                    <div class="flex items-center overflow-hidden rounded-xl border border-slate-200">
                                        <button type="button" @click="decreaseQty(index)" class="px-3 py-2">−</button>
                                        <span class="min-w-10 border-x border-slate-200 px-3 py-2 text-center text-sm font-semibold" x-text="item.quantity"></span>
                                        <button type="button" @click="increaseQty(index)" class="px-3 py-2">+</button>
                                    </div>
                                </div>
                                <div class="mt-4 flex items-center justify-between border-t border-slate-100 pt-3">
                                    <span class="text-sm text-slate-500">Total</span>
                                    <span class="font-bold text-green-700">TSh <span x-text="formatMoney(item.price * item.quantity)"></span></span>
                                </div>
                            </div>
                        </template>
                    </div>

                    {{-- Empty --}}
                    <div x-show="cart.length === 0" class="px-5 py-14 text-center">
                        <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2 2h12"/>
                            </svg>
                        </div>
                        <h3 class="mt-4 font-semibold text-slate-800">Your cart is empty</h3>
                        <p class="mt-1 text-sm text-slate-500">Search for a product above to add it to the cart.</p>
                    </div>
                </div>
            </div>

            {{-- ===================== RIGHT ===================== --}}
            <div class="space-y-6 xl:col-span-4">

                {{-- SUMMARY + PAYMENT --}}
                <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm xl:sticky xl:top-6">

                    <div class="mb-5 flex items-center justify-between">
                        <h2 class="font-bold text-slate-900">Order Summary</h2>
                        <span class="rounded-full bg-slate-100 px-2.5 py-1 text-xs font-semibold text-slate-600">{{ $invoiceNo }}</span>
                    </div>

                    <div class="space-y-4">
                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">Items</span>
                            <span class="font-semibold text-slate-800" x-text="cartQuantity"></span>
                        </div>

                        <div class="flex items-center justify-between text-sm">
                            <span class="text-slate-500">Subtotal</span>
                            <span class="font-semibold text-slate-800">TSh <span x-text="formatMoney(subtotal)"></span></span>
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-medium text-slate-700">Discount</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400">TSh</span>
                                <input type="number" name="discount" min="0" step="0.01" x-model.number="discount" placeholder="0"
                                       class="w-full rounded-xl border border-slate-200 py-3 pl-12 pr-4 text-sm text-slate-900 outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100">
                            </div>
                        </div>

                        <div class="border-t border-dashed border-slate-200 pt-4">
                            <div class="flex items-center justify-between">
                                <span class="text-base font-semibold text-slate-700">Total</span>
                                <span class="text-2xl font-bold text-green-700">TSh <span x-text="formatMoney(total)"></span></span>
                            </div>
                        </div>
                    </div>

                    {{-- PAYMENT --}}
                    <div class="mt-6 border-t border-slate-100 pt-5">
                        <label class="mb-2 block text-sm font-medium text-slate-700">Payment Method</label>

                        <div class="grid grid-cols-2 gap-2">
                            <template x-for="m in methods" :key="m.value">
                                <button type="button" @click="paymentMethod = m.value"
                                        :class="paymentMethod === m.value
                                            ? 'border-green-500 bg-green-50 text-green-700 ring-2 ring-green-100'
                                            : 'border-slate-200 bg-white text-slate-600 hover:bg-slate-50'"
                                        class="flex flex-col items-center gap-0.5 rounded-xl border px-3 py-3 text-center transition">
                                    <span class="text-2xl leading-none" x-text="m.emoji"></span>
                                    <span class="mt-1 text-sm font-semibold" x-text="m.label"></span>
                                    <span class="text-[11px] font-normal opacity-70" x-text="m.hint"></span>
                                </button>
                            </template>
                        </div>
                        <input type="hidden" name="payment_method" :value="paymentMethod">

                        <div class="mt-5">
                            <label class="mb-2 block text-sm font-medium text-slate-700">Amount Paid</label>
                            <div class="relative">
                                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-sm text-slate-400">TSh</span>
                                <input type="number" name="paid_amount" min="0" step="0.01" x-model.number="paidAmount" placeholder="0"
                                       class="w-full rounded-xl border border-slate-200 py-3 pl-12 pr-4 text-sm font-semibold text-slate-900 outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100">
                            </div>
                            <button type="button" @click="paidAmount = total" x-show="total > 0"
                                    class="mt-2 text-xs font-semibold text-green-700 hover:underline">
                                Pay exact amount
                            </button>
                        </div>

                        <div x-show="paymentMethod !== 'credit'" class="mt-4 rounded-xl bg-green-50 p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-green-700">Change</span>
                                <span class="text-lg font-bold text-green-700">TSh <span x-text="formatMoney(change)"></span></span>
                            </div>
                        </div>

                        <div x-show="balance > 0" class="mt-3 rounded-xl bg-amber-50 p-4">
                            <div class="flex items-center justify-between">
                                <span class="text-sm font-medium text-amber-700">Balance</span>
                                <span class="text-lg font-bold text-amber-700">TSh <span x-text="formatMoney(balance)"></span></span>
                            </div>
                        </div>

                        <div x-show="paymentError" x-text="paymentError" x-cloak
                             class="mt-3 rounded-xl bg-red-50 p-3 text-sm font-medium text-red-700"></div>

                        <button type="submit" :disabled="cart.length === 0 || submitting"
                                class="mt-5 flex w-full items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-3.5 text-sm font-bold text-white shadow-sm transition hover:bg-green-700 disabled:cursor-not-allowed disabled:bg-slate-300">
                            <svg x-show="!submitting" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                            </svg>
                            <svg x-show="submitting" class="h-5 w-5 animate-spin" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z"></path>
                            </svg>
                            <span x-text="submitting ? 'Processing Sale...' : 'Complete Sale'"></span>
                        </button>
                    </div>
                </div>

                <div class="rounded-2xl border border-green-100 bg-green-50 p-5">
                    <h3 class="font-semibold text-green-900">POS Information</h3>
                    <p class="mt-1 text-sm leading-6 text-green-800">
                        Product stock will be updated automatically after completing the sale.
                    </p>
                </div>
            </div>
        </div>

        {{-- HIDDEN CART INPUTS --}}
        <div>
            <template x-for="(item, index) in cart" :key="'hidden-' + item.id">
                <div>
                    <input type="hidden" :name="`items[${index}][product_id]`" :value="item.id">
                    <input type="hidden" :name="`items[${index}][quantity]`" :value="item.quantity">
                    <input type="hidden" :name="`items[${index}][unit_price]`" :value="item.price">
                    <input type="hidden" :name="`items[${index}][total]`" :value="item.price * item.quantity">
                </div>
            </template>

            <input type="hidden" name="subtotal" :value="subtotal">
            <input type="hidden" name="display_total" :value="total">
            <input type="hidden" name="display_change" :value="change">
            <input type="hidden" name="display_balance" :value="balance">
        </div>
    </form>
</div>

<style>[x-cloak]{display:none !important;}</style>

<script>
function posSystem() {
    return {
        products: @js($posProducts),

        search: '',
        open: false,
        highlighted: 0,

        customerId: '',
        cart: [],
        discount: 0,
        paymentMethod: 'cash',
        paidAmount: 0,
        submitting: false,
        paymentError: '',

        methods: [
            { value: 'cash',         emoji: '💵', label: 'Cash',         hint: 'Pesa taslimu' },
            { value: 'mobile_money', emoji: '📱', label: 'Mobile Money', hint: 'M-Pesa, Tigo, Airtel' },
            { value: 'bank',         emoji: '🏦', label: 'Bank',         hint: 'Uhamisho wa benki' },
            { value: 'credit',       emoji: '🧾', label: 'Credit',       hint: 'Lipa baadaye' },
        ],

        init() {
            // Credit hailazimishi malipo kamili
            this.$watch('paymentMethod', (m) => {
                if (m === 'credit') this.paymentError = '';
            });
        },

        /* ---------- SEARCH ---------- */
        get filtered() {
            const q = this.search.trim().toLowerCase();
            const list = q
                ? this.products.filter(p =>
                    String(p.name ?? '').toLowerCase().includes(q) ||
                    String(p.sku ?? '').toLowerCase().includes(q))
                : this.products;
            return list.slice(0, 50);
        },

        move(step) {
            const n = this.filtered.length;
            if (!n) return;
            this.open = true;
            this.highlighted = (this.highlighted + step + n) % n;
        },

        selectHighlighted() {
            const p = this.filtered[this.highlighted];
            if (p) this.selectProduct(p);
        },

        selectProduct(p) {
            this.addProduct(p);
            this.search = '';
            this.highlighted = 0;
            this.$refs.searchInput.focus();
        },

        inCart(id) {
            return this.cart.find(i => Number(i.id) === Number(id));
        },

        /* ---------- TOTALS ---------- */
        get subtotal() {
            return this.cart.reduce((s, i) => s + Number(i.price) * Number(i.quantity), 0);
        },
        get total() {
            const sub = Number(this.subtotal) || 0;
            const disc = Math.min(Math.max(Number(this.discount) || 0, 0), sub);
            return Math.max(sub - disc, 0);
        },
        get change() {
            return Math.max((Number(this.paidAmount) || 0) - this.total, 0);
        },
        get balance() {
            return Math.max(this.total - (Number(this.paidAmount) || 0), 0);
        },
        get cartQuantity() {
            return this.cart.reduce((s, i) => s + Number(i.quantity), 0);
        },

        /* ---------- CART ---------- */
        addProduct(product) {
            if (!product || Number(product.stock) <= 0) return;

            const existing = this.inCart(product.id);
            if (existing) {
                if (Number(existing.quantity) < Number(existing.stock)) existing.quantity++;
                return;
            }

            this.cart.push({
                id: Number(product.id),
                name: product.name,
                sku: product.sku || '',
                price: Number(product.price) || 0,
                stock: Number(product.stock) || 0,
                unit: product.unit || 'pcs',
                quantity: 1,
            });
        },

        increaseQty(index) {
            const item = this.cart[index];
            if (item && Number(item.quantity) < Number(item.stock)) item.quantity++;
        },

        decreaseQty(index) {
            const item = this.cart[index];
            if (item && Number(item.quantity) > 1) item.quantity--;
        },

        validateQty(index) {
            const item = this.cart[index];
            if (!item) return;
            let q = Number(item.quantity);
            if (!q || q < 1) q = 1;
            if (q > Number(item.stock)) q = Number(item.stock);
            item.quantity = q;
        },

        removeItem(index) {
            this.cart.splice(index, 1);
        },

        clearCart() {
            if (this.cart.length && confirm('Clear all products from the cart?')) {
                this.cart = [];
            }
        },

        formatMoney(value) {
            return new Intl.NumberFormat('en-US', {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }).format(Number(value) || 0);
        },

        /* ---------- SUBMIT ---------- */
        prepareSale(event) {
            this.paymentError = '';

            if (this.cart.length === 0) {
                this.paymentError = 'Please add at least one product.';
                event.preventDefault();
                return;
            }
            if (this.total <= 0) {
                this.paymentError = 'Sale total must be greater than zero.';
                event.preventDefault();
                return;
            }
            if (this.paymentMethod !== 'credit' && Number(this.paidAmount) < this.total) {
                this.paymentError = 'Amount paid is less than the sale total.';
                event.preventDefault();
                return;
            }
            if (Number(this.discount) < 0) this.discount = 0;

            this.submitting = true;
        },
    };
}
</script>

@endsection
