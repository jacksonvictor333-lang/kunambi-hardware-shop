
@extends('layouts.app')

@section('title', 'Customer Details')
@section('page-title', 'Customer Details')

@section('content')

<div class="mx-auto max-w-5xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-700">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                </svg>

            </div>

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Customer Details
                </h1>

                <p class="text-sm text-slate-500">
                    View customer information
                </p>
            </div>

        </div>


        <div class="flex flex-wrap gap-2">

            <a href="{{ route('customers.index') }}"
               class="inline-flex items-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M15 19l-7-7 7-7"/>
                </svg>

                Back

            </a>

            <a href="{{ route('customers.edit', $customer) }}"
               class="inline-flex items-center gap-2 rounded-xl bg-green-600 px-4 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-4 w-4"
                    fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 7.5-7.5z"/>
                </svg>

                Edit Customer

            </a>

        </div>

    </div>


    {{-- Customer Profile Card --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- Green Banner --}}
        <div class="h-32 bg-gradient-to-r from-green-700 via-green-600 to-emerald-500"></div>

        <div class="px-6 pb-6">

            {{-- Profile --}}
            <div class="-mt-12 flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">

                <div class="flex items-end gap-4">

                    <div class="flex h-24 w-24 items-center justify-center rounded-2xl border-4 border-white bg-green-100 text-3xl font-bold text-green-700 shadow-md">

                        {{ strtoupper(substr($customer->name, 0, 1)) }}

                    </div>

                    <div class="pb-1">

                        <h2 class="text-2xl font-bold text-slate-900">
                            {{ $customer->name }}
                        </h2>

                        <p class="text-sm text-slate-500">
                            Customer #{{ $customer->id }}
                        </p>

                    </div>

                </div>

                <div class="rounded-xl bg-green-50 px-4 py-2 text-sm font-semibold text-green-700">
                    Active Customer
                </div>

            </div>


            {{-- Information --}}
            <div class="mt-8 grid gap-5 md:grid-cols-2">

                {{-- Phone --}}
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-5">

                    <div class="flex items-start gap-4">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-700">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h2.28a2 2 0 011.94 1.515l.55 2.2a2 2 0 01-.45 1.85L8.1 9.79a16 16 0 006.11 6.11l1.225-1.225a2 2 0 011.85-.45l2.2.55A2 2 0 0121 16.72V19a2 2 0 01-2 2C9.611 21 3 14.389 3 5z"/>
                            </svg>

                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Phone Number
                            </p>

                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $customer->phone ?: 'Not provided' }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Email --}}
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-5">

                    <div class="flex items-start gap-4">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-700">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>

                        </div>

                        <div class="min-w-0">

                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Email Address
                            </p>

                            <p class="mt-1 truncate font-semibold text-slate-900">
                                {{ $customer->email ?: 'Not provided' }}
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Address --}}
                <div class="rounded-xl border border-slate-200 bg-slate-50 p-5 md:col-span-2">

                    <div class="flex items-start gap-4">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-orange-100 text-orange-600">

                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M17.657 16.657L13.414 21.5a2 2 0 01-2.828 0l-4.243-4.843A8 8 0 1117.657 16.657z"/>
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                            </svg>

                        </div>

                        <div>

                            <p class="text-xs font-semibold uppercase tracking-wide text-slate-400">
                                Address
                            </p>

                            <p class="mt-1 font-semibold text-slate-900">
                                {{ $customer->address ?: 'Not provided' }}
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Customer Metadata --}}
            <div class="mt-6 grid gap-4 sm:grid-cols-2">

                <div class="rounded-xl border border-slate-200 p-4">

                    <p class="text-xs font-medium text-slate-400">
                        Customer Since
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $customer->created_at?->format('d M Y') ?? 'N/A' }}
                    </p>

                </div>


                <div class="rounded-xl border border-slate-200 p-4">

                    <p class="text-xs font-medium text-slate-400">
                        Last Updated
                    </p>

                    <p class="mt-1 font-semibold text-slate-800">
                        {{ $customer->updated_at?->format('d M Y, H:i') ?? 'N/A' }}
                    </p>

                </div>

            </div>

        </div>

    </div>


    {{-- Danger Zone --}}
    <div class="rounded-2xl border border-red-200 bg-red-50 p-6">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>

                <h3 class="font-bold text-red-800">
                    Delete Customer
                </h3>

                <p class="mt-1 text-sm text-red-600">
                    This action cannot be undone.
                </p>

            </div>

            <form method="POST"
                  action="{{ route('customers.destroy', $customer) }}"
                  onsubmit="return confirm('Are you sure you want to delete {{ addslashes($customer->name) }}?');">

                @csrf
                @method('DELETE')

                <button type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-red-600 px-5 py-3 text-sm font-semibold text-white transition hover:bg-red-700">

                    <svg xmlns="http://www.w3.org/2000/svg"
                        class="h-4 w-4"
                        fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14"/>
                    </svg>

                    Delete Customer

                </button>

            </form>

        </div>

    </div>

</div>

@endsection
