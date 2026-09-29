
@extends('layouts.app')

@section('title', 'Reports')

@section('page-title', 'Reports')

@section('content')

<div class="min-h-screen bg-slate-50">

    <div class="space-y-6">

        {{-- =========================================================
            HEADER
        ========================================================== --}}

        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <div>

                <div class="flex items-center gap-3">

                    <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-green-100 text-green-700">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-6 w-6"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="1.8"
                                  d="M3 3v18h18M7 16v-5m5 5V7m5 9V4"/>

                        </svg>

                    </div>

                    <div>

                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                            Sales Reports
                        </h1>

                        <p class="text-sm text-slate-500">
                            Monitor sales performance and business activity
                        </p>

                    </div>

                </div>

            </div>


            {{-- ACTIONS --}}

            <div class="flex flex-wrap items-center gap-2">

                <button
                    onclick="window.print()"
                    class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M6 9V2h12v7M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5h-2M6 14h12v8H6z"/>

                    </svg>

                    Print
                </button>


                <a
                    href="{{ route('reports.export.csv', request()->query()) }}"
                    class="inline-flex items-center gap-2 rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 3v12m0 0l-4-4m4 4l4-4M5 21h14"/>

                    </svg>

                    Download CSV
                </a>

            </div>

        </div>


        {{-- =========================================================
            FILTER CARD
        ========================================================== --}}

        <form
            method="GET"
            action="{{ route('reports.index') }}"
            class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex flex-col gap-4">

                <div class="flex items-center gap-2">

                    <div class="flex h-9 w-9 items-center justify-center rounded-xl bg-slate-100">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5 text-slate-600"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 12.414V19l-6 3v-9.586L3.293 6.707A1 1 0 013 6V4z"/>

                        </svg>

                    </div>

                    <div>

                        <h2 class="font-bold text-slate-900">
                            Report Filters
                        </h2>

                        <p class="text-xs text-slate-500">
                            Select the period and payment method
                        </p>

                    </div>

                </div>


                <div class="grid grid-cols-1 gap-3 md:grid-cols-2 lg:grid-cols-5">


                    {{-- PERIOD --}}

                    <div>

                        <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Period
                        </label>

                        <select
                            name="filter"
                            id="filter"
                            onchange="toggleCustomDates()"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-800 outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100">

                            <option value="today" {{ $filter === 'today' ? 'selected' : '' }}>
                                Today
                            </option>

                            <option value="week" {{ $filter === 'week' ? 'selected' : '' }}>
                                This Week
                            </option>

                            <option value="month" {{ $filter === 'month' ? 'selected' : '' }}>
                                This Month
                            </option>

                            <option value="last_month" {{ $filter === 'last_month' ? 'selected' : '' }}>
                                Last Month
                            </option>

                            <option value="year" {{ $filter === 'year' ? 'selected' : '' }}>
                                This Year
                            </option>

                            <option value="custom" {{ $filter === 'custom' ? 'selected' : '' }}>
                                Custom Range
                            </option>

                        </select>

                    </div>


                    {{-- FROM --}}

                    <div id="fromWrapper">

                        <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            From
                        </label>

                        <input
                            type="date"
                            name="from"
                            value="{{ request('from') }}"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100">

                    </div>


                    {{-- TO --}}

                    <div id="toWrapper">

                        <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            To
                        </label>

                        <input
                            type="date"
                            name="to"
                            value="{{ request('to') }}"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm text-slate-800 outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100">

                    </div>


                    {{-- PAYMENT --}}

                    <div>

                        <label class="mb-2 block text-xs font-semibold uppercase tracking-wide text-slate-500">
                            Payment
                        </label>

                        <select
                            name="payment_method"
                            class="w-full rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-800 outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100">

                            <option value="">
                                All Payments
                            </option>

                            <option value="cash"
                                {{ request('payment_method') === 'cash' ? 'selected' : '' }}>
                                Cash
                            </option>

                            <option value="mobile_money"
                                {{ request('payment_method') === 'mobile_money' ? 'selected' : '' }}>
                                Mobile Money
                            </option>

                            <option value="bank"
                                {{ request('payment_method') === 'bank' ? 'selected' : '' }}>
                                Bank
                            </option>

                            <option value="credit"
                                {{ request('payment_method') === 'credit' ? 'selected' : '' }}>
                                Credit
                            </option>

                        </select>

                    </div>


                    {{-- APPLY --}}

                    <div class="flex items-end">

                        <button
                            type="submit"
                            class="flex w-full items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-3 text-sm font-bold text-white transition hover:bg-slate-800">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                 class="h-4 w-4"
                                 fill="none"
                                 viewBox="0 0 24 24"
                                 stroke="currentColor">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M21 21l-4.35-4.35m2.35-5.65a8 8 0 11-16 0 8 8 0 0116 0z"/>

                            </svg>

                            Apply Filter

                        </button>

                    </div>

                </div>

            </div>

        </form>


        {{-- =========================================================
            REPORT PERIOD
        ========================================================== --}}

        <div class="flex flex-wrap items-center justify-between gap-3">

            <div>

                <p class="text-sm text-slate-500">
                    Reporting period
                </p>

                <p class="font-bold text-slate-900">

                    {{ $from->format('d M Y') }}

                    <span class="font-normal text-slate-400">
                        →
                    </span>

                    {{ $to->format('d M Y') }}

                </p>

            </div>


            <div class="rounded-full bg-green-50 px-4 py-2 text-xs font-bold text-green-700">

                {{ $numberOfSales }} Sales

            </div>

        </div>


        {{-- =========================================================
            STAT CARDS
        ========================================================== --}}

        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">


            {{-- SALES --}}

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Total Sales
                        </p>

                        <h3 class="mt-2 text-2xl font-black text-slate-900">
                            TSh {{ number_format($totalSales, 0) }}
                        </h3>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-green-700">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-10V4m0 16v-2m7-6a7 7 0 11-14 0 7 7 0 0114 0z"/>

                        </svg>

                    </div>

                </div>

                <p class="mt-4 text-xs text-slate-400">
                    Gross sales for selected period
                </p>

            </div>


            {{-- NUMBER SALES --}}

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Transactions
                        </p>

                        <h3 class="mt-2 text-2xl font-black text-slate-900">
                            {{ number_format($numberOfSales) }}
                        </h3>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-700">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h8l5 5v11a2 2 0 01-2 2z"/>

                        </svg>

                    </div>

                </div>

                <p class="mt-4 text-xs text-slate-400">
                    Completed sales transactions
                </p>

            </div>


            {{-- AVERAGE --}}

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Average Sale
                        </p>

                        <h3 class="mt-2 text-2xl font-black text-slate-900">
                            TSh {{ number_format($averageSale, 0) }}
                        </h3>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-100 text-purple-700">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M7 20V10m5 10V4m5 16v-7"/>

                        </svg>

                    </div>

                </div>

                <p class="mt-4 text-xs text-slate-400">
                    Average value per transaction
                </p>

            </div>


            {{-- CUSTOMERS --}}

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between">

                    <div>

                        <p class="text-sm font-medium text-slate-500">
                            Customers
                        </p>

                        <h3 class="mt-2 text-2xl font-black text-slate-900">
                            {{ number_format($totalCustomers) }}
                        </h3>

                    </div>

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100 text-amber-700">

                        <svg xmlns="http://www.w3.org/2000/svg"
                             class="h-5 w-5"
                             fill="none"
                             viewBox="0 0 24 24"
                             stroke="currentColor">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17 20h5v-2a4 4 0 00-4-4h-1m-4 6H6a4 4 0 01-4-4v-1a4 4 0 014-4h7a4 4 0 014 4v1a4 4 0 01-4 4zM9.5 9a4 4 0 100-8 4 4 0 000 8z"/>

                        </svg>

                    </div>

                </div>

                <p class="mt-4 text-xs text-slate-400">
                    Registered customers
                </p>

            </div>

        </div>


        {{-- =========================================================
            SECONDARY STATS
        ========================================================== --}}

        <div class="grid grid-cols-1 gap-4 md:grid-cols-3">


            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <span class="text-sm text-slate-500">
                        Amount Paid
                    </span>

                    <span class="rounded-lg bg-green-50 px-2 py-1 text-xs font-bold text-green-700">
                        PAID
                    </span>

                </div>

                <p class="mt-2 text-xl font-black text-slate-900">
                    TSh {{ number_format($totalPaid, 0) }}
                </p>

            </div>


            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <span class="text-sm text-slate-500">
                        Outstanding Balance
                    </span>

                    <span class="rounded-lg bg-amber-50 px-2 py-1 text-xs font-bold text-amber-700">
                        CREDIT
                    </span>

                </div>

                <p class="mt-2 text-xl font-black text-slate-900">
                    TSh {{ number_format($totalBalance, 0) }}
                </p>

            </div>


            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-center justify-between">

                    <span class="text-sm text-slate-500">
                        Discounts
                    </span>

                    <span class="rounded-lg bg-red-50 px-2 py-1 text-xs font-bold text-red-600">
                        DISCOUNT
                    </span>

                </div>

                <p class="mt-2 text-xl font-black text-slate-900">
                    TSh {{ number_format($totalDiscount, 0) }}
                </p>

            </div>

        </div>


        {{-- =========================================================
            CHART + PAYMENT
        ========================================================== --}}

        <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">


            {{-- SALES CHART --}}

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm xl:col-span-2">

                <div class="mb-5 flex items-center justify-between">

                    <div>

                        <h2 class="font-bold text-slate-900">
                            Sales Performance
                        </h2>

                        <p class="text-sm text-slate-500">
                            Sales trend for selected period
                        </p>

                    </div>

                    <div class="rounded-lg bg-green-50 px-3 py-1.5 text-xs font-bold text-green-700">
                        TSh
                    </div>

                </div>

                <div class="h-80">

                    <canvas id="salesChart"></canvas>

                </div>

            </div>


            {{-- PAYMENT BREAKDOWN --}}

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="mb-5">

                    <h2 class="font-bold text-slate-900">
                        Payment Breakdown
                    </h2>

                    <p class="text-sm text-slate-500">
                        Sales by payment method
                    </p>

                </div>

                <div class="space-y-4">

                    @forelse($paymentBreakdown as $payment)

                        @php

                            $percentage = $totalSales > 0
                                ? ($payment->total_amount / $totalSales) * 100
                                : 0;

                        @endphp

                        <div>

                            <div class="mb-2 flex items-center justify-between">

                                <div class="flex items-center gap-2">

                                    <div class="h-2.5 w-2.5 rounded-full bg-green-500"></div>

                                    <span class="text-sm font-semibold text-slate-700">

                                        {{ ucwords(str_replace('_', ' ', $payment->payment_method)) }}

                                    </span>

                                </div>

                                <span class="text-sm font-bold text-slate-900">

                                    TSh {{ number_format($payment->total_amount, 0) }}

                                </span>

                            </div>

                            <div class="h-2 overflow-hidden rounded-full bg-slate-100">

                                <div
                                    class="h-full rounded-full bg-green-500"
                                    style="width: {{ min($percentage, 100) }}%">
                                </div>

                            </div>

                            <p class="mt-1 text-right text-xs text-slate-400">

                                {{ number_format($percentage, 1) }}%

                            </p>

                        </div>

                    @empty

                        <div class="py-10 text-center">

                            <p class="text-sm font-semibold text-slate-500">
                                No payment data
                            </p>

                        </div>

                    @endforelse

                </div>

            </div>

        </div>


        {{-- =========================================================
            TOP PRODUCTS
        ========================================================== --}}

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="flex flex-col gap-3 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="font-bold text-slate-900">
                        Top Selling Products
                    </h2>

                    <p class="text-sm text-slate-500">
                        Best performing products during this period
                    </p>

                </div>

                <div class="rounded-lg bg-green-50 px-3 py-2 text-xs font-bold text-green-700">
                    TOP 10
                </div>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50">

                        <tr class="text-left text-xs font-bold uppercase tracking-wide text-slate-500">

                            <th class="px-5 py-3">
                                #
                            </th>

                            <th class="px-5 py-3">
                                Product
                            </th>

                            <th class="px-5 py-3">
                                SKU
                            </th>

                            <th class="px-5 py-3 text-right">
                                Quantity Sold
                            </th>

                            <th class="px-5 py-3 text-right">
                                Sales
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($topProducts as $index => $product)

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-5 py-4">

                                    <span class="flex h-8 w-8 items-center justify-center rounded-lg bg-green-50 text-xs font-black text-green-700">

                                        {{ $index + 1 }}

                                    </span>

                                </td>

                                <td class="px-5 py-4">

                                    <p class="font-semibold text-slate-900">
                                        {{ $product->name }}
                                    </p>

                                </td>

                                <td class="px-5 py-4">

                                    <span class="rounded-lg bg-slate-100 px-2 py-1 text-xs font-medium text-slate-600">

                                        {{ $product->sku ?? 'N/A' }}

                                    </span>

                                </td>

                                <td class="px-5 py-4 text-right font-semibold text-slate-700">

                                    {{ number_format($product->quantity_sold) }}

                                </td>

                                <td class="px-5 py-4 text-right font-bold text-green-700">

                                    TSh {{ number_format($product->sales_amount, 0) }}

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-5 py-12 text-center">

                                    <p class="font-semibold text-slate-600">
                                        No product sales found
                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">
                                        Try another reporting period.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>


        {{-- =========================================================
            RECENT SALES
        ========================================================== --}}

        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="flex flex-col gap-3 border-b border-slate-100 p-5 sm:flex-row sm:items-center sm:justify-between">

                <div>

                    <h2 class="font-bold text-slate-900">
                        Recent Sales
                    </h2>

                    <p class="text-sm text-slate-500">
                        Latest transactions in this report
                    </p>

                </div>

                <a
                    href="{{ route('sales.history') }}"
                    class="text-sm font-bold text-green-700 hover:text-green-800">

                    View Sales History →

                </a>

            </div>


            <div class="overflow-x-auto">

                <table class="w-full">

                    <thead class="bg-slate-50">

                        <tr class="text-left text-xs font-bold uppercase tracking-wide text-slate-500">

                            <th class="px-5 py-3">
                                Invoice
                            </th>

                            <th class="px-5 py-3">
                                Customer
                            </th>

                            <th class="px-5 py-3">
                                Payment
                            </th>

                            <th class="px-5 py-3">
                                Date
                            </th>

                            <th class="px-5 py-3 text-right">
                                Total
                            </th>

                        </tr>

                    </thead>

                    <tbody class="divide-y divide-slate-100">

                        @forelse($recentSales as $sale)

                            <tr class="transition hover:bg-slate-50">

                                <td class="px-5 py-4">

                                    <span class="font-bold text-slate-900">

                                        {{ $sale->invoice_number
                                            ?? 'SALE-' . str_pad($sale->id, 6, '0', STR_PAD_LEFT)
                                        }}

                                    </span>

                                </td>

                                <td class="px-5 py-4">

                                    <p class="font-medium text-slate-800">

                                        {{ $sale->customer->name ?? 'Walk-in Customer' }}

                                    </p>

                                </td>

                                <td class="px-5 py-4">

                                    <span class="rounded-full bg-green-50 px-2.5 py-1 text-xs font-bold text-green-700">

                                        {{ ucwords(str_replace('_', ' ', $sale->payment_method)) }}

                                    </span>

                                </td>

                                <td class="px-5 py-4">

                                    <div>

                                        <p class="text-sm font-medium text-slate-700">

                                            {{ $sale->created_at->format('d M Y') }}

                                        </p>

                                        <p class="text-xs text-slate-400">

                                            {{ $sale->created_at->format('h:i A') }}

                                        </p>

                                    </div>

                                </td>

                                <td class="px-5 py-4 text-right">

                                    <span class="font-bold text-green-700">

                                        TSh {{ number_format($sale->total, 0) }}

                                    </span>

                                </td>

                            </tr>

                        @empty

                            <tr>

                                <td colspan="5" class="px-5 py-12 text-center">

                                    <p class="font-semibold text-slate-600">
                                        No sales found
                                    </p>

                                    <p class="mt-1 text-sm text-slate-400">
                                        There are no sales for this period.
                                    </p>

                                </td>

                            </tr>

                        @endforelse

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</div>


{{-- =========================================================
    CHART.JS
========================================================= --}}

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<script>

document.addEventListener('DOMContentLoaded', function () {

    const canvas = document.getElementById('salesChart');

    if (!canvas) {
        return;
    }


    const labels = @json(
        $dailySales->pluck('sale_date')->map(
            fn ($date) => \Carbon\Carbon::parse($date)->format('d M')
        )
    );


    const salesData = @json(
        $dailySales->pluck('total_amount')->map(
            fn ($amount) => (float) $amount
        )
    );


    new Chart(canvas, {

        type: 'line',

        data: {

            labels: labels,

            datasets: [

                {

                    label: 'Sales',

                    data: salesData,

                    fill: true,

                    tension: 0.4,

                    borderWidth: 3,

                    pointRadius: 4,

                    pointHoverRadius: 6,

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

                    callbacks: {

                        label: function (context) {

                            return 'TSh ' +
                                new Intl.NumberFormat('en-US')
                                .format(context.parsed.y);

                        }

                    }

                }

            },


            scales: {

                y: {

                    beginAtZero: true,

                    ticks: {

                        callback: function (value) {

                            return 'TSh ' +
                                new Intl.NumberFormat('en-US')
                                .format(value);

                        }

                    },

                    grid: {

                        color: '#f1f5f9'

                    }

                },


                x: {

                    grid: {

                        display: false

                    }

                }

            }

        }

    });

});


/*
|--------------------------------------------------------------------------
| CUSTOM DATE FILTER
|--------------------------------------------------------------------------
*/

function toggleCustomDates() {

    const filter = document.getElementById('filter').value;

    const from = document.getElementById('fromWrapper');

    const to = document.getElementById('toWrapper');


    if (filter === 'custom') {

        from.style.display = 'block';

        to.style.display = 'block';

    } else {

        from.style.display = 'none';

        to.style.display = 'none';

    }

}


document.addEventListener(
    'DOMContentLoaded',
    toggleCustomDates
);

</script>


{{-- =========================================================
    PRINT CSS
========================================================= --}}

<style>

@media print {

    @page {

        size: A4;

        margin: 12mm;

    }


    body {

        background: white !important;

    }


    .no-print,
    nav,
    aside,
    header {

        display: none !important;

    }


    button,
    a {

        display: none !important;

    }


    .shadow-sm {

        box-shadow: none !important;

    }


    .border {

        border-color: #ddd !important;

    }


    canvas {

        max-height: 300px !important;

    }

}

</style>

@endsection
