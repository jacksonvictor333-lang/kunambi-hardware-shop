@extends('layouts.app')

@section('title', 'Sale Details')
@section('page-title', 'Sale Details')

@section('content')

@php
    $changeAmount = max(0, (float) $sale->paid_amount - (float) $sale->total);
    $isPending    = (float) $sale->balance > 0;
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">

            <a href="{{ route('sales.history') }}"
               class="flex h-11 w-11 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 transition hover:bg-slate-50">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"/>
                </svg>
            </a>

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    {{ $sale->invoice_number ?? 'SALE-' . str_pad($sale->id, 6, '0', STR_PAD_LEFT) }}
                </h1>
                <p class="mt-1 text-sm text-slate-500">
                    {{ $sale->created_at?->format('d M Y \a\t h:i A') }}
                </p>
            </div>

        </div>

        <div class="flex flex-wrap gap-2">
            <a href="{{ route('sales.receipt', $sale) }}" target="_blank"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">
                🖨 Print Receipt
            </a>

            <form method="POST" action="{{ route('sales.destroy', $sale) }}"
                  onsubmit="return confirm('Are you sure you want to delete this sale? Stock will be restored.');">
                @csrf
                @method('DELETE')
                <button type="submit"
                        class="inline-flex items-center gap-2 rounded-xl border border-red-200 bg-white px-4 py-2.5 text-sm font-semibold text-red-600 shadow-sm transition hover:bg-red-50">
                    🗑 Delete Sale
                </button>
            </form>
        </div>

    </div>


    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 p-4 text-sm text-green-800">
            {{ session('success') }}
        </div>
    @endif


    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- ================= LEFT: ITEMS ================= --}}
        <div class="space-y-6 xl:col-span-2">

            {{-- Status banner --}}
            <div class="flex items-center justify-between rounded-2xl border p-4
                {{ $isPending ? 'border-yellow-200 bg-yellow-50' : 'border-green-200 bg-green-50' }}">
                <div class="flex items-center gap-3">
                    <span class="text-xl">{{ $isPending ? '⏳' : '✅' }}</span>
                    <div>
                        <p class="text-sm font-bold {{ $isPending ? 'text-yellow-800' : 'text-green-800' }}">
                            {{ $isPending ? 'Payment Pending' : 'Payment Completed' }}
                        </p>
                        @if($isPending)
                            <p class="text-xs text-yellow-700">Balance: TSh {{ number_format($sale->balance, 0) }}</p>
                        @endif
                    </div>
                </div>
                <span class="rounded-full bg-white px-3 py-1 text-xs font-semibold {{ $isPending ? 'text-yellow-700' : 'text-green-700' }}">
                    {{ ucfirst($sale->status ?? ($isPending ? 'pending' : 'completed')) }}
                </span>
            </div>

            {{-- Items --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

                <div class="border-b border-slate-100 px-6 py-4">
                    <h2 class="text-base font-bold text-slate-900">Items Sold</h2>
                    <p class="mt-0.5 text-xs text-slate-500">{{ $sale->items->count() }} product(s)</p>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-slate-200">
                        <thead class="bg-slate-50">
                            <tr class="text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                                <th class="px-6 py-3">Product</th>
                                <th class="px-6 py-3">Qty</th>
                                <th class="px-6 py-3">Unit Price</th>
                                <th class="px-6 py-3 text-right">Subtotal</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100">
                            @foreach($sale->items as $item)
                                <tr>
                                    <td class="px-6 py-4">
                                        <p class="font-semibold text-slate-900">{{ $item->product->name ?? 'Deleted product' }}</p>
                                        @if($item->product?->sku)
                                            <p class="text-xs text-slate-400">SKU: {{ $item->product->sku }}</p>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-sm text-slate-700">{{ number_format($item->quantity) }}</td>
                                    <td class="px-6 py-4 text-sm text-slate-700">TSh {{ number_format($item->unit_price, 0) }}</td>
                                    <td class="px-6 py-4 text-right text-sm font-bold text-slate-900">
                                        TSh {{ number_format($item->subtotal, 0) }}
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>


        {{-- ================= RIGHT: SUMMARY ================= --}}
        <div class="space-y-6">

            {{-- Customer & cashier --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="mb-4 text-sm font-bold text-slate-900">Sale Information</h2>

                <dl class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">Customer</dt>
                        <dd class="font-semibold text-slate-800">{{ $sale->customer->name ?? 'Walk-in Customer' }}</dd>
                    </div>

                    @if($sale->customer?->phone)
                        <div class="flex items-center justify-between">
                            <dt class="text-slate-500">Phone</dt>
                            <dd class="font-semibold text-slate-800">{{ $sale->customer->phone }}</dd>
                        </div>
                    @endif

                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">Cashier</dt>
                        <dd class="font-semibold text-slate-800">{{ $sale->user->name ?? 'N/A' }}</dd>
                    </div>

                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">Payment Method</dt>
                        <dd class="font-semibold capitalize text-slate-800">{{ str_replace('_', ' ', $sale->payment_method) }}</dd>
                    </div>
                </dl>
            </div>

            {{-- Totals --}}
            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
                <h2 class="mb-4 text-sm font-bold text-slate-900">Payment Summary</h2>

                <dl class="space-y-3 text-sm">
                    <div class="flex items-center justify-between">
                        <dt class="text-slate-500">Subtotal</dt>
                        <dd class="font-semibold text-slate-800">TSh {{ number_format($sale->subtotal, 0) }}</dd>
                    </div>

                    @if($sale->discount > 0)
                        <div class="flex items-center justify-between">
                            <dt class="text-slate-500">Discount</dt>
                            <dd class="font-semibold text-red-600">- TSh {{ number_format($sale->discount, 0) }}</dd>
                        </div>
                    @endif

                    <div class="border-t border-dashed border-slate-200 pt-3">
                        <div class="flex items-center justify-between">
                            <dt class="text-base font-semibold text-slate-700">Total</dt>
                            <dd class="text-xl font-bold text-green-700">TSh {{ number_format($sale->total, 0) }}</dd>
                        </div>
                    </div>

                    <div class="flex items-center justify-between border-t border-slate-100 pt-3">
                        <dt class="text-slate-500">Amount Paid</dt>
                        <dd class="font-semibold text-slate-800">TSh {{ number_format($sale->paid_amount, 0) }}</dd>
                    </div>

                    @if($changeAmount > 0)
                        <div class="flex items-center justify-between rounded-xl bg-green-50 px-3 py-2">
                            <dt class="font-medium text-green-700">Change</dt>
                            <dd class="font-bold text-green-700">TSh {{ number_format($changeAmount, 0) }}</dd>
                        </div>
                    @elseif($sale->balance > 0)
                        <div class="flex items-center justify-between rounded-xl bg-yellow-50 px-3 py-2">
                            <dt class="font-medium text-yellow-700">Balance</dt>
                            <dd class="font-bold text-yellow-700">TSh {{ number_format($sale->balance, 0) }}</dd>
                        </div>
                    @endif
                </dl>
            </div>

        </div>

    </div>

</div>

@endsection