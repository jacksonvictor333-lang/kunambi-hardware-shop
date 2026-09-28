
@extends('layouts.app')

@section('title', 'Edit Customer')
@section('page-title', 'Edit Customer')

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
                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 7.5-7.5z"/>
                </svg>

            </div>

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Edit Customer
                </h1>

                <p class="text-sm text-slate-500">
                    Update customer information
                </p>
            </div>

        </div>

        <a href="{{ route('customers.show', $customer) }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

            <svg xmlns="http://www.w3.org/2000/svg"
                class="h-4 w-4"
                fill="none" viewBox="0 0 24 24"
                stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round"
                    d="M15 19l-7-7 7-7"/>
            </svg>

            Back to Customer

        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="rounded-xl border border-red-200 bg-red-50 p-4">

            <p class="font-semibold text-red-800">
                Please fix the following errors:
            </p>

            <ul class="mt-2 list-disc pl-5 text-sm text-red-700">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    {{-- Form --}}
    <form method="POST"
          action="{{ route('customers.update', $customer) }}"
          class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        @csrf
        @method('PUT')

        {{-- Header --}}
        <div class="border-b border-slate-200 bg-gradient-to-r from-green-50 to-white px-6 py-5">

            <div class="flex items-center justify-between">

                <div>
                    <h2 class="text-lg font-bold text-slate-900">
                        Customer Information
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Customer #{{ $customer->id }}
                    </p>
                </div>

                <div class="rounded-lg bg-green-100 px-3 py-1.5 text-xs font-semibold text-green-700">
                    Editing
                </div>

            </div>

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
                    value="{{ old('name', $customer->name) }}"
                    required
                    class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-500 focus:ring-4 focus:ring-green-100 @error('name') border-red-400 @enderror"
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

                    <input
                        type="text"
                        id="phone"
                        name="phone"
                        value="{{ old('phone', $customer->phone) }}"
                        placeholder="e.g. 0712 345 678"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-4 focus:ring-green-100 @error('phone') border-red-400 @enderror"
                    >

                    @error('phone')
                        <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                    @enderror

                </div>


                <div>

                    <label for="email"
                           class="mb-2 block text-sm font-semibold text-slate-700">
                        Email Address
                    </label>

                    <input
                        type="email"
                        id="email"
                        name="email"
                        value="{{ old('email', $customer->email) }}"
                        placeholder="customer@example.com"
                        class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-4 focus:ring-green-100 @error('email') border-red-400 @enderror"
                    >

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
                    class="w-full resize-none rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-4 focus:ring-green-100 @error('address') border-red-400 @enderror"
                >{{ old('address', $customer->address) }}</textarea>

                @error('address')
                    <p class="mt-1.5 text-sm text-red-600">{{ $message }}</p>
                @enderror

            </div>

        </div>


        {{-- Footer --}}
        <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:justify-end">

            <a href="{{ route('customers.show', $customer) }}"
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
                        d="M5 13l4 4L19 7"/>
                </svg>

                Update Customer

            </button>

        </div>

    </form>

</div>

@endsection
