@extends('layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard')

@section('content')

<div
    x-data="dashboardClock()"
    x-init="startClock()"
    class="space-y-6"
>

{{-- =========================================================
    DASHBOARD HEADER
========================================================== --}}
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="flex flex-col gap-6 p-6 lg:flex-row lg:items-center lg:justify-between">

        {{-- Greeting --}}
        <div class="flex items-center gap-4">

            <div
                class="flex h-14 w-14 shrink-0 items-center justify-center rounded-2xl text-2xl transition-colors duration-300"
                :class="
                    period === 'morning'
                        ? 'bg-amber-50'
                        : period === 'afternoon'
                            ? 'bg-blue-50'
                            : 'bg-indigo-50'
                "
            >
                <span x-text="greetingIcon"></span>
            </div>

            <div>

                <p class="text-sm font-medium text-slate-500">
                    <span x-text="greeting"></span>,
                    {{ Auth::user()->name }} 👋
                </p>

                <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                    Dashboard
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Here's what's happening with your shop today.
                </p>

            </div>

        </div>


        {{-- Date + Time --}}
        <div class="flex items-center gap-4">

            <div class="hidden border-r border-slate-200 pr-5 text-right sm:block">

                <p
                    class="text-sm font-semibold text-slate-800"
                    x-text="dayName"
                ></p>

                <p
                    class="mt-1 text-xs text-slate-500"
                    x-text="fullDate"
                ></p>

            </div>

            <div class="flex items-center gap-3">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-50 text-lg">
                    🕐
                </div>

                <div>

                    <p
                        class="text-2xl font-bold tracking-tight text-slate-900"
                        x-text="time"
                    ></p>

                    <p class="mt-0.5 text-xs font-medium text-green-600">
                        Tanzania Time
                    </p>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    MAIN STATISTICS
========================================================== --}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">


    {{-- =====================================================
        TOTAL SALES
    ====================================================== --}}
    <a
        href="{{ route('sales.history') }}"
        class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
    >

        <div class="p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Total Sales
                    </p>

                    <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-900">
                        {{ number_format($totalSales ?? 0) }}
                    </h3>

                    <p class="mt-3 text-xs text-slate-400">
                        All transactions
                    </p>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-50 text-xl transition-transform duration-300 group-hover:scale-110">
                    💰
                </div>

            </div>

        </div>

        {{-- Bottom Color --}}
        <div class="h-1.5 bg-green-500"></div>

    </a>


    {{-- =====================================================
        TOTAL REVENUE
    ====================================================== --}}
    <div
        class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
    >

        <div class="p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Total Revenue
                    </p>

                    <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-900">
                        TSh {{ number_format($totalRevenue ?? 0, 0) }}
                    </h3>

                    <p class="mt-3 text-xs text-slate-400">
                        Revenue from all sales
                    </p>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-xl transition-transform duration-300 group-hover:scale-110">
                    📈
                </div>

            </div>

        </div>

        {{-- Bottom Color --}}
        <div class="h-1.5 bg-emerald-500"></div>

    </div>


    {{-- =====================================================
        TOTAL PRODUCTS
    ====================================================== --}}
    <a
        href="{{ route('products.index') }}"
        class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
    >

        <div class="p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Total Products
                    </p>

                    <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-900">
                        {{ number_format($totalProducts ?? 0) }}
                    </h3>

                    <p class="mt-3 text-xs text-slate-400">
                        {{ number_format($activeProducts ?? 0) }} active products
                    </p>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-xl transition-transform duration-300 group-hover:scale-110">
                    📦
                </div>

            </div>

        </div>

        {{-- Bottom Color --}}
        <div class="h-1.5 bg-blue-500"></div>

    </a>


    {{-- =====================================================
        CUSTOMERS
    ====================================================== --}}
    <a
        href="{{ route('customers.index') }}"
        class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
    >

        <div class="p-6">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Customers
                    </p>

                    <h3 class="mt-3 text-2xl font-bold tracking-tight text-slate-900">
                        {{ number_format($totalCustomers ?? 0) }}
                    </h3>

                    <p class="mt-3 text-xs text-slate-400">
                        Registered customers
                    </p>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-purple-50 text-xl transition-transform duration-300 group-hover:scale-110">
                    👥
                </div>

            </div>

        </div>

        {{-- Bottom Color --}}
        <div class="h-1.5 bg-purple-500"></div>

    </a>

</div>


{{-- =========================================================
    TODAY / MONTH / STOCK STATISTICS
========================================================== --}}
<div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">


    {{-- =====================================================
        TODAY'S SALES
    ====================================================== --}}
    <div
        class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
    >

        <div class="p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Today's Sales
                    </p>

                    <h3 class="mt-2 text-xl font-bold text-slate-900">
                        {{ number_format($todaySales ?? 0) }}
                    </h3>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-50 text-lg transition-transform group-hover:scale-110">
                    🛒
                </div>

            </div>

            <p class="mt-3 text-xs text-slate-400">
                TSh {{ number_format($todayRevenue ?? 0, 0) }} revenue
            </p>

        </div>

        {{-- Bottom Color --}}
        <div class="h-1.5 bg-green-500"></div>

    </div>


    {{-- =====================================================
        MONTHLY SALES
    ====================================================== --}}
    <div
        class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
    >

        <div class="p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Monthly Sales
                    </p>

                    <h3 class="mt-2 text-xl font-bold text-slate-900">
                        {{ number_format($monthlySales ?? 0) }}
                    </h3>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-lg transition-transform group-hover:scale-110">
                    📊
                </div>

            </div>

            <p class="mt-3 text-xs text-slate-400">
                TSh {{ number_format($monthlyRevenue ?? 0, 0) }} revenue
            </p>

        </div>

        {{-- Bottom Color --}}
        <div class="h-1.5 bg-blue-500"></div>

    </div>


    {{-- =====================================================
        TOTAL STOCK
    ====================================================== --}}
    <div
        class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
    >

        <div class="p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Total Stock
                    </p>

                    <h3 class="mt-2 text-xl font-bold text-slate-900">
                        {{ number_format($totalStock ?? 0) }}
                    </h3>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-indigo-50 text-lg transition-transform group-hover:scale-110">
                    📦
                </div>

            </div>

            <p class="mt-3 text-xs text-slate-400">
                Units currently available
            </p>

        </div>

        {{-- Bottom Color --}}
        <div class="h-1.5 bg-indigo-500"></div>

    </div>


    {{-- =====================================================
        LOW STOCK
    ====================================================== --}}
    <a
        href="{{ route('inventory.index') }}"
        class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-lg"
    >

        <div class="p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Low Stock
                    </p>

                    <h3 class="mt-2 text-xl font-bold text-slate-900">
                        {{ number_format($lowStockProducts ?? 0) }}
                    </h3>

                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-lg transition-transform group-hover:scale-110">
                    ⚠️
                </div>

            </div>

            <p class="mt-3 text-xs text-slate-400">
                Products need attention
            </p>

        </div>

        {{-- Bottom Color --}}
        <div class="h-1.5 bg-orange-500"></div>

    </a>

</div>


{{-- =========================================================
    OUT OF STOCK BANNER
========================================================== --}}
@if(($outOfStockProducts ?? 0) > 0)

    <a
        href="{{ route('inventory.index') }}"
        class="group flex items-center justify-between rounded-2xl border border-red-200 bg-red-50 px-6 py-4 transition hover:bg-red-100"
    >

        <div class="flex items-center gap-4">

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-100 text-xl">
                🚨
            </div>

            <div>

                <p class="text-sm font-bold text-red-800">
                    Out of Stock Alert
                </p>

                <p class="mt-1 text-xs text-red-600">
                    {{ number_format($outOfStockProducts) }}
                    product(s) are currently out of stock.
                </p>

            </div>

        </div>

        <span class="text-sm font-semibold text-red-700 group-hover:underline">
            View Inventory →
        </span>

    </a>

@endif


{{-- =========================================================
    SALES OVERVIEW + PAYMENT METHODS
========================================================== --}}
<div class="grid grid-cols-1 gap-6 xl:grid-cols-3">


    {{-- =====================================================
        SALES OVERVIEW
    ====================================================== --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm xl:col-span-2">

        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

            <div>

                <h2 class="text-base font-bold text-slate-900">
                    Sales Overview
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Revenue performance for the last 7 days
                </p>

            </div>

            <div class="rounded-lg bg-green-50 px-3 py-2 text-xs font-semibold text-green-700">
                Last 7 Days
            </div>

        </div>

        <div class="p-6">

            <div class="h-80">
                <canvas id="salesChart"></canvas>
            </div>

        </div>

    </div>


    {{-- =====================================================
        PAYMENT METHODS
    ====================================================== --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-100 px-6 py-5">

            <h2 class="text-base font-bold text-slate-900">
                Payment Methods
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Revenue by payment method
            </p>

        </div>

        <div class="p-6">

            <div class="mx-auto h-64 max-w-xs">
                <canvas id="paymentChart"></canvas>
            </div>

            <div class="mt-5 space-y-3">

                {{-- Cash --}}
                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-2">

                        <span class="h-2.5 w-2.5 rounded-full bg-green-500"></span>

                        <span class="text-sm text-slate-500">
                            Cash
                        </span>

                    </div>

                    <span class="font-semibold text-slate-800">
                        TSh {{ number_format($cashSales ?? 0, 0) }}
                    </span>

                </div>


                {{-- Mobile Money --}}
                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-2">

                        <span class="h-2.5 w-2.5 rounded-full bg-blue-500"></span>

                        <span class="text-sm text-slate-500">
                            Mobile Money
                        </span>

                    </div>

                    <span class="font-semibold text-slate-800">
                        TSh {{ number_format($mobileMoneySales ?? 0, 0) }}
                    </span>

                </div>


                {{-- Bank --}}
                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-2">

                        <span class="h-2.5 w-2.5 rounded-full bg-purple-500"></span>

                        <span class="text-sm text-slate-500">
                            Bank
                        </span>

                    </div>

                    <span class="font-semibold text-slate-800">
                        TSh {{ number_format($bankSales ?? 0, 0) }}
                    </span>

                </div>


                {{-- Credit --}}
                <div class="flex items-center justify-between">

                    <div class="flex items-center gap-2">

                        <span class="h-2.5 w-2.5 rounded-full bg-orange-500"></span>

                        <span class="text-sm text-slate-500">
                            Credit
                        </span>

                    </div>

                    <span class="font-semibold text-slate-800">
                        TSh {{ number_format($creditSales ?? 0, 0) }}
                    </span>

                </div>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    STOCK ALERTS
========================================================== --}}
<div class="grid grid-cols-1 gap-6 xl:grid-cols-2">


    {{-- =====================================================
        LOW STOCK PRODUCTS
    ====================================================== --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

            <div>

                <h2 class="text-base font-bold text-slate-900">
                    Low Stock Products
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Products below minimum stock level
                </p>

            </div>

            <a
                href="{{ route('inventory.index') }}"
                class="text-xs font-semibold text-green-600 hover:text-green-700"
            >
                View All
            </a>

        </div>


        <div class="divide-y divide-slate-100">

            @forelse($lowStockList ?? [] as $product)

                <div class="flex items-center justify-between px-6 py-4 transition hover:bg-slate-50">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-orange-50 text-lg">
                            📦
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-slate-800">
                                {{ $product->name }}
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                Minimum stock:
                                {{ number_format($product->minimum_stock ?? 0) }}
                            </p>

                        </div>

                    </div>

                    <span class="rounded-full bg-orange-50 px-3 py-1 text-xs font-semibold text-orange-700">
                        {{ number_format($product->quantity ?? 0) }}
                        left
                    </span>

                </div>

            @empty

                <div class="px-6 py-10 text-center">

                    <div class="text-3xl">
                        ✅
                    </div>

                    <p class="mt-2 text-sm font-semibold text-slate-700">
                        No low stock products
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Your inventory is looking good.
                    </p>

                </div>

            @endforelse

        </div>

    </div>


    {{-- =====================================================
        OUT OF STOCK PRODUCTS
    ====================================================== --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="flex items-center justify-between border-b border-slate-100 px-6 py-5">

            <div>

                <h2 class="text-base font-bold text-slate-900">
                    Out of Stock
                </h2>

                <p class="mt-1 text-xs text-slate-500">
                    Products currently unavailable
                </p>

            </div>

            <a
                href="{{ route('inventory.index') }}"
                class="text-xs font-semibold text-red-600 hover:text-red-700"
            >
                View Inventory
            </a>

        </div>


        <div class="divide-y divide-slate-100">

            @forelse($outOfStockList ?? [] as $product)

                <div class="flex items-center justify-between px-6 py-4 transition hover:bg-slate-50">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-red-50 text-lg">
                            🚫
                        </div>

                        <div>

                            <p class="text-sm font-semibold text-slate-800">
                                {{ $product->name }}
                            </p>

                            <p class="mt-1 text-xs text-slate-400">
                                {{ $product->sku ?? 'No SKU' }}
                            </p>

                        </div>

                    </div>

                    <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                        Out of Stock
                    </span>

                </div>

            @empty

                <div class="px-6 py-10 text-center">

                    <div class="text-3xl">
                        🎉
                    </div>

                    <p class="mt-2 text-sm font-semibold text-slate-700">
                        No out-of-stock products
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        All products currently have stock.
                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>


{{-- =========================================================
    RECENT SALES
========================================================== --}}
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="flex flex-col gap-3 border-b border-slate-100 px-6 py-5 sm:flex-row sm:items-center sm:justify-between">

        <div>

            <h2 class="text-base font-bold text-slate-900">
                Recent Sales
            </h2>

            <p class="mt-1 text-xs text-slate-500">
                Latest transactions from your shop
            </p>

        </div>

        <a
            href="{{ route('sales.history') }}"
            class="text-sm font-semibold text-green-600 hover:text-green-700"
        >
            View All Sales →
        </a>

    </div>


    <div class="overflow-x-auto">

        <table class="w-full min-w-[800px]">

            <thead>

            <tr class="border-b border-slate-100 bg-slate-50/70">

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Invoice
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Customer
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Date
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Amount
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Payment
                </th>

                <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                    Status
                </th>

            </tr>

            </thead>


            <tbody class="divide-y divide-slate-100">

            @forelse($recentSales ?? [] as $sale)

                @php

                    $customerName = $sale->customer?->name
                        ?? 'Walk-in Customer';

                    $initials = collect(
                        preg_split('/\s+/', trim($customerName))
                    )
                    ->filter()
                    ->take(2)
                    ->map(
                        fn ($word) =>
                        strtoupper(substr($word, 0, 1))
                    )
                    ->implode('');

                    $status = strtolower(
                        $sale->status ?? 'completed'
                    );

                @endphp


                <tr class="transition hover:bg-slate-50">

                    {{-- Invoice --}}
                    <td class="px-6 py-4">

                        <a
                            href="{{ route('sales.show', $sale->id) }}"
                            class="text-sm font-semibold text-green-700 hover:text-green-800 hover:underline"
                        >
                            {{ $sale->invoice_number }}
                        </a>

                    </td>


                    {{-- Customer --}}
                    <td class="px-6 py-4">

                        <div class="flex items-center gap-3">

                            <div class="flex h-9 w-9 items-center justify-center rounded-full bg-green-100 text-xs font-bold text-green-700">
                                {{ $initials ?: 'WC' }}
                            </div>

                            <div>

                                <p class="text-sm font-medium text-slate-800">
                                    {{ $customerName }}
                                </p>

                                @if($sale->customer?->phone)

                                    <p class="text-xs text-slate-400">
                                        {{ $sale->customer->phone }}
                                    </p>

                                @else

                                    <p class="text-xs text-slate-400">
                                        Walk-in Customer
                                    </p>

                                @endif

                            </div>

                        </div>

                    </td>


                    {{-- Date --}}
                    <td class="px-6 py-4 text-sm text-slate-500">

                        <div>
                            {{ $sale->created_at?->format('d M Y') }}
                        </div>

                        <div class="mt-1 text-xs text-slate-400">
                            {{ $sale->created_at?->format('h:i A') }}
                        </div>

                    </td>


                    {{-- Amount --}}
                    <td class="px-6 py-4">

                        <span class="text-sm font-bold text-slate-800">
                            TSh {{ number_format($sale->total ?? 0, 0) }}
                        </span>

                    </td>


                    {{-- Payment --}}
                    <td class="px-6 py-4">

                        <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold capitalize text-blue-700">
                            {{ str_replace('_', ' ', $sale->payment_method ?? 'N/A') }}
                        </span>

                    </td>


                    {{-- Status --}}
                    <td class="px-6 py-4">

                        <span
                            class="inline-flex rounded-full px-3 py-1 text-xs font-semibold
                            {{
                                in_array($status, ['completed', 'paid'])
                                    ? 'bg-green-50 text-green-700'
                                    : ($status === 'pending'
                                        ? 'bg-yellow-50 text-yellow-700'
                                        : 'bg-red-50 text-red-700')
                            }}"
                        >
                            {{ ucfirst($status) }}
                        </span>

                    </td>

                </tr>

            @empty

                <tr>

                    <td
                        colspan="6"
                        class="px-6 py-12 text-center"
                    >

                        <div class="text-4xl">
                            🧾
                        </div>

                        <p class="mt-3 text-sm font-semibold text-slate-700">
                            No sales yet
                        </p>

                        <p class="mt-1 text-xs text-slate-400">
                            Sales will appear here after you create a transaction.
                        </p>

                        <a
                            href="{{ route('sales.pos') }}"
                            class="mt-4 inline-flex items-center rounded-lg bg-green-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-green-700"
                        >
                            Create First Sale
                        </a>

                    </td>

                </tr>

            @endforelse

            </tbody>

        </table>

    </div>

</div>


{{-- =========================================================
    QUICK ACTIONS
========================================================== --}}
<div>

    <div class="mb-4">

        <h2 class="text-base font-bold text-slate-900">
            Quick Actions
        </h2>

        <p class="mt-1 text-xs text-slate-500">
            Frequently used shop operations
        </p>

    </div>


    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">


        {{-- Create Sale --}}
        <a
            href="{{ route('sales.pos') }}"
            class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-green-200 hover:shadow-lg"
        >

            <div class="flex items-center gap-4">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-50 text-xl transition-transform group-hover:scale-110">
                    🛒
                </div>

                <div>

                    <p class="text-sm font-bold text-slate-800">
                        Create Sale
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Start new transaction
                    </p>

                </div>

            </div>

            <div class="absolute bottom-0 left-0 right-0 h-1 bg-green-500"></div>

        </a>


        {{-- Add Product --}}
        <a
            href="{{ route('products.create') }}"
            class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-blue-200 hover:shadow-lg"
        >

            <div class="flex items-center gap-4">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-50 text-xl transition-transform group-hover:scale-110">
                    📦
                </div>

                <div>

                    <p class="text-sm font-bold text-slate-800">
                        Add Product
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Add new inventory item
                    </p>

                </div>

            </div>

            <div class="absolute bottom-0 left-0 right-0 h-1 bg-blue-500"></div>

        </a>


        {{-- Add Customer --}}
        <a
            href="{{ route('customers.create') }}"
            class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-purple-200 hover:shadow-lg"
        >

            <div class="flex items-center gap-4">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-50 text-xl transition-transform group-hover:scale-110">
                    👤
                </div>

                <div>

                    <p class="text-sm font-bold text-slate-800">
                        Add Customer
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Register new customer
                    </p>

                </div>

            </div>

            <div class="absolute bottom-0 left-0 right-0 h-1 bg-purple-500"></div>

        </a>


        {{-- Reports --}}
        <a
            href="{{ route('reports.index') }}"
            class="group relative overflow-hidden rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition-all duration-300 hover:-translate-y-1 hover:border-orange-200 hover:shadow-lg"
        >

            <div class="flex items-center gap-4">

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-orange-50 text-xl transition-transform group-hover:scale-110">
                    📊
                </div>

                <div>

                    <p class="text-sm font-bold text-slate-800">
                        View Reports
                    </p>

                    <p class="mt-1 text-xs text-slate-400">
                        Analyze shop performance
                    </p>

                </div>

            </div>

            <div class="absolute bottom-0 left-0 right-0 h-1 bg-orange-500"></div>

        </a>

    </div>

</div>


</div>

{{-- =========================================================
CHART.JS
========================================================== --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>

document.addEventListener('DOMContentLoaded', function () {

    /*
    |--------------------------------------------------------------------------
    | SALES CHART
    |--------------------------------------------------------------------------
    */

    const salesCanvas = document.getElementById('salesChart');

    if (salesCanvas) {

        const salesData = @json($salesChart ?? []);

        new Chart(salesCanvas, {

            type: 'line',

            data: {

                labels: salesData.map(item => item.date),

                datasets: [

                    {
                        label: 'Revenue',

                        data: salesData.map(
                            item => Number(item.revenue)
                        ),

                        borderColor: '#16A34A',

                        backgroundColor: 'rgba(22, 163, 74, 0.10)',

                        borderWidth: 3,

                        tension: 0.4,

                        fill: true,

                        pointBackgroundColor: '#16A34A',

                        pointBorderColor: '#ffffff',

                        pointBorderWidth: 2,

                        pointRadius: 4,

                        pointHoverRadius: 6

                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                interaction: {
                    intersect: false,
                    mode: 'index'
                },

                plugins: {

                    legend: {
                        display: false
                    },

                    tooltip: {

                        backgroundColor: '#0F172A',

                        padding: 12,

                        callbacks: {

                            label: function(context) {

                                return 'Revenue: TSh ' +
                                    Number(context.raw)
                                    .toLocaleString();

                            }

                        }

                    }

                },

                scales: {

                    x: {

                        grid: {
                            display: false
                        },

                        ticks: {

                            color: '#64748B',

                            font: {
                                size: 11
                            }

                        }

                    },

                    y: {

                        beginAtZero: true,

                        grid: {

                            color: '#E2E8F0',

                            borderDash: [4, 4]

                        },

                        ticks: {

                            color: '#64748B',

                            font: {
                                size: 11
                            },

                            callback: function(value) {

                                return 'TSh ' +
                                    Number(value).toLocaleString();

                            }

                        }

                    }

                }

            }

        });

    }


    /*
    |--------------------------------------------------------------------------
    | PAYMENT METHODS DOUGHNUT
    |--------------------------------------------------------------------------
    */

    const paymentCanvas =
        document.getElementById('paymentChart');

    if (paymentCanvas) {

        new Chart(paymentCanvas, {

            type: 'doughnut',

            data: {

                labels: [

                    'Cash',

                    'Mobile Money',

                    'Bank',

                    'Credit'

                ],

                datasets: [

                    {

                        data: [

                            Number({{ $cashSales ?? 0 }}),

                            Number({{ $mobileMoneySales ?? 0 }}),

                            Number({{ $bankSales ?? 0 }}),

                            Number({{ $creditSales ?? 0 }})

                        ],

                        backgroundColor: [

                            '#16A34A',

                            '#2563EB',

                            '#9333EA',

                            '#F59E0B'

                        ],

                        borderWidth: 0,

                        hoverOffset: 8

                    }

                ]

            },

            options: {

                responsive: true,

                maintainAspectRatio: false,

                cutout: '68%',

                plugins: {

                    legend: {

                        display: false

                    },

                    tooltip: {

                        callbacks: {

                            label: function(context) {

                                return ' TSh ' +
                                    Number(context.raw)
                                    .toLocaleString();

                            }

                        }

                    }

                }

            }

        });

    }

});


/*
|--------------------------------------------------------------------------
| DASHBOARD CLOCK
|--------------------------------------------------------------------------
*/

function dashboardClock() {

    return {

        time: '',

        fullDate: '',

        dayName: '',

        greeting: '',

        greetingIcon: '🌅',

        period: 'morning',


        startClock() {

            this.updateClock();

            setInterval(() => {

                this.updateClock();

            }, 1000);

        },


        updateClock() {

            const now = new Date();

            const timezone = {
                timeZone: 'Africa/Dar_es_Salaam'
            };


            this.time = new Intl.DateTimeFormat(
                'en-US',
                {

                    ...timezone,

                    hour: '2-digit',

                    minute: '2-digit',

                    second: '2-digit',

                    hour12: true

                }
            ).format(now);


            this.dayName = new Intl.DateTimeFormat(
                'en-US',
                {

                    ...timezone,

                    weekday: 'long'

                }
            ).format(now);


            this.fullDate = new Intl.DateTimeFormat(
                'en-US',
                {

                    ...timezone,

                    day: '2-digit',

                    month: 'long',

                    year: 'numeric'

                }
            ).format(now);


            const hour = Number(

                new Intl.DateTimeFormat(
                    'en-US',
                    {

                        ...timezone,

                        hour: 'numeric',

                        hour12: false

                    }
                ).format(now)

            );


            if (hour >= 5 && hour < 12) {

                this.greeting = 'Good Morning';

                this.greetingIcon = '🌅';

                this.period = 'morning';

            }

            else if (hour >= 12 && hour < 18) {

                this.greeting = 'Good Afternoon';

                this.greetingIcon = '☀️';

                this.period = 'afternoon';

            }

            else {

                this.greeting = 'Good Evening';

                this.greetingIcon = '🌙';

                this.period = 'evening';

            }

        }

    }

}

</script>

@endsection
