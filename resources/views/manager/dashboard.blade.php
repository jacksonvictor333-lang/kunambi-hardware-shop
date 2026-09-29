```blade
@extends('layouts.app')

@section('title', 'Manager Dashboard')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">
        <div>
            <p class="text-sm font-semibold text-green-600">
                KUNAMBI HARDWARE SHOP
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                Manager Dashboard
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Welcome back, {{ auth()->user()->name }}.
                Manage daily shop operations from one place.
            </p>
        </div>

        <div class="flex items-center gap-3">
            <div class="hidden text-right sm:block">
                <p class="text-sm font-semibold text-slate-900">
                    {{ auth()->user()->name }}
                </p>

                <p class="text-xs text-slate-500">
                    {{ auth()->user()->email }}
                </p>
            </div>

            <div class="flex h-11 w-11 items-center justify-center rounded-full bg-green-100 text-sm font-bold text-green-700">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
        </div>
    </div>


    {{-- Welcome Banner --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="bg-gradient-to-r from-green-600 to-green-500 px-6 py-7 sm:px-8">

            <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

                <div class="text-white">

                    <p class="text-sm font-medium text-green-100">
                        Shop Manager
                    </p>

                    <h2 class="mt-1 text-2xl font-bold">
                        Welcome to KUNAMBI Hardware Shop
                    </h2>

                    <p class="mt-2 max-w-2xl text-sm leading-6 text-green-50">
                        Monitor sales, inventory, products, customers and
                        daily business operations from your manager dashboard.
                    </p>

                </div>

                <div>
                    <span class="inline-flex items-center rounded-full bg-white/15 px-4 py-2 text-sm font-semibold text-white ring-1 ring-white/20">

                        <span class="mr-2 h-2.5 w-2.5 rounded-full bg-white"></span>

                        Active Manager

                    </span>
                </div>

            </div>

        </div>

    </div>


    {{-- Statistics --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Products --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Products
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ \App\Models\Product::count() }}
                    </p>

                    <p class="mt-2 text-xs text-slate-500">
                        Products in system
                    </p>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-xl">
                    📦
                </div>

            </div>

        </div>


        {{-- Sales --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Today's Sales
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ \App\Models\Sale::whereDate('created_at', today())->count() }}
                    </p>

                    <p class="mt-2 text-xs text-slate-500">
                        Sales transactions today
                    </p>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-xl">
                    💰
                </div>

            </div>

        </div>


        {{-- Customers --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Customers
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ \App\Models\Customer::count() }}
                    </p>

                    <p class="mt-2 text-xs text-slate-500">
                        Registered customers
                    </p>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-xl">
                    👥
                </div>

            </div>

        </div>


        {{-- Users --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

            <div class="flex items-start justify-between">

                <div>

                    <p class="text-sm font-medium text-slate-500">
                        Staff Users
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ \App\Models\User::count() }}
                    </p>

                    <p class="mt-2 text-xs text-slate-500">
                        System users
                    </p>

                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-xl">
                    👤
                </div>

            </div>

        </div>

    </div>


    {{-- Quick Actions --}}
    <div>

        <div class="mb-4">

            <h2 class="text-lg font-bold text-slate-900">
                Quick Actions
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Quickly access common management functions.
            </p>

        </div>


        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">


            {{-- Products --}}
            <a href="{{ route('products.index') }}"
               class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-green-300 hover:shadow-md">

                <div class="flex items-start justify-between">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-50 text-xl">
                        📦
                    </div>

                    <span class="text-slate-300 transition group-hover:text-green-600">
                        →
                    </span>

                </div>

                <h3 class="mt-4 font-semibold text-slate-900">
                    Manage Products
                </h3>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    View, create and update hardware products.
                </p>

            </a>


            {{-- Inventory --}}
            <a href="{{ route('inventory.index') }}"
               class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-green-300 hover:shadow-md">

                <div class="flex items-start justify-between">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-orange-50 text-xl">
                        🏪
                    </div>

                    <span class="text-slate-300 transition group-hover:text-green-600">
                        →
                    </span>

                </div>

                <h3 class="mt-4 font-semibold text-slate-900">
                    Inventory
                </h3>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    Monitor stock levels and inventory movements.
                </p>

            </a>


            {{-- Sales --}}
            <a href="{{ route('sales.index') }}"
               class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-green-300 hover:shadow-md">

                <div class="flex items-start justify-between">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-50 text-xl">
                        💰
                    </div>

                    <span class="text-slate-300 transition group-hover:text-green-600">
                        →
                    </span>

                </div>

                <h3 class="mt-4 font-semibold text-slate-900">
                    Sales
                </h3>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    View and manage daily sales transactions.
                </p>

            </a>


            {{-- Customers --}}
            <a href="{{ route('customers.index') }}"
               class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-green-300 hover:shadow-md">

                <div class="flex items-start justify-between">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-purple-50 text-xl">
                        👥
                    </div>

                    <span class="text-slate-300 transition group-hover:text-green-600">
                        →
                    </span>

                </div>

                <h3 class="mt-4 font-semibold text-slate-900">
                    Customers
                </h3>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    Manage registered hardware shop customers.
                </p>

            </a>


            {{-- Reports --}}
            <a href="{{ route('reports.index') }}"
               class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-green-300 hover:shadow-md">

                <div class="flex items-start justify-between">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-red-50 text-xl">
                        📊
                    </div>

                    <span class="text-slate-300 transition group-hover:text-green-600">
                        →
                    </span>

                </div>

                <h3 class="mt-4 font-semibold text-slate-900">
                    Reports
                </h3>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    View sales, inventory and business reports.
                </p>

            </a>


            {{-- Categories --}}
            <a href="{{ route('categories.index') }}"
               class="group rounded-2xl border border-slate-200 bg-white p-5 shadow-sm transition hover:-translate-y-0.5 hover:border-green-300 hover:shadow-md">

                <div class="flex items-start justify-between">

                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-yellow-50 text-xl">
                        🗂️
                    </div>

                    <span class="text-slate-300 transition group-hover:text-green-600">
                        →
                    </span>

                </div>

                <h3 class="mt-4 font-semibold text-slate-900">
                    Categories
                </h3>

                <p class="mt-1 text-sm leading-6 text-slate-500">
                    Organize hardware products by category.
                </p>

            </a>

        </div>

    </div>


    {{-- Manager Responsibilities --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="font-bold text-slate-900">
                Manager Responsibilities
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Areas available to the manager account.
            </p>

        </div>


        <div class="divide-y divide-slate-100">

            <div class="flex items-center gap-4 px-6 py-5">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-50 text-lg">
                    📦
                </div>

                <div>
                    <h3 class="font-semibold text-slate-900">
                        Product Management
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Manage products, categories and brands.
                    </p>
                </div>

            </div>


            <div class="flex items-center gap-4 px-6 py-5">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-orange-50 text-lg">
                    🏪
                </div>

                <div>
                    <h3 class="font-semibold text-slate-900">
                        Inventory Management
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Monitor stock, stock-in and inventory adjustments.
                    </p>
                </div>

            </div>


            <div class="flex items-center gap-4 px-6 py-5">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-50 text-lg">
                    💰
                </div>

                <div>
                    <h3 class="font-semibold text-slate-900">
                        Sales Management
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Monitor sales and manage sales transactions.
                    </p>
                </div>

            </div>


            <div class="flex items-center gap-4 px-6 py-5">

                <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-red-50 text-lg">
                    📊
                </div>

                <div>
                    <h3 class="font-semibold text-slate-900">
                        Business Reports
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Review sales, inventory and expense reports.
                    </p>
                </div>

            </div>

        </div>

    </div>


    {{-- Current Account --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <div class="flex flex-col gap-5 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <p class="text-xs font-semibold uppercase tracking-wider text-slate-400">
                    Current Account
                </p>

                <h2 class="mt-1 text-lg font-bold text-slate-900">
                    {{ auth()->user()->name }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    {{ auth()->user()->email }}
                </p>

            </div>

            <div class="flex flex-wrap items-center gap-2">

                <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1.5 text-xs font-semibold text-green-700">
                    <span class="mr-1.5 h-2 w-2 rounded-full bg-green-500"></span>
                    Active
                </span>

                <span class="inline-flex items-center rounded-full bg-blue-50 px-3 py-1.5 text-xs font-semibold text-blue-700">
                    Manager
                </span>

            </div>

        </div>

    </div>

</div>

@endsection
```
