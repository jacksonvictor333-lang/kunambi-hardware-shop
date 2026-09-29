@extends('layouts.app')

@section('title', 'Create Permission')

@section('content')

<div class="mx-auto max-w-5xl space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-green-600">

                <svg class="h-6 w-6"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.045-.133-2.059-.382-3.016z"/>

                </svg>

            </div>

            <div>

                <h1 class="text-2xl font-bold text-slate-900">
                    Create Permission
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Add a new permission to control system access.
                </p>

            </div>

        </div>


        <a href="{{ route('permissions.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

            <svg class="h-5 w-5"
                 fill="none"
                 stroke="currentColor"
                 viewBox="0 0 24 24">

                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M10 19l-7-7m0 0l7-7m-7 7h18"/>

            </svg>

            Back to Permissions
        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="rounded-xl border border-red-200 bg-red-50 p-4">

            <div class="flex items-start gap-3">

                <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-red-600"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M12 8v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.5 20h15a2 2 0 001.71-3.14l-7.5-13a2 2 0 00-3.42 0z"/>

                </svg>

                <div>

                    <h3 class="font-semibold text-red-800">
                        Please correct the following errors:
                    </h3>

                    <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-700">

                        @foreach($errors->all() as $error)

                            <li>{{ $error }}</li>

                        @endforeach

                    </ul>

                </div>

            </div>

        </div>

    @endif


    {{-- Main Form --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">

            <h2 class="text-lg font-bold text-slate-900">
                Permission Information
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Define the permission name, display name and module.
            </p>

        </div>


        <form method="POST"
              action="{{ route('permissions.store') }}"
              class="p-6">

            @csrf

            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Permission Name --}}
                <div>

                    <label for="name"
                           class="mb-2 block text-sm font-semibold text-slate-700">

                        Permission Name
                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="e.g. create-sale"
                        required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >

                    <p class="mt-2 text-xs leading-5 text-slate-500">
                        Use lowercase letters, numbers, hyphens or underscores.
                        Example: <code>create-sale</code>
                    </p>

                    @error('name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Display Name --}}
                <div>

                    <label for="display_name"
                           class="mb-2 block text-sm font-semibold text-slate-700">

                        Display Name
                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="text"
                        id="display_name"
                        name="display_name"
                        value="{{ old('display_name') }}"
                        placeholder="e.g. Create Sale"
                        required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >

                    <p class="mt-2 text-xs leading-5 text-slate-500">
                        This is the friendly name displayed to administrators.
                    </p>

                    @error('display_name')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Module --}}
                <div>

                    <label for="module"
                           class="mb-2 block text-sm font-semibold text-slate-700">

                        Module
                        <span class="text-red-500">*</span>

                    </label>

                    <select
                        id="module"
                        name="module"
                        required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100">

                        <option value="">
                            Select Module
                        </option>

                        <option value="Dashboard" @selected(old('module') === 'Dashboard')>
                            Dashboard
                        </option>

                        <option value="Products" @selected(old('module') === 'Products')>
                            Products
                        </option>

                        <option value="Categories" @selected(old('module') === 'Categories')>
                            Categories
                        </option>

                        <option value="Brands" @selected(old('module') === 'Brands')>
                            Brands
                        </option>

                        <option value="Inventory" @selected(old('module') === 'Inventory')>
                            Inventory
                        </option>

                        <option value="Sales" @selected(old('module') === 'Sales')>
                            Sales
                        </option>

                        <option value="Customers" @selected(old('module') === 'Customers')>
                            Customers
                        </option>

                        <option value="Expenses" @selected(old('module') === 'Expenses')>
                            Expenses
                        </option>

                        <option value="Reports" @selected(old('module') === 'Reports')>
                            Reports
                        </option>

                        <option value="Users" @selected(old('module') === 'Users')>
                            Users
                        </option>

                        <option value="Roles" @selected(old('module') === 'Roles')>
                            Roles
                        </option>

                        <option value="Settings" @selected(old('module') === 'Settings')>
                            Settings
                        </option>

                        <option value="Audit Logs" @selected(old('module') === 'Audit Logs')>
                            Audit Logs
                        </option>

                    </select>

                    <p class="mt-2 text-xs leading-5 text-slate-500">
                        Choose the system module where this permission belongs.
                    </p>

                    @error('module')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>


                {{-- Description --}}
                <div class="md:col-span-2">

                    <label for="description"
                           class="mb-2 block text-sm font-semibold text-slate-700">

                        Description

                    </label>

                    <textarea
                        id="description"
                        name="description"
                        rows="4"
                        placeholder="Describe what this permission allows the user to do..."
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-2 focus:ring-green-100">{{ old('description') }}</textarea>

                    <p class="mt-2 text-xs text-slate-500">
                        Optional. Maximum 1000 characters.
                    </p>

                    @error('description')
                        <p class="mt-1 text-sm text-red-600">
                            {{ $message }}
                        </p>
                    @enderror

                </div>

            </div>


            {{-- Example --}}
            <div class="mt-8 rounded-2xl border border-blue-200 bg-blue-50 p-5">

                <div class="flex items-start gap-4">

                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-600">

                        <svg class="h-5 w-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 100-20 10 10 0 000 20z"/>

                        </svg>

                    </div>

                    <div>

                        <h3 class="font-semibold text-blue-900">
                            Permission Naming Example
                        </h3>

                        <div class="mt-3 space-y-2 text-sm text-blue-800">

                            <p>
                                <code class="rounded bg-white px-2 py-1 font-semibold">
                                    view-products
                                </code>
                                — Allows a user to view products.
                            </p>

                            <p>
                                <code class="rounded bg-white px-2 py-1 font-semibold">
                                    create-product
                                </code>
                                — Allows a user to create products.
                            </p>

                            <p>
                                <code class="rounded bg-white px-2 py-1 font-semibold">
                                    edit-product
                                </code>
                                — Allows a user to edit products.
                            </p>

                            <p>
                                <code class="rounded bg-white px-2 py-1 font-semibold">
                                    delete-product
                                </code>
                                — Allows a user to delete products.
                            </p>

                        </div>

                    </div>

                </div>

            </div>


            {{-- Form Actions --}}
            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-end">

                <a
                    href="{{ route('permissions.index') }}"
                    class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">

                    Cancel

                </a>


                <button
                    type="submit"
                    class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-6 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">

                    <svg class="h-5 w-5"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 4v16m8-8H4"/>

                    </svg>

                    Create Permission

                </button>

            </div>

        </form>

    </div>


    {{-- Information --}}
    <div class="rounded-2xl border border-green-200 bg-green-50 p-5">

        <div class="flex items-start gap-4">

            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-700">

                <svg class="h-5 w-5"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.045-.133-2.059-.382-3.016z"/>

                </svg>

            </div>

            <div>

                <h3 class="font-semibold text-green-900">
                    What happens after creation?
                </h3>

                <p class="mt-1 text-sm leading-6 text-green-800">
                    Creating a permission only adds it to the system.
                    You will assign the permission to one or more roles from
                    the Role Permissions management page.
                </p>

            </div>

        </div>

    </div>

</div>

@endsection
