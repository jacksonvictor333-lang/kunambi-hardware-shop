@extends('layouts.app')

@section('title', 'Sales History')
@section('page-title', 'Sales History')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-700">
                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-6 w-6"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M9 17v-2a4 4 0 014-4h4"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M13 7h7m0 0v7m0-7l-8 8"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                          d="M5 5h4m-4 4h4m-4 4h2"/>
                </svg>
            </div>

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Sales History
                </h1>

                <p class="text-sm text-slate-500">
                    View and manage all completed sales
                </p>
            </div>

        </div>

        <a href="{{ route('sales.pos') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 hover:shadow-md">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M12 4v16m8-8H4"/>
            </svg>

            New Sale
        </a>

    </div>


    {{-- Success Message --}}
    @if(session('success'))

        <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="mt-0.5 h-5 w-5 shrink-0"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                      d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>

            <div>
                <p class="font-semibold">Success</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>

        </div>

    @endif


    {{-- Sales Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-lg font-bold text-slate-900">
                        All Sales
                    </h2>

                    <p class="text-sm text-slate-500">
                        {{ $sales->total() }} sales found
                    </p>
                </div>

                <div class="rounded-xl bg-green-50 px-4 py-2 text-sm font-semibold text-green-700">
                    Sales Records
                </div>

            </div>

        </div>


        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Invoice
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Customer
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Payment
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Total
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Date
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($sales as $sale)

                        <tr class="transition hover:bg-green-50/40">

                            {{-- Invoice --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 text-green-700">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-5 w-5"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M9 14l6-6m-5.5-3h5A2.5 2.5 0 0117 7.5v9a2.5 2.5 0 01-2.5 2.5h-5A2.5 2.5 0 017 16.5v-9A2.5 2.5 0 019.5 5z"/>
                                        </svg>

                                    </div>

                                    <div>

                                        <p class="font-semibold text-slate-900">
                                            {{ $sale->invoice_number ?? 'INV-' . $sale->id }}
                                        </p>

                                        <p class="text-xs text-slate-400">
                                            Sale #{{ $sale->id }}
                                        </p>

                                    </div>

                                </div>

                            </td>


                            {{-- Customer --}}
                            <td class="px-6 py-4">

                                @if($sale->customer)

                                    <p class="font-medium text-slate-800">
                                        {{ $sale->customer->name }}
                                    </p>

                                    @if($sale->customer->phone)
                                        <p class="text-xs text-slate-400">
                                            {{ $sale->customer->phone }}
                                        </p>
                                    @endif

                                @else

                                    <span class="inline-flex rounded-lg bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
                                        Walk-in Customer
                                    </span>

                                @endif

                            </td>


                            {{-- Payment --}}
                            <td class="px-6 py-4">

                                @php
                                    $payment = strtolower($sale->payment_method ?? 'cash');

                                    $paymentClasses = match ($payment) {
                                        'cash' => 'bg-green-100 text-green-700',
                                        'credit' => 'bg-orange-100 text-orange-700',
                                        'card' => 'bg-blue-100 text-blue-700',
                                        'mobile', 'mobile money', 'mobile_money' => 'bg-purple-100 text-purple-700',
                                        'bank' => 'bg-indigo-100 text-indigo-700',
                                        default => 'bg-slate-100 text-slate-700',
                                    };
                                @endphp

                                <span class="inline-flex rounded-lg px-3 py-1.5 text-xs font-semibold {{ $paymentClasses }}">
                                    {{ ucfirst(str_replace('_', ' ', $sale->payment_method ?? 'Cash')) }}
                                </span>

                            </td>


                            {{-- Total --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <p class="font-bold text-slate-900">
                                    TSh {{ number_format((float) $sale->total, 0) }}
                                </p>

                                @if((float) $sale->balance > 0)

                                    <p class="mt-1 text-xs font-medium text-orange-600">
                                        Balance:
                                        TSh {{ number_format((float) $sale->balance, 0) }}
                                    </p>

                                @endif

                            </td>


                            {{-- Date --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <p class="text-sm font-medium text-slate-700">
                                    {{ $sale->created_at?->format('d M Y') }}
                                </p>

                                <p class="text-xs text-slate-400">
                                    {{ $sale->created_at?->format('H:i') }}
                                </p>

                            </td>


                            {{-- Actions --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    {{-- View --}}
                                    <a href="{{ route('sales.show', $sale) }}"
                                       title="View Sale"
                                       class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:border-green-200 hover:bg-green-50 hover:text-green-700">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>

                                    </a>


                                    {{-- Receipt --}}
                                    <a href="{{ route('sales.receipt', $sale) }}"
                                       target="_blank"
                                       title="Print Receipt"
                                       class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-blue-200 text-blue-600 transition hover:bg-blue-50">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M6 9V4h12v5M6 18H4a2 2 0 01-2-2v-5a2 2 0 012-2h16a2 2 0 012 2v5a2 2 0 01-2 2h-2M6 14h12v7H6z"/>
                                        </svg>

                                    </a>


                                    {{-- Delete --}}
                                    <form method="POST"
                                          action="{{ route('sales.destroy', $sale) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this sale?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                title="Delete Sale"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 text-red-600 transition hover:bg-red-50">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-4 w-4"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14"/>
                                            </svg>

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6" class="px-6 py-16 text-center">

                                <div class="mx-auto flex max-w-sm flex-col items-center">

                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-green-50 text-green-600">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-8 w-8"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                  d="M9 14l6-6m-5.5-3h5A2.5 2.5 0 0117 7.5v9a2.5 2.5 0 01-2.5 2.5h-5A2.5 2.5 0 017 16.5v-9A2.5 2.5 0 019.5 5z"/>
                                        </svg>

                                    </div>

                                    <h3 class="mt-4 text-lg font-semibold text-slate-900">
                                        No sales found
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        No sales have been recorded yet.
                                    </p>

                                    <a href="{{ route('sales.pos') }}"
                                       class="mt-5 inline-flex items-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-green-700">

                                        <span>+</span>
                                        Create First Sale

                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($sales->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $sales->links() }}
            </div>

        @endif

    </div>

</div>

@endsection