@extends('layouts.app')

@section('title', 'Create Role')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <p class="text-sm font-semibold text-green-600">
                KUNAMBI HARDWARE SHOP
            </p>

            <h1 class="mt-1 text-2xl font-bold tracking-tight text-slate-900">
                Create New Role
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Create a new role for managing user access and permissions.
            </p>
        </div>

        <a href="{{ route('roles.index') }}"
           class="inline-flex items-center justify-center rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

            ← Back to Roles

        </a>

    </div>


    {{-- Validation Errors --}}
    @if($errors->any())

        <div class="rounded-xl border border-red-200 bg-red-50 px-5 py-4">

            <div class="flex gap-3">

                <div class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full bg-red-100 font-bold text-red-700">
                    !
                </div>

                <div>

                    <h3 class="font-semibold text-red-800">
                        Please fix the following errors
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


    {{-- Create Role Form --}}
    <form action="{{ route('roles.store') }}"
          method="POST"
          class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        @csrf


        {{-- Basic Information --}}
        <div class="border-b border-slate-200 px-6 py-6 sm:px-8">

            <div class="mb-6">

                <h2 class="text-lg font-bold text-slate-900">
                    Role Information
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Enter the basic information for this role.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-6 md:grid-cols-2">

                {{-- Role Name --}}
                <div>

                    <label for="name"
                           class="mb-2 block text-sm font-semibold text-slate-700">

                        Role Name

                        <span class="text-red-500">*</span>

                    </label>

                    <input
                        type="text"
                        id="name"
                        name="name"
                        value="{{ old('name') }}"
                        placeholder="e.g. warehouse_manager"
                        required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >

                    <p class="mt-2 text-xs text-slate-400">
                        Use lowercase letters, numbers, hyphens or underscores.
                    </p>

                    @error('name')

                        <p class="mt-1.5 text-xs font-medium text-red-600">
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
                        placeholder="e.g. Warehouse Manager"
                        required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >

                    <p class="mt-2 text-xs text-slate-400">
                        This name will be displayed throughout the system.
                    </p>

                    @error('display_name')

                        <p class="mt-1.5 text-xs font-medium text-red-600">
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
                        rows="5"
                        placeholder="Describe what this role is responsible for..."
                        class="w-full resize-none rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >{{ old('description') }}</textarea>

                    @error('description')

                        <p class="mt-1.5 text-xs font-medium text-red-600">
                            {{ $message }}
                        </p>

                    @enderror

                </div>

            </div>

        </div>


        {{-- Status --}}
        <div class="border-b border-slate-200 px-6 py-6 sm:px-8">

            <div class="mb-5">

                <h2 class="text-lg font-bold text-slate-900">
                    Role Status
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Control whether this role can currently be assigned to users.
                </p>

            </div>


            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">

                {{-- Active --}}
                <label class="cursor-pointer">

                    <input
                        type="radio"
                        name="is_active"
                        value="1"
                        class="peer sr-only"
                        {{ old('is_active', '1') == '1' ? 'checked' : '' }}
                    >

                    <div class="rounded-xl border border-slate-200 bg-white p-4 transition peer-checked:border-green-500 peer-checked:bg-green-50">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-green-100 text-green-700">

                                ✓

                            </div>

                            <div>

                                <p class="font-semibold text-slate-900">
                                    Active
                                </p>

                                <p class="text-xs text-slate-500">
                                    Role can be assigned to users.
                                </p>

                            </div>

                        </div>

                    </div>

                </label>


                {{-- Inactive --}}
                <label class="cursor-pointer">

                    <input
                        type="radio"
                        name="is_active"
                        value="0"
                        class="peer sr-only"
                        {{ old('is_active') == '0' ? 'checked' : '' }}
                    >

                    <div class="rounded-xl border border-slate-200 bg-white p-4 transition peer-checked:border-amber-500 peer-checked:bg-amber-50">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-lg bg-amber-100 text-amber-700">

                                !

                            </div>

                            <div>

                                <p class="font-semibold text-slate-900">
                                    Inactive
                                </p>

                                <p class="text-xs text-slate-500">
                                    Role should not be assigned.
                                </p>

                            </div>

                        </div>

                    </div>

                </label>

            </div>


            @error('is_active')

                <p class="mt-2 text-xs font-medium text-red-600">
                    {{ $message }}
                </p>

            @enderror

        </div>


        {{-- Information Panel --}}
        <div class="border-b border-slate-200 bg-slate-50 px-6 py-6 sm:px-8">

            <div class="rounded-xl border border-blue-100 bg-blue-50 p-5">

                <div class="flex gap-3">

                    <div class="flex h-9 w-9 shrink-0 items-center justify-center rounded-lg bg-blue-100 font-bold text-blue-700">
                        i
                    </div>

                    <div>

                        <h3 class="font-semibold text-blue-900">
                            About Roles & Permissions
                        </h3>

                        <p class="mt-1 text-sm leading-6 text-blue-800">
                            Creating a role does not automatically give it access
                            to system modules. Permissions will be assigned to
                            the role separately from the Permissions Management
                            section.
                        </p>

                    </div>

                </div>

            </div>

        </div>


        {{-- Actions --}}
        <div class="flex flex-col-reverse gap-3 bg-white px-6 py-5 sm:flex-row sm:items-center sm:justify-end sm:px-8">

            <a href="{{ route('roles.index') }}"
               class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">

                Cancel

            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
            >

                <span class="text-lg leading-none">
                    +
                </span>

                Create Role

            </button>

        </div>

    </form>

</div>

@endsection
