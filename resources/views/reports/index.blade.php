@extends('layouts.app')

@section('title', 'Reports')
@section('page-title', 'Reports')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            Reports
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            View sales, inventory and customer reports.
        </p>
    </div>

    <div class="grid grid-cols-1 gap-5 md:grid-cols-3">

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Sales</p>

            <p class="mt-2 text-2xl font-bold text-green-600">
                TSh {{ number_format($totalSales, 2) }}
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Products</p>

            <p class="mt-2 text-2xl font-bold text-slate-900">
                {{ number_format($totalProducts) }}
            </p>
        </div>

        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
            <p class="text-sm text-slate-500">Total Customers</p>

            <p class="mt-2 text-2xl font-bold text-slate-900">
                {{ number_format($totalCustomers) }}
            </p>
        </div>

    </div>

</div>

@endsection