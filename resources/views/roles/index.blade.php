@extends('layouts.app')

@section('title', 'Roles Management')

@section('content')

<div class="space-y-6">


{{-- Page Header --}}
<div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

    <div>
        <h1 class="text-2xl font-bold tracking-tight text-slate-900">
            Roles Management
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Manage system roles and their permissions.
        </p>
    </div>

    <a
        href="{{ route('roles.create') }}"
        class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700"
    >
        <svg
            class="h-5 w-5"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 4v16m8-8H4"
            />
        </svg>

        Create New Role
    </a>

</div>


{{-- Flash Messages --}}
@if(session('success'))
    <div class="flex items-start gap-3 rounded-xl border border-green-200 bg-green-50 p-4 text-green-800">

        <svg
            class="mt-0.5 h-5 w-5 shrink-0"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M5 13l4 4L19 7"
            />
        </svg>

        <div>
            <p class="font-semibold">
                Success
            </p>

            <p class="text-sm">
                {{ session('success') }}
            </p>
        </div>

    </div>
@endif


@if(session('error'))
    <div class="flex items-start gap-3 rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">

        <svg
            class="mt-0.5 h-5 w-5 shrink-0"
            fill="none"
            stroke="currentColor"
            viewBox="0 0 24 24"
        >
            <path
                stroke-linecap="round"
                stroke-linejoin="round"
                stroke-width="2"
                d="M12 8v4m0 4h.01M10.29 3.86l-7.4 12.82A2 2 0 004.63 20h14.74a2 2 0 001.74-3.32l-7.4-12.82a2 2 0 00-3.42 0z"
            />
        </svg>

        <div>
            <p class="font-semibold">
                Error
            </p>

            <p class="text-sm">
                {{ session('error') }}
            </p>
        </div>

    </div>
@endif


{{-- Statistics --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-4">

    {{-- Total Roles --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Total Roles
                </p>

                <p class="mt-1 text-2xl font-bold text-slate-900">
                    {{ $roles->total() }}
                </p>
            </div>

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-green-700">

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m9-10a4 4 0 100-8 4 4 0 000 8zm7 8v-2a4 4 0 00-3-3.87M16 3.13a4 4 0 010 7.75"
                    />
                </svg>

            </div>

        </div>

    </div>


    {{-- Active Roles --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Active Roles
                </p>

                <p class="mt-1 text-2xl font-bold text-green-600">
                    {{ $roles->getCollection()->where('is_active', true)->count() }}
                </p>
            </div>

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-100 text-green-700">

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M5 13l4 4L19 7"
                    />
                </svg>

            </div>

        </div>

    </div>


    {{-- Inactive Roles --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Inactive Roles
                </p>

                <p class="mt-1 text-2xl font-bold text-red-600">
                    {{ $roles->getCollection()->where('is_active', false)->count() }}
                </p>
            </div>

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-red-100 text-red-600">

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M12 8v4m0 4h.01"
                    />
                </svg>

            </div>

        </div>

    </div>


    {{-- Assigned Users --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <div class="flex items-center justify-between">

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Assigned Users
                </p>

                <p class="mt-1 text-2xl font-bold text-slate-900">
                    {{ $roles->sum('users_count') }}
                </p>
            </div>

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-blue-100 text-blue-700">

                <svg
                    class="h-5 w-5"
                    fill="none"
                    stroke="currentColor"
                    viewBox="0 0 24 24"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        stroke-width="2"
                        d="M17 20h5V4H2v16h5m10 0v-5H7v5m10 0H7"
                    />
                </svg>

            </div>

        </div>

    </div>

</div>


{{-- Roles Table --}}
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    {{-- Table Header --}}
    <div class="border-b border-slate-200 px-5 py-4">

        <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <h2 class="font-semibold text-slate-900">
                    System Roles
                </h2>

                <p class="text-sm text-slate-500">
                    Manage roles, users and permissions.
                </p>
            </div>

            <span class="w-fit rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                {{ $roles->total() }} Roles
            </span>

        </div>

    </div>


    {{-- Desktop Table --}}
    <div class="hidden overflow-x-auto lg:block">

        <table class="min-w-full">

            <thead class="bg-slate-50">

                <tr class="border-b border-slate-200">

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Role
                    </th>

                    <th class="px-5 py-3 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Description
                    </th>

                    <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Users
                    </th>

                    <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Permissions
                    </th>

                    <th class="px-5 py-3 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Status
                    </th>

                    <th class="px-5 py-3 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                        Actions
                    </th>

                </tr>

            </thead>


            <tbody class="divide-y divide-slate-100">

                @forelse($roles as $role)

                    <tr class="transition hover:bg-slate-50">

                        {{-- Role --}}
                        <td class="px-5 py-4">

                            <div class="flex items-center gap-3">

                                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-700">

                                    <svg
                                        class="h-5 w-5"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M12 15l8-4.5V5.5L12 1 4 5.5v5L12 15zm0 0v8m-4-6.5L4 19m16 0l-4-2.5"
                                        />
                                    </svg>

                                </div>

                                <div class="min-w-0">

                                    <p class="font-semibold text-slate-900">
                                        {{ $role->display_name }}
                                    </p>

                                    <p class="mt-0.5 font-mono text-xs text-slate-400">
                                        {{ $role->name }}
                                    </p>

                                </div>

                            </div>

                        </td>


                        {{-- Description --}}
                        <td class="max-w-xs px-5 py-4">

                            <p class="truncate text-sm text-slate-500">
                                {{ $role->description ?: 'No description provided.' }}
                            </p>

                        </td>


                        {{-- Users --}}
                        <td class="px-5 py-4 text-center">

                            <span class="inline-flex items-center justify-center rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                {{ $role->users_count }}
                            </span>

                        </td>


                        {{-- Permissions --}}
                        <td class="px-5 py-4 text-center">

                            <span class="inline-flex items-center justify-center rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                {{ $role->permissions_count }}
                            </span>

                        </td>


                        {{-- Status --}}
                        <td class="px-5 py-4 text-center">

                            @if($role->is_active)

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">

                                    <span class="h-1.5 w-1.5 rounded-full bg-green-600"></span>

                                    Active

                                </span>

                            @else

                                <span class="inline-flex items-center gap-1.5 rounded-full bg-red-100 px-3 py-1 text-xs font-semibold text-red-700">

                                    <span class="h-1.5 w-1.5 rounded-full bg-red-600"></span>

                                    Inactive

                                </span>

                            @endif

                        </td>


                        {{-- Actions --}}
                        <td class="px-5 py-4">

                            <div class="flex items-center justify-end gap-2">

                                {{-- Permissions --}}
                                <a
                                    href="{{ route('roles.permissions.edit', $role) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-green-200 px-3 py-2 text-xs font-semibold text-green-700 transition hover:bg-green-50"
                                    title="Manage Permissions"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M15 7a2 2 0 11-4 0 2 2 0 014 0zm0 0v2m0 0a2 2 0 11-4 0m4 0h3m-7 0H8m7 0v2a2 2 0 01-2 2h-1m-4-4H6m2 0v4m0 0a2 2 0 11-4 0m4 0h3"
                                        />
                                    </svg>

                                    Permissions
                                </a>


                                {{-- Edit --}}
                                <a
                                    href="{{ route('roles.edit', $role) }}"
                                    class="inline-flex items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-600 transition hover:bg-slate-50"
                                >
                                    <svg
                                        class="h-4 w-4"
                                        fill="none"
                                        stroke="currentColor"
                                        viewBox="0 0 24 24"
                                    >
                                        <path
                                            stroke-linecap="round"
                                            stroke-linejoin="round"
                                            stroke-width="2"
                                            d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 8.5-8.5z"
                                        />
                                    </svg>

                                    Edit
                                </a>


                                {{-- Delete --}}
                                @if($role->users_count === 0)

                                    <form
                                        method="POST"
                                        action="{{ route('roles.destroy', $role) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this role?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50"
                                        >
                                            <svg
                                                class="h-4 w-4"
                                                fill="none"
                                                stroke="currentColor"
                                                viewBox="0 0 24 24"
                                            >
                                                <path
                                                    stroke-linecap="round"
                                                    stroke-linejoin="round"
                                                    stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h10"
                                                />
                                            </svg>

                                            Delete
                                        </button>
                                    </form>

                                @else

                                    <span
                                        class="inline-flex cursor-not-allowed items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-400"
                                        title="This role is assigned to users"
                                    >
                                        Delete
                                    </span>

                                @endif

                            </div>

                        </td>

                    </tr>

                @empty

                    <tr>

                        <td
                            colspan="6"
                            class="px-5 py-12 text-center"
                        >

                            <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-500">

                                <svg
                                    class="h-7 w-7"
                                    fill="none"
                                    stroke="currentColor"
                                    viewBox="0 0 24 24"
                                >
                                    <path
                                        stroke-linecap="round"
                                        stroke-linejoin="round"
                                        stroke-width="2"
                                        d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m9-10a4 4 0 100-8 4 4 0 000 8z"
                                    />
                                </svg>

                            </div>

                            <h3 class="mt-4 text-lg font-bold text-slate-900">
                                No Roles Found
                            </h3>

                            <p class="mt-2 text-sm text-slate-500">
                                Create your first system role to get started.
                            </p>

                            <a
                                href="{{ route('roles.create') }}"
                                class="mt-5 inline-flex items-center gap-2 rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700"
                            >
                                Create New Role
                            </a>

                        </td>

                    </tr>

                @endforelse

            </tbody>

        </table>

    </div>


    {{-- Mobile Cards --}}
    <div class="divide-y divide-slate-100 lg:hidden">

        @forelse($roles as $role)

            <div class="p-5">

                <div class="flex items-start justify-between gap-4">

                    <div class="flex min-w-0 items-center gap-3">

                        <div class="flex h-11 w-11 shrink-0 items-center justify-center rounded-xl bg-green-100 text-green-700">

                            <svg
                                class="h-5 w-5"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M12 15l8-4.5V5.5L12 1 4 5.5v5L12 15zm0 0v8m-4-6.5L4 19m16 0l-4-2.5"
                                />
                            </svg>

                        </div>

                        <div class="min-w-0">

                            <p class="truncate font-semibold text-slate-900">
                                {{ $role->display_name }}
                            </p>

                            <p class="truncate font-mono text-xs text-slate-400">
                                {{ $role->name }}
                            </p>

                        </div>

                    </div>


                    @if($role->is_active)

                        <span class="shrink-0 rounded-full bg-green-100 px-2.5 py-1 text-xs font-semibold text-green-700">
                            Active
                        </span>

                    @else

                        <span class="shrink-0 rounded-full bg-red-100 px-2.5 py-1 text-xs font-semibold text-red-700">
                            Inactive
                        </span>

                    @endif

                </div>


                <p class="mt-4 text-sm leading-6 text-slate-500">
                    {{ $role->description ?: 'No description provided.' }}
                </p>


                <div class="mt-4 grid grid-cols-2 gap-3">

                    <div class="rounded-xl bg-blue-50 p-3">

                        <p class="text-xs font-medium text-blue-600">
                            Users
                        </p>

                        <p class="mt-1 text-lg font-bold text-blue-800">
                            {{ $role->users_count }}
                        </p>

                    </div>


                    <div class="rounded-xl bg-green-50 p-3">

                        <p class="text-xs font-medium text-green-600">
                            Permissions
                        </p>

                        <p class="mt-1 text-lg font-bold text-green-800">
                            {{ $role->permissions_count }}
                        </p>

                    </div>

                </div>


                {{-- Mobile Actions --}}
                <div class="mt-4 grid grid-cols-2 gap-2">

                    <a
                        href="{{ route('roles.permissions.edit', $role) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-green-200 px-3 py-2.5 text-xs font-semibold text-green-700 transition hover:bg-green-50"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M15 7a2 2 0 11-4 0 2 2 0 014 0zm0 0v2m0 0a2 2 0 11-4 0m4 0h3m-7 0H8m7 0v2a2 2 0 01-2 2h-1m-4-4H6m2 0v4m0 0a2 2 0 11-4 0m4 0h3"
                            />
                        </svg>

                        Permissions
                    </a>


                    <a
                        href="{{ route('roles.edit', $role) }}"
                        class="inline-flex items-center justify-center gap-2 rounded-lg border border-slate-200 px-3 py-2.5 text-xs font-semibold text-slate-600 transition hover:bg-slate-50"
                    >
                        <svg
                            class="h-4 w-4"
                            fill="none"
                            stroke="currentColor"
                            viewBox="0 0 24 24"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.5-9.5a2.121 2.121 0 113 3L12 15l-4 1 1-4 8.5-8.5z"
                            />
                        </svg>

                        Edit
                    </a>

                </div>


                @if($role->users_count === 0)

                    <form
                        method="POST"
                        action="{{ route('roles.destroy', $role) }}"
                        class="mt-2"
                        onsubmit="return confirm('Are you sure you want to delete this role?');"
                    >
                        @csrf
                        @method('DELETE')

                        <button
                            type="submit"
                            class="inline-flex w-full items-center justify-center gap-2 rounded-lg border border-red-200 px-3 py-2.5 text-xs font-semibold text-red-600 transition hover:bg-red-50"
                        >
                            <svg
                                class="h-4 w-4"
                                fill="none"
                                stroke="currentColor"
                                viewBox="0 0 24 24"
                            >
                                <path
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                    stroke-width="2"
                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-7 0h10"
                                />
                            </svg>

                            Delete Role
                        </button>
                    </form>

                @endif

            </div>

        @empty

            <div class="p-10 text-center">

                <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100 text-slate-500">

                    <svg
                        class="h-7 w-7"
                        fill="none"
                        stroke="currentColor"
                        viewBox="0 0 24 24"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            stroke-width="2"
                            d="M16 21v-2a4 4 0 00-4-4H6a4 4 0 00-4 4v2m9-10a4 4 0 100-8 4 4 0 000 8z"
                        />
                    </svg>

                </div>

                <h3 class="mt-4 text-lg font-bold text-slate-900">
                    No Roles Found
                </h3>

                <p class="mt-2 text-sm text-slate-500">
                    Create your first system role to get started.
                </p>

            </div>

        @endforelse

    </div>


    {{-- Pagination --}}
    @if($roles->hasPages())

        <div class="border-t border-slate-200 px-5 py-4">
            {{ $roles->links() }}
        </div>

    @endif

</div>

</div>

@endsection
