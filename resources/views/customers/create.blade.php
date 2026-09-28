
@extends('layouts.app')

@section('title', 'Add Customer')
@section('page-title', 'Add Customer')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">

            <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-700">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6"
                    fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M18 9v3m0 0v3m0-3h3m-3 0h-3M9 7a4 4 0 100-8 4 4 0 000 8zm0 2c-4 0-7 2-7 5v2h8"/>
                </svg>

            </div>

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Add Customer
                </h1>

                <p class="text-sm text-slate-500">
                    Register a new Hardware Shop customer
                </p>
            </div>

        </div>

        <a href="{{ route('customers.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19l-7-7 7-7"/>
            </svg>

            Back to Customers
        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="rounded-xl border border-red-200 bg-red-50 p-4">

            <div class="flex gap-3">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5 shrink-0 text-red-600"
                    fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 8v4m0 4h.01M10.29 3.86L1.82 18a2 2 0 001.71 3h16.94a2 2 0 001.71-3L13.71 3.86a2 2 0 00-3.42 0z"/>
                </svg>

                <div>
                    <p class="font-semibold text-red-800">
                        Please fix the following errors:
                    </p>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">

                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach

                    </ul>
                </div>

            </div>

        </div>

    @endif


    {{-- Form --}}
    <form method="POST"
          action="{{ route('customers.store') }}"
          class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        @csrf

        {{-- Form Header --}}
        <div class="border-b border-slate-200 bg-gradient-to-r from-green-50 to-white px-6 py-5">

            <h2 class="text-lg font-bold text-slate-900">
                Customer Information
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Enter the customer's contact details below.
            </p>

        </div>


        <div class="space-y-6 p-6">

            {{-- Name --}}
            <div>

                <label for="name"
                       class="mb-2 block text-sm font-semibold text-slate-700">
                    Customer Name
                    <span class="text-red-500">*</span>
                </label>

                <input
                    type="text"
                    id="name"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. John Hardware Ltd"
                    required
                    autofocus
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100 @error('name') border-red-400 @enderror"
                >

                @error('name')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>


            {{-- Phone + Email --}}
            <div class="grid gap-6 md:grid-cols-2">

                <div>

                    <label for="phone"
                           class="mb-2 block text-sm font-semibold text-slate-700">
                        Phone Number
                    </label>

                    <div class="relative">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 5a2 2 0 012-2h2.28a2 2 0 011.94 1.515l.55 2.2a2 2 0 01-.45 1.85L8.1 9.79a16 16 0 006.11 6.11l1.225-1.225a2 2 0 011.85-.45l2.2.55A2 2 0 0121 16.72V19a2 2 0 01-2 2C9.611 21 3 14.389 3 5z"/>
                            </svg>
                        </div>

                        <input
                            type="text"
                            id="phone"
                            name="phone"
                            value="{{ old('phone') }}"
                            placeholder="e.g. 0712 345 678"
                            class="w-full rounded-xl border border-slate-300 py-3 pl-12 pr-4 text-sm outline-none transition focus:border-green-500 focus:ring-4 focus:ring-green-100 @error('phone') border-red-400 @enderror"
                        >

                    </div>

                    @error('phone')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>


                <div>

                    <label for="email"
                           class="mb-2 block text-sm font-semibold text-slate-700">
                        Email Address
                    </label>

                    <div class="relative">

                        <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5"
                                fill="none" viewBox="0 0 24 24"
                                stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                            </svg>
                        </div>

                        <input
                            type="email"
                            id="email"
                            name="email"
                            value="{{ old('email') }}"
                            placeholder="customer@example.com"
                            class="w-full rounded-xl border border-slate-300 py-3 pl-12 pr-4 text-sm outline-none transition focus:border-green-500 focus:ring-4 focus:ring-green-100 @error('email') border-red-400 @enderror"
                        >

                    </div>

                    @error('email')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>

            </div>


            {{-- Address --}}
            <div>

                <label for="address"
                       class="mb-2 block text-sm font-semibold text-slate-700">
                    Address
                </label>

                <textarea
                    id="address"
                    name="address"
                    rows="4"
                    placeholder="Enter customer's address..."
                    class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100 @error('address') border-red-400 @enderror"
                >{{ old('address') }}</textarea>

                @error('address')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>

        </div>


        {{-- Footer --}}
        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:justify-end">

            <a href="{{ route('customers.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                Cancel
            </a>

            <button type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 hover:shadow-md">

                <svg xmlns="http://www.w3.org/2000/svg"
                    class="h-5 w-5"
                    fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M12 4v16m8-8H4"/>
                </svg>

                Save Customer

            </button>

        </div>

    </form>

</div>

@endsection
