@extends('layouts.app')

@section('title', 'Edit Permission')

@section('content')

<div class="mx-auto max-w-5xl space-y-6">

    {{-- Page Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div class="flex items-center gap-3">

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-green-600">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.045-.133-2.059-.382-3.016z"/>
                </svg>
            </div>

            <div>
                <h1 class="text-2xl font-bold text-slate-900">
                    Edit Permission
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Update permission details and system access information.
                </p>
            </div>

        </div>

        <a href="{{ route('permissions.index') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-300 bg-white px-5 py-3 text-sm font-semibold text-slate-700 shadow-sm transition hover:bg-slate-50">

            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
                          d="M12 8v4m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.5 20h15a2 2 0 001.71-3.14l-7.5-13a2 2 0 01-3.42 0z"/>
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

            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-lg font-bold text-slate-900">
                        Permission Information
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Modify the permission information below.
                    </p>
                </div>

                <span class="inline-flex w-fit rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                    ID #{{ $permission->id }}
                </span>

            </div>

        </div>


        <form method="POST"
              action="{{ route('permissions.update', $permission) }}"
              class="p-6">

            @csrf
            @method('PUT')

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
                        value="{{ old('name', $permission->name) }}"
                        placeholder="e.g. create-sale"
                        required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >

                    <p class="mt-2 text-xs leading-5 text-slate-500">
                        System identifier used by the application.
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
                        value="{{ old('display_name', $permission->display_name) }}"
                        placeholder="e.g. Create Sale"
                        required
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-2 focus:ring-green-100"
                    >

                    <p class="mt-2 text-xs leading-5 text-slate-500">
                        Friendly name displayed in the permission management interface.
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

                        @php
                            $modules = [
                                'Dashboard',
                                'Products',
                                'Categories',
                                'Brands',
                                'Inventory',
                                'Sales',
                                'Customers',
                                'Expenses',
                                'Reports',
                                'Users',
                                'Roles',
                                'Settings',
                                'Audit Logs',
                            ];
                        @endphp

                        @foreach($modules as $module)

                            <option value="{{ $module }}"
                                @selected(old('module', $permission->module) === $module)>
                                {{ $module }}
                            </option>

                        @endforeach

                    </select>

                    <p class="mt-2 text-xs leading-5 text-slate-500">
                        Select the module where this permission belongs.
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
                        placeholder="Describe what this permission allows..."
                        class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 focus:border-green-500 focus:ring-2 focus:ring-green-100">{{ old('description', $permission->description) }}</textarea>

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


            {{-- Assignment Information --}}
            @php
                $rolesCount = $permission->roles()->count();
            @endphp

            <div class="mt-8 rounded-2xl border border-slate-200 bg-slate-50 p-5">

                <div class="flex items-start gap-4">

                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-white text-slate-600 shadow-sm">

                        <svg class="h-5 w-5"
                             fill="none"
                             stroke="currentColor"
                             viewBox="0 0 24 24">

                            <path stroke-linecap="round"
                                  stroke-linejoin="round"
                                  stroke-width="2"
                                  d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/>

                        </svg>

                    </div>

                    <div class="flex-1">

                        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                            <div>
                                <h3 class="font-semibold text-slate-900">
                                    Role Assignment
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    This permission is currently assigned to
                                    <span class="font-semibold text-slate-900">
                                        {{ $rolesCount }}
                                    </span>
                                    {{ Str::plural('role', $rolesCount) }}.
                                </p>
                            </div>

                            @if($rolesCount > 0)

                                <span class="inline-flex w-fit rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                    Assigned
                                </span>

                            @else

                                <span class="inline-flex w-fit rounded-full bg-amber-100 px-3 py-1 text-xs font-semibold text-amber-700">
                                    Not Assigned
                                </span>

                            @endif

                        </div>

                        <p class="mt-3 text-xs leading-5 text-slate-500">
                            Role assignments are managed from the Role Permissions page.
                            Updating this permission does not automatically change role assignments.
                        </p>

                    </div>

                </div>

            </div>


            {{-- Actions --}}
            <div class="mt-8 flex flex-col-reverse gap-3 border-t border-slate-200 pt-6 sm:flex-row sm:justify-between">

                <div>

                    @if($rolesCount === 0)

                        <button
                            type="button"
                            onclick="document.getElementById('delete-permission-form').submit();"
                            class="inline-flex items-center justify-center gap-2 rounded-xl border border-red-200 bg-white px-5 py-3 text-sm font-semibold text-red-600 transition hover:bg-red-50">

                            <svg class="h-5 w-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h12"/>

                            </svg>

                            Delete Permission
                        </button>

                    @else

                        <span
                            class="inline-flex cursor-not-allowed items-center justify-center gap-2 rounded-xl border border-slate-200 bg-slate-50 px-5 py-3 text-sm font-semibold text-slate-400"
                            title="This permission is assigned to one or more roles.">

                            <svg class="h-5 w-5"
                                 fill="none"
                                 stroke="currentColor"
                                 viewBox="0 0 24 24">

                                <path stroke-linecap="round"
                                      stroke-linejoin="round"
                                      stroke-width="2"
                                      d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636"/>

                            </svg>

                            Assigned to Role
                        </span>

                    @endif

                </div>


                <div class="flex flex-col gap-3 sm:flex-row">

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
                                  d="M5 13l4 4L19 7"/>

                        </svg>

                        Save Changes

                    </button>

                </div>

            </div>

        </form>

    </div>


    {{-- Delete Form --}}
    @if($rolesCount === 0)

        <form
            id="delete-permission-form"
            method="POST"
            action="{{ route('permissions.destroy', $permission) }}"
            onsubmit="return confirm('Are you sure you want to permanently delete this permission?');">

            @csrf
            @method('DELETE')

        </form>

    @endif


    {{-- Information Panel --}}
    <div class="rounded-2xl border border-blue-200 bg-blue-50 p-5">

        <div class="flex items-start gap-4">

            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-xl bg-blue-100 text-blue-700">

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
                    Permission Management
                </h3>

                <p class="mt-1 text-sm leading-6 text-blue-800">
                    Permissions define individual actions available in the system.
                    They are assigned to roles, and users inherit permissions from
                    the roles assigned to their accounts.
                </p>

            </div>

        </div>

    </div>

</div>

@endsection
