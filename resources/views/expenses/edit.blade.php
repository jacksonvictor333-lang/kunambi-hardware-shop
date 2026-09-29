
@extends('layouts.app')

@section('title', 'Edit Expense')

@section('content')

<div class="min-h-screen bg-slate-50 py-6">

    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">

        {{-- Header --}}
        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <div class="flex items-center gap-3">

                    <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100">
                        <svg class="h-6 w-6 text-amber-600"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">
                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 8.5-8.5z"/>
                        </svg>
                    </div>

                    <div>
                        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                            Edit Expense
                        </h1>

                        <p class="mt-1 text-sm text-slate-500">
                            Update expense information
                        </p>
                    </div>

                </div>
            </div>


            <a href="{{ route('expenses.index') }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

                <svg class="h-4 w-4"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>

                Back to Expenses

            </a>

        </div>


        {{-- Validation Errors --}}
        @if ($errors->any())

            <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4">

                <div class="flex items-start gap-3">

                    <div class="mt-0.5 flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100">

                        <svg class="h-5 w-5 text-red-600"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>

                        </svg>

                    </div>

                    <div>

                        <h3 class="text-sm font-semibold text-red-800">
                            Please correct the following errors:
                        </h3>

                        <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">

                            @foreach ($errors->all() as $error)

                                <li>{{ $error }}</li>

                            @endforeach

                        </ul>

                    </div>

                </div>

            </div>

        @endif


        {{-- Form --}}
        <form action="{{ route('expenses.update', $expense) }}"
              method="POST"
              enctype="multipart/form-data">

            @csrf

            @method('PUT')


            {{-- Main Card --}}
            <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">


                {{-- Card Header --}}
                <div class="border-b border-slate-200 bg-white px-6 py-5">

                    <div class="flex items-center gap-3">

                        <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50">

                            <svg class="h-5 w-5 text-amber-600"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 8.5-8.5z"/>

                            </svg>

                        </div>

                        <div>

                            <h2 class="text-base font-semibold text-slate-900">
                                Expense Information
                            </h2>

                            <p class="text-sm text-slate-500">
                                Modify the details of this expense.
                            </p>

                        </div>

                    </div>

                </div>


                {{-- Form Body --}}
                <div class="space-y-8 p-6">


                    {{-- Basic Information --}}
                    <div>

                        <div class="mb-4 flex items-center gap-2">

                            <div class="h-1.5 w-1.5 rounded-full bg-amber-500"></div>

                            <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-700">
                                Basic Information
                            </h3>

                        </div>


                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">


                            {{-- Expense Title --}}
                            <div class="md:col-span-2">

                                <label for="title"
                                       class="mb-2 block text-sm font-semibold text-slate-700">

                                    Expense Title

                                    <span class="text-red-500">*</span>

                                </label>

                                <input
                                    type="text"
                                    id="title"
                                    name="title"
                                    value="{{ old('title', $expense->title) }}"
                                    required
                                    placeholder="e.g. Electricity Bill, Shop Rent, Transport"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100"
                                >

                                @error('title')

                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Category --}}
                            <div>

                                <label for="category"
                                       class="mb-2 block text-sm font-semibold text-slate-700">

                                    Expense Category

                                    <span class="text-red-500">*</span>

                                </label>

                                <select
                                    id="category"
                                    name="category"
                                    required
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-500 focus:ring-4 focus:ring-green-100"
                                >

                                    <option value="">
                                        Select category
                                    </option>

                                    @foreach ($categories as $category)

                                        <option value="{{ $category }}"
                                            @selected(old('category', $expense->category) === $category)>

                                            {{ $category }}

                                        </option>

                                    @endforeach

                                </select>

                                @error('category')

                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Expense Date --}}
                            <div>

                                <label for="expense_date"
                                       class="mb-2 block text-sm font-semibold text-slate-700">

                                    Expense Date

                                    <span class="text-red-500">*</span>

                                </label>

                                <input
                                    type="date"
                                    id="expense_date"
                                    name="expense_date"
                                    value="{{ old('expense_date', optional($expense->expense_date)->format('Y-m-d')) }}"
                                    required
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-500 focus:ring-4 focus:ring-green-100"
                                >

                                @error('expense_date')

                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Amount --}}
                            <div>

                                <label for="amount"
                                       class="mb-2 block text-sm font-semibold text-slate-700">

                                    Amount

                                    <span class="text-red-500">*</span>

                                </label>

                                <div class="relative">

                                    <span class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-sm font-semibold text-slate-500">
                                        TZS
                                    </span>

                                    <input
                                        type="number"
                                        id="amount"
                                        name="amount"
                                        value="{{ old('amount', $expense->amount) }}"
                                        min="0.01"
                                        step="0.01"
                                        required
                                        placeholder="0.00"
                                        class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-14 pr-4 text-sm font-semibold text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100"
                                    >

                                </div>

                                @error('amount')

                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Payment Method --}}
                            <div>

                                <label for="payment_method"
                                       class="mb-2 block text-sm font-semibold text-slate-700">

                                    Payment Method

                                    <span class="text-red-500">*</span>

                                </label>

                                <select
                                    id="payment_method"
                                    name="payment_method"
                                    required
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-500 focus:ring-4 focus:ring-green-100"
                                >

                                    <option value="">
                                        Select payment method
                                    </option>

                                    <option value="cash"
                                        @selected(old('payment_method', $expense->payment_method) === 'cash')>
                                        Cash
                                    </option>

                                    <option value="bank"
                                        @selected(old('payment_method', $expense->payment_method) === 'bank')>
                                        Bank
                                    </option>

                                    <option value="mobile_money"
                                        @selected(old('payment_method', $expense->payment_method) === 'mobile_money')>
                                        Mobile Money
                                    </option>

                                </select>

                                @error('payment_method')

                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Payment Details --}}
                    <div class="border-t border-slate-100 pt-8">

                        <div class="mb-4 flex items-center gap-2">

                            <div class="h-1.5 w-1.5 rounded-full bg-amber-500"></div>

                            <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-700">
                                Payment Details
                            </h3>

                        </div>


                        <div class="grid grid-cols-1 gap-5 md:grid-cols-2">


                            {{-- Paid To --}}
                            <div>

                                <label for="paid_to"
                                       class="mb-2 block text-sm font-semibold text-slate-700">

                                    Paid To

                                </label>

                                <input
                                    type="text"
                                    id="paid_to"
                                    name="paid_to"
                                    value="{{ old('paid_to', $expense->paid_to) }}"
                                    placeholder="e.g. TANESCO, Landlord, Supplier"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100"
                                >

                                @error('paid_to')

                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Reference Number --}}
                            <div>

                                <label for="reference_number"
                                       class="mb-2 block text-sm font-semibold text-slate-700">

                                    Reference Number

                                </label>

                                <input
                                    type="text"
                                    id="reference_number"
                                    name="reference_number"
                                    value="{{ old('reference_number', $expense->reference_number) }}"
                                    placeholder="e.g. INV-00125"
                                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100"
                                >

                                @error('reference_number')

                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Additional Information --}}
                    <div class="border-t border-slate-100 pt-8">

                        <div class="mb-4 flex items-center gap-2">

                            <div class="h-1.5 w-1.5 rounded-full bg-amber-500"></div>

                            <h3 class="text-sm font-semibold uppercase tracking-wide text-slate-700">
                                Additional Information
                            </h3>

                        </div>


                        <div class="space-y-5">


                            {{-- Description --}}
                            <div>

                                <label for="description"
                                       class="mb-2 block text-sm font-semibold text-slate-700">

                                    Description / Notes

                                </label>

                                <textarea
                                    id="description"
                                    name="description"
                                    rows="4"
                                    maxlength="2000"
                                    placeholder="Add any additional notes about this expense..."
                                    class="w-full resize-none rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-4 focus:ring-green-100"
                                >{{ old('description', $expense->description) }}</textarea>

                                @error('description')

                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>


                            {{-- Existing Attachment --}}
                            @if ($expense->attachment)

                                <div>

                                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                                        Current Attachment
                                    </label>

                                    <div class="flex flex-col gap-3 rounded-xl border border-slate-200 bg-slate-50 p-4 sm:flex-row sm:items-center sm:justify-between">

                                        <div class="flex items-center gap-3">

                                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-slate-200">

                                                <svg class="h-5 w-5 text-green-600"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     viewBox="0 0 24 24">

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>

                                                </svg>

                                            </div>

                                            <div class="min-w-0">

                                                <p class="text-sm font-semibold text-slate-800">
                                                    Existing Receipt
                                                </p>

                                                <p class="max-w-xs truncate text-xs text-slate-500">
                                                    {{ basename($expense->attachment) }}
                                                </p>

                                            </div>

                                        </div>


                                        <a href="{{ asset('storage/' . $expense->attachment) }}"
                                           target="_blank"
                                           class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-100">

                                            <svg class="h-4 w-4"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>

                                            </svg>

                                            View File

                                        </a>

                                    </div>

                                </div>

                            @endif


                            {{-- New Attachment --}}
                            <div>

                                <label for="attachment"
                                       class="mb-2 block text-sm font-semibold text-slate-700">

                                    Replace Receipt / Attachment

                                </label>


                                <div class="rounded-xl border-2 border-dashed border-slate-300 bg-slate-50 p-6 transition hover:border-amber-400 hover:bg-amber-50/40">

                                    <div class="text-center">

                                        <div class="mx-auto flex h-12 w-12 items-center justify-center rounded-xl bg-white shadow-sm ring-1 ring-slate-200">

                                            <svg class="h-6 w-6 text-slate-500"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M15.172 7l-6.586 6.586a2 2 0 102.828 2.828l6.414-6.414a4 4 0 00-5.656-5.656l-6.415 6.414a6 6 0 108.486 8.486L20.5 13"/>

                                            </svg>

                                        </div>


                                        <label for="attachment"
                                               class="mt-3 inline-flex cursor-pointer items-center rounded-lg bg-white px-4 py-2 text-sm font-semibold text-amber-700 shadow-sm ring-1 ring-slate-200 transition hover:bg-amber-50">

                                            Choose New File

                                            <input
                                                type="file"
                                                id="attachment"
                                                name="attachment"
                                                accept=".jpg,.jpeg,.png,.pdf"
                                                class="sr-only"
                                            >

                                        </label>


                                        <p id="file-name"
                                           class="mt-2 text-sm text-slate-500">

                                            No new file selected

                                        </p>


                                        <p class="mt-1 text-xs text-slate-400">
                                            JPG, JPEG, PNG or PDF · Maximum 5MB
                                        </p>

                                    </div>

                                </div>

                                @error('attachment')

                                    <p class="mt-1.5 text-xs font-medium text-red-600">
                                        {{ $message }}
                                    </p>

                                @enderror

                            </div>

                        </div>

                    </div>


                    {{-- Update Notice --}}
                    <div class="rounded-2xl border border-amber-100 bg-amber-50 p-4">

                        <div class="flex items-start gap-3">

                            <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-xl bg-white">

                                <svg class="h-5 w-5 text-amber-600"
                                     fill="none"
                                     stroke="currentColor"
                                     viewBox="0 0 24 24">

                                    <path stroke-linecap="round"
                                          stroke-linejoin="round"
                                          stroke-width="2"
                                          d="M13 16h-1v-4h-1m1-4h.01M12 21a9 9 0 100-18 9 9 0 000 18z"/>

                                </svg>

                            </div>

                            <div>

                                <p class="text-sm font-semibold text-amber-900">
                                    Updating Expense
                                </p>

                                <p class="mt-1 text-sm leading-6 text-amber-800">
                                    Saving changes will update this expense record.
                                    If you upload a new attachment, the previous attachment
                                    will be replaced.
                                </p>

                            </div>

                        </div>

                    </div>

                </div>


                {{-- Footer --}}
                <div class="flex flex-col-reverse gap-3 border-t border-slate-200 bg-slate-50 px-6 py-5 sm:flex-row sm:items-center sm:justify-end">

                    <a href="{{ route('expenses.index') }}"
                       class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-100">

                        Cancel

                    </a>


                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-4 focus:ring-green-100">

                        <svg class="h-5 w-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M5 13l4 4L19 7"/>

                        </svg>

                        Update Expense

                    </button>

                </div>

            </div>

        </form>

    </div>

</div>


<script>
    document.addEventListener('DOMContentLoaded', function () {

        const fileInput = document.getElementById('attachment');
        const fileName = document.getElementById('file-name');

        if (fileInput && fileName) {

            fileInput.addEventListener('change', function () {

                if (this.files && this.files.length > 0) {

                    fileName.textContent = this.files[0].name;

                    fileName.classList.remove('text-slate-500');

                    fileName.classList.add(
                        'font-medium',
                        'text-amber-600'
                    );

                } else {

                    fileName.textContent = 'No new file selected';

                    fileName.classList.remove(
                        'font-medium',
                        'text-amber-600'
                    );

                    fileName.classList.add('text-slate-500');

                }

            });

        }

    });
</script>

@endsection
