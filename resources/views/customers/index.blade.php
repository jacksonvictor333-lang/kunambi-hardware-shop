
@extends('layouts.app')

@section('title', 'Customers')
@section('page-title', 'Customers')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <div class="flex items-center gap-2">
                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-green-700">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8zm6 0a3 3 0 100-6 3 3 0 000 6zM9 10a3 3 0 100-6 3 3 0 000 6z"/>
                    </svg>
                </div>

                <div>
                    <h1 class="text-2xl font-bold text-slate-900">
                        Customers
                    </h1>

                    <p class="text-sm text-slate-500">
                        Manage your Hardware Shop customers
                    </p>
                </div>
            </div>
        </div>

        <a href="{{ route('customers.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 hover:shadow-md">

            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M12 4v16m8-8H4"/>
            </svg>

            Add Customer
        </a>
    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="mt-0.5 h-5 w-5 shrink-0"
                fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>

            <div>
                <p class="font-semibold">Success</p>
                <p class="text-sm">{{ session('success') }}</p>
            </div>
        </div>
    @endif


    {{-- Search + Summary --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

            <form method="GET"
                  action="{{ route('customers.index') }}"
                  class="flex w-full max-w-xl">

                <div class="relative flex-1">

                    <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                        <svg xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5"
                            fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M21 21l-4.35-4.35m2.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </div>

                    <input
                        type="text"
                        name="search"
                        value="{{ $search ?? request('search') }}"
                        placeholder="Search by name, phone or email..."
                        class="w-full rounded-l-xl border border-slate-300 bg-slate-50 py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition focus:border-green-500 focus:bg-white focus:ring-2 focus:ring-green-100"
                    >
                </div>

                <button type="submit"
                        class="rounded-r-xl bg-green-600 px-5 text-sm font-semibold text-white transition hover:bg-green-700">
                    Search
                </button>

            </form>


            <div class="flex items-center gap-3">

                <div class="rounded-xl bg-green-50 px-4 py-3">
                    <p class="text-xs font-medium text-green-600">
                        Total Customers
                    </p>

                    <p class="text-xl font-bold text-green-700">
                        {{ $customers->total() }}
                    </p>
                </div>

                @if(request('search'))
                    <a href="{{ route('customers.index') }}"
                       class="rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-medium text-slate-600 transition hover:bg-slate-50">
                        Clear
                    </a>
                @endif

            </div>

        </div>
    </div>


    {{-- Customers Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>
                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Customer
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Phone
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Email
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Address
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Actions
                        </th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($customers as $customer)

                        <tr class="transition hover:bg-green-50/40">

                            {{-- Customer --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-11 w-11 items-center justify-center rounded-full bg-green-100 font-bold text-green-700">
                                        {{ strtoupper(substr($customer->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <p class="font-semibold text-slate-900">
                                            {{ $customer->name }}
                                        </p>

                                        <p class="text-xs text-slate-400">
                                            Customer #{{ $customer->id }}
                                        </p>
                                    </div>

                                </div>

                            </td>


                            {{-- Phone --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                @if($customer->phone)

                                    <div class="flex items-center gap-2 text-sm text-slate-700">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4 text-green-600"
                                            fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M3 5a2 2 0 012-2h2.28a2 2 0 011.94 1.515l.55 2.2a2 2 0 01-.45 1.85L8.1 9.79a16 16 0 006.11 6.11l1.225-1.225a2 2 0 011.85-.45l2.2.55A2 2 0 0121 16.72V19a2 2 0 01-2 2C9.611 21 3 14.389 3 5z"/>
                                        </svg>

                                        {{ $customer->phone }}

                                    </div>

                                @else
                                    <span class="text-sm text-slate-400">Not provided</span>
                                @endif

                            </td>


                            {{-- Email --}}
                            <td class="px-6 py-4">

                                @if($customer->email)

                                    <span class="text-sm text-slate-700">
                                        {{ $customer->email }}
                                    </span>

                                @else

                                    <span class="text-sm text-slate-400">
                                        Not provided
                                    </span>

                                @endif

                            </td>


                            {{-- Address --}}
                            <td class="max-w-xs px-6 py-4">

                                @if($customer->address)

                                    <p class="truncate text-sm text-slate-600">
                                        {{ $customer->address }}
                                    </p>

                                @else

                                    <span class="text-sm text-slate-400">
                                        Not provided
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    {{-- View --}}
                                    <a href="{{ route('customers.show', $customer) }}"
                                       title="View Customer"
                                       class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-slate-200 text-slate-600 transition hover:border-green-200 hover:bg-green-50 hover:text-green-700">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>

                                    </a>


                                    {{-- Edit --}}
                                    <a href="{{ route('customers.edit', $customer) }}"
                                       title="Edit Customer"
                                       class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-blue-200 text-blue-600 transition hover:bg-blue-50">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-4 w-4"
                                            fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 7.5-7.5z"/>
                                        </svg>

                                    </a>


                                    {{-- Delete --}}
                                    <form method="POST"
                                          action="{{ route('customers.destroy', $customer) }}"
                                          onsubmit="return confirm('Are you sure you want to delete this customer?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                title="Delete Customer"
                                                class="inline-flex h-9 w-9 items-center justify-center rounded-lg border border-red-200 text-red-600 transition hover:bg-red-50">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                class="h-4 w-4"
                                                fill="none" viewBox="0 0 24 24"
                                                stroke="currentColor" stroke-width="2">
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
                            <td colspan="5" class="px-6 py-16 text-center">

                                <div class="mx-auto flex max-w-sm flex-col items-center">

                                    <div class="flex h-16 w-16 items-center justify-center rounded-2xl bg-green-50 text-green-600">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                            class="h-8 w-8"
                                            fill="none" viewBox="0 0 24 24"
                                            stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M17 20h5v-2a4 4 0 00-4-4h-1M9 20H4v-2a4 4 0 014-4h1m4-4a4 4 0 100-8 4 4 0 000 8zm6 0a3 3 0 100-6 3 3 0 000 6zM9 10a3 3 0 100-6 3 3 0 000 6z"/>
                                        </svg>

                                    </div>

                                    <h3 class="mt-4 text-lg font-semibold text-slate-900">
                                        No customers found
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Start by adding your first customer.
                                    </p>

                                    <a href="{{ route('customers.create') }}"
                                       class="mt-5 inline-flex items-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white hover:bg-green-700">

                                        <span>+</span>
                                        Add Customer

                                    </a>

                                </div>

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Pagination --}}
        @if($customers->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $customers->links() }}
            </div>

        @endif

    </div>

</div>

@endsection
