@extends('layouts.app')

@section('title', 'Expenses')

@section('content')

@php
    $currentUser = auth()->user();

    $canCreateExpenses = $currentUser?->hasPermission('create-expenses') ?? true;
    $canEditExpenses = $currentUser?->hasPermission('edit-expenses') ?? true;
    $canDeleteExpenses = $currentUser?->hasPermission('delete-expenses') ?? true;
@endphp

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <div class="flex items-center gap-2 text-sm text-slate-500">
                <a href="{{ route('dashboard') }}"
                   class="hover:text-green-600 transition">
                    Dashboard
                </a>

                <span>/</span>

                <span class="text-slate-700">
                    Expenses
                </span>
            </div>

            <div class="mt-2">
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    Expenses
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Track and manage all business expenses.
                </p>
            </div>
        </div>

        @if($canCreateExpenses)
            <a href="{{ route('expenses.create') }}"
               class="inline-flex items-center justify-center gap-2 rounded-xl
                      bg-green-600 px-5 py-3 text-sm font-semibold text-white
                      shadow-sm transition hover:bg-green-700
                      focus:outline-none focus:ring-2 focus:ring-green-500
                      focus:ring-offset-2">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 4v16m8-8H4"/>
                </svg>

                Add Expense
            </a>
        @else
            <button type="button"
                    disabled
                    title="You do not have permission to create expenses"
                    class="inline-flex cursor-not-allowed items-center justify-center gap-2
                           rounded-xl bg-slate-100 px-5 py-3 text-sm font-semibold
                           text-slate-400">

                <svg xmlns="http://www.w3.org/2000/svg"
                     class="h-5 w-5"
                     fill="none"
                     viewBox="0 0 24 24"
                     stroke="currentColor"
                     stroke-width="2">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          d="M12 4v16m8-8H4"/>
                </svg>

                Add Expense
            </button>
        @endif

    </div>


    {{-- Success Message --}}
    @if(session('success'))
        <div class="flex items-start gap-3 rounded-xl border border-green-200
                    bg-green-50 px-4 py-3 text-green-800">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="mt-0.5 h-5 w-5 shrink-0"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M9 12l2 2 4-4"/>
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 22a10 10 0 100-20 10 10 0 000 20z"/>
            </svg>

            <div class="text-sm font-medium">
                {{ session('success') }}
            </div>
        </div>
    @endif


    {{-- Error Message --}}
    @if(session('error'))
        <div class="flex items-start gap-3 rounded-xl border border-red-200
                    bg-red-50 px-4 py-3 text-red-800">

            <svg xmlns="http://www.w3.org/2000/svg"
                 class="mt-0.5 h-5 w-5 shrink-0"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor"
                 stroke-width="2">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M12 8v4m0 4h.01"/>
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>

            <div class="text-sm font-medium">
                {{ session('error') }}
            </div>
        </div>
    @endif


    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 p-4">
            <p class="font-semibold text-red-800">
                Please correct the following:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Statistics --}}
    <div class="grid gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Expenses
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        TZS {{ number_format($totalExpenses, 0) }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6 text-green-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.657 0 3 .895 3 2m-3-2V5m0 14v-2m0-10V5m0 14v-2"/>
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M19 12a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>
                </div>

            </div>
        </div>


        {{-- Today --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Today
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        TZS {{ number_format($todayExpenses, 0) }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6 text-blue-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M12 8v4l3 2"/>
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                </div>

            </div>
        </div>


        {{-- Month --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        This Month
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        TZS {{ number_format($monthExpenses, 0) }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-amber-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6 text-amber-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M8 7V3m8 4V3m-9 8h10m-12 9h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v11a2 2 0 002 2z"/>
                    </svg>
                </div>

            </div>
        </div>


        {{-- Count --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Expense Records
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        {{ number_format($expenseCount) }}
                    </p>
                </div>

                <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-purple-100">
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-6 w-6 text-purple-600"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9 5h6M9 9h6m-7 4h8m-8 4h5"/>
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                    </svg>
                </div>

            </div>
        </div>

    </div>


    {{-- Filters --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <div class="mb-4">
            <h2 class="text-base font-semibold text-slate-900">
                Search & Filters
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Find expenses by title, category, payment method or date.
            </p>
        </div>

        <form method="GET"
              action="{{ route('expenses.index') }}"
              class="grid gap-4 md:grid-cols-2 xl:grid-cols-6">

            {{-- Search --}}
            <div class="xl:col-span-2">
                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                    Search
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search expenses..."
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5
                           text-sm text-slate-900 outline-none transition
                           placeholder:text-slate-400
                           focus:border-green-500 focus:ring-2 focus:ring-green-500/20"
                >
            </div>


            {{-- Category --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                    Category
                </label>

                <select
                    name="category"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5
                           text-sm text-slate-900 outline-none transition
                           focus:border-green-500 focus:ring-2 focus:ring-green-500/20"
                >
                    <option value="">All Categories</option>

                    @foreach($categories as $category)
                        <option value="{{ $category }}"
                            @selected(request('category') === $category)>
                            {{ $category }}
                        </option>
                    @endforeach
                </select>
            </div>


            {{-- Payment --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                    Payment Method
                </label>

                <select
                    name="payment_method"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5
                           text-sm text-slate-900 outline-none transition
                           focus:border-green-500 focus:ring-2 focus:ring-green-500/20"
                >
                    <option value="">All Methods</option>

                    <option value="cash"
                        @selected(request('payment_method') === 'cash')>
                        Cash
                    </option>

                    <option value="bank"
                        @selected(request('payment_method') === 'bank')>
                        Bank
                    </option>

                    <option value="mobile_money"
                        @selected(request('payment_method') === 'mobile_money')>
                        Mobile Money
                    </option>
                </select>
            </div>


            {{-- From --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                    From
                </label>

                <input
                    type="date"
                    name="date_from"
                    value="{{ request('date_from') }}"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5
                           text-sm text-slate-900 outline-none transition
                           focus:border-green-500 focus:ring-2 focus:ring-green-500/20"
                >
            </div>


            {{-- To --}}
            <div>
                <label class="mb-1.5 block text-sm font-medium text-slate-700">
                    To
                </label>

                <input
                    type="date"
                    name="date_to"
                    value="{{ request('date_to') }}"
                    class="w-full rounded-xl border border-slate-300 bg-white px-4 py-2.5
                           text-sm text-slate-900 outline-none transition
                           focus:border-green-500 focus:ring-2 focus:ring-green-500/20"
                >
            </div>


            {{-- Buttons --}}
            <div class="flex items-end gap-2 xl:col-span-6">

                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl
                           bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white
                           transition hover:bg-slate-800"
                >
                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-4 w-4"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M21 21l-4.35-4.35m2.35-5.65a7 7 0 11-14 0 7 7 0 0114 0z"/>
                    </svg>

                    Search
                </button>

                <a href="{{ route('expenses.index') }}"
                   class="inline-flex items-center justify-center rounded-xl
                          border border-slate-300 bg-white px-5 py-2.5
                          text-sm font-semibold text-slate-700
                          transition hover:bg-slate-50">
                    Reset
                </a>

            </div>

        </form>

    </div>


    {{-- Desktop Table --}}
    <div class="hidden overflow-hidden rounded-2xl border border-slate-200
                bg-white shadow-sm lg:block">

        <div class="border-b border-slate-200 px-6 py-4">
            <div class="flex items-center justify-between">

                <div>
                    <h2 class="font-semibold text-slate-900">
                        Expense Records
                    </h2>

                    <p class="mt-1 text-xs text-slate-500">
                        Showing {{ $expenses->firstItem() ?? 0 }}
                        -
                        {{ $expenses->lastItem() ?? 0 }}
                        of {{ $expenses->total() }} records
                    </p>
                </div>

            </div>
        </div>


        <div class="overflow-x-auto">

            <table class="w-full text-left">

                <thead class="bg-slate-50 text-xs uppercase tracking-wider text-slate-500">

                    <tr>
                        <th class="px-6 py-4 font-semibold">
                            Date
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Expense
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Category
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Paid To
                        </th>

                        <th class="px-6 py-4 font-semibold">
                            Payment
                        </th>

                        <th class="px-6 py-4 text-right font-semibold">
                            Amount
                        </th>

                        <th class="px-6 py-4 text-right font-semibold">
                            Actions
                        </th>
                    </tr>

                </thead>

                <tbody class="divide-y divide-slate-100">

                    @forelse($expenses as $expense)

                        <tr class="transition hover:bg-slate-50">

                            {{-- Date --}}
                            <td class="whitespace-nowrap px-6 py-4">
                                <div class="text-sm font-medium text-slate-900">
                                    {{ $expense->expense_date?->format('d M Y') }}
                                </div>

                                <div class="text-xs text-slate-400">
                                    {{ $expense->created_at?->format('h:i A') }}
                                </div>
                            </td>


                            {{-- Expense --}}
                            <td class="px-6 py-4">

                                <div class="font-medium text-slate-900">
                                    {{ $expense->title }}
                                </div>

                                @if($expense->reference_number)
                                    <div class="mt-1 text-xs text-slate-400">
                                        Ref: {{ $expense->reference_number }}
                                    </div>
                                @endif

                            </td>


                            {{-- Category --}}
                            <td class="px-6 py-4">

                                <span class="inline-flex rounded-full bg-green-50
                                             px-2.5 py-1 text-xs font-semibold
                                             text-green-700">
                                    {{ $expense->category }}
                                </span>

                            </td>


                            {{-- Paid To --}}
                            <td class="px-6 py-4 text-sm text-slate-600">
                                {{ $expense->paid_to ?: '—' }}
                            </td>


                            {{-- Payment --}}
                            <td class="px-6 py-4">

                                @php
                                    $paymentLabel = match ($expense->payment_method) {
                                        'cash' => 'Cash',
                                        'bank' => 'Bank',
                                        'mobile_money' => 'Mobile Money',
                                        default => ucfirst($expense->payment_method),
                                    };
                                @endphp

                                <span class="inline-flex rounded-lg bg-slate-100
                                             px-2.5 py-1 text-xs font-medium
                                             text-slate-700">
                                    {{ $paymentLabel }}
                                </span>

                            </td>


                            {{-- Amount --}}
                            <td class="whitespace-nowrap px-6 py-4 text-right">

                                <span class="font-bold text-slate-900">
                                    TZS {{ number_format($expense->amount, 0) }}
                                </span>

                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center justify-end gap-2">

                                    {{-- View --}}
                                    <a href="{{ route('expenses.show', $expense) }}"
                                       title="View Expense"
                                       class="inline-flex h-9 w-9 items-center justify-center
                                              rounded-lg border border-slate-200
                                              text-slate-600 transition
                                              hover:border-blue-200 hover:bg-blue-50
                                              hover:text-blue-600">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                                        </svg>

                                    </a>


                                    {{-- Edit --}}
                                    @if($canEditExpenses)

                                        <a href="{{ route('expenses.edit', $expense) }}"
                                           title="Edit Expense"
                                           class="inline-flex h-9 w-9 items-center justify-center
                                                  rounded-lg border border-slate-200
                                                  text-slate-600 transition
                                                  hover:border-amber-200 hover:bg-amber-50
                                                  hover:text-amber-600">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-4 w-4"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 stroke-width="2">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5"/>
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M18.5 2.5a2.121 2.121 0 013 3L12 15l-4 1 1-4 9.5-9.5z"/>
                                            </svg>

                                        </a>

                                    @else

                                        <button type="button"
                                                disabled
                                                title="You do not have permission to edit expenses"
                                                class="inline-flex h-9 w-9 cursor-not-allowed
                                                       items-center justify-center rounded-lg
                                                       bg-slate-50 text-slate-300">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-4 w-4"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 stroke-width="2">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M12 15v2m0-8v2m0 6h.01M5 20h14a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                            </svg>

                                        </button>

                                    @endif


                                    {{-- Delete --}}
                                    @if($canDeleteExpenses)

                                        <form action="{{ route('expenses.destroy', $expense) }}"
                                              method="POST"
                                              onsubmit="return confirm('Are you sure you want to delete this expense?');">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                title="Delete Expense"
                                                class="inline-flex h-9 w-9 items-center justify-center
                                                       rounded-lg border border-slate-200
                                                       text-slate-600 transition
                                                       hover:border-red-200 hover:bg-red-50
                                                       hover:text-red-600">

                                                <svg xmlns="http://www.w3.org/2000/svg"
                                                     class="h-4 w-4"
                                                     fill="none"
                                                     viewBox="0 0 24 24"
                                                     stroke="currentColor"
                                                     stroke-width="2">
                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14"/>
                                                </svg>

                                            </button>

                                        </form>

                                    @else

                                        <button type="button"
                                                disabled
                                                title="You do not have permission to delete expenses"
                                                class="inline-flex h-9 w-9 cursor-not-allowed
                                                       items-center justify-center rounded-lg
                                                       bg-slate-50 text-slate-300">

                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                 class="h-4 w-4"
                                                 fill="none"
                                                 viewBox="0 0 24 24"
                                                 stroke="currentColor"
                                                 stroke-width="2">
                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h14"/>
                                            </svg>

                                        </button>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>
                            <td colspan="7" class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-14 w-14 items-center
                                            justify-center rounded-2xl bg-slate-100">

                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         class="h-7 w-7 text-slate-400"
                                         fill="none"
                                         viewBox="0 0 24 24"
                                         stroke="currentColor"
                                         stroke-width="2">
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M9 5h6M9 9h6m-7 4h8m-8 4h5"/>
                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              d="M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                                    </svg>

                                </div>

                                <h3 class="mt-4 font-semibold text-slate-900">
                                    No expenses found
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Start by recording your first business expense.
                                </p>

                                @if($canCreateExpenses)
                                    <a href="{{ route('expenses.create') }}"
                                       class="mt-5 inline-flex items-center gap-2 rounded-xl
                                              bg-green-600 px-4 py-2.5 text-sm font-semibold
                                              text-white hover:bg-green-700">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-4 w-4"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M12 4v16m8-8H4"/>
                                        </svg>

                                        Add Expense
                                    </a>
                                @endif

                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($expenses->hasPages())
            <div class="border-t border-slate-200 px-6 py-4">
                {{ $expenses->links() }}
            </div>
        @endif

    </div>


    {{-- Mobile Cards --}}
    <div class="space-y-4 lg:hidden">

        @forelse($expenses as $expense)

            <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

                <div class="flex items-start justify-between gap-4">

                    <div>
                        <h3 class="font-semibold text-slate-900">
                            {{ $expense->title }}
                        </h3>

                        <p class="mt-1 text-xs text-slate-500">
                            {{ $expense->expense_date?->format('d M Y') }}
                        </p>
                    </div>

                    <div class="text-right">
                        <p class="font-bold text-slate-900">
                            TZS {{ number_format($expense->amount, 0) }}
                        </p>

                        <p class="mt-1 text-xs text-slate-500">
                            {{ ucfirst(str_replace('_', ' ', $expense->payment_method)) }}
                        </p>
                    </div>

                </div>


                <div class="mt-4 flex flex-wrap gap-2">

                    <span class="rounded-full bg-green-50 px-2.5 py-1
                                 text-xs font-semibold text-green-700">
                        {{ $expense->category }}
                    </span>

                    @if($expense->paid_to)
                        <span class="rounded-full bg-slate-100 px-2.5 py-1
                                     text-xs font-medium text-slate-600">
                            {{ $expense->paid_to }}
                        </span>
                    @endif

                </div>


                <div class="mt-4 flex items-center gap-2 border-t border-slate-100 pt-4">

                    <a href="{{ route('expenses.show', $expense) }}"
                       class="flex-1 rounded-xl border border-slate-200 px-3 py-2
                              text-center text-sm font-semibold text-slate-700
                              hover:bg-slate-50">
                        View
                    </a>

                    @if($canEditExpenses)
                        <a href="{{ route('expenses.edit', $expense) }}"
                           class="flex-1 rounded-xl bg-amber-50 px-3 py-2
                                  text-center text-sm font-semibold text-amber-700
                                  hover:bg-amber-100">
                            Edit
                        </a>
                    @else
                        <button disabled
                                class="flex-1 cursor-not-allowed rounded-xl bg-slate-50
                                       px-3 py-2 text-sm font-semibold text-slate-300">
                            Edit
                        </button>
                    @endif


                    @if($canDeleteExpenses)
                        <form action="{{ route('expenses.destroy', $expense) }}"
                              method="POST"
                              class="flex-1"
                              onsubmit="return confirm('Are you sure you want to delete this expense?');">

                            @csrf
                            @method('DELETE')

                            <button type="submit"
                                    class="w-full rounded-xl bg-red-50 px-3 py-2
                                           text-sm font-semibold text-red-700
                                           hover:bg-red-100">
                                Delete
                            </button>

                        </form>
                    @else
                        <button disabled
                                class="flex-1 cursor-not-allowed rounded-xl bg-slate-50
                                       px-3 py-2 text-sm font-semibold text-slate-300">
                            Delete
                        </button>
                    @endif

                </div>

            </div>

        @empty

            <div class="rounded-2xl border border-slate-200 bg-white p-10 text-center shadow-sm">

                <div class="mx-auto flex h-14 w-14 items-center justify-center
                            rounded-2xl bg-slate-100">

                    <svg xmlns="http://www.w3.org/2000/svg"
                         class="h-7 w-7 text-slate-400"
                         fill="none"
                         viewBox="0 0 24 24"
                         stroke="currentColor"
                         stroke-width="2">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M9 5h6M9 9h6m-7 4h8m-8 4h5"/>
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              d="M7 3h10a2 2 0 012 2v14a2 2 0 01-2 2H7a2 2 0 01-2-2V5a2 2 0 012-2z"/>
                    </svg>

                </div>

                <h3 class="mt-4 font-semibold text-slate-900">
                    No expenses found
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    There are no expense records matching your search.
                </p>

            </div>

        @endforelse


        @if($expenses->hasPages())
            <div>
                {{ $expenses->links() }}
            </div>
        @endif

    </div>

</div>

@endsection
