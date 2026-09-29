```blade
@extends('layouts.app')

@section('title', 'Permissions Management')

@section('content')

<div class="space-y-6">

    {{-- =========================================================
        PAGE HEADER
    ========================================================== --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <div class="flex items-center gap-2">
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
                        Permissions Management
                    </h1>

                    <p class="mt-1 text-sm text-slate-500">
                        Manage system permissions and control access to different modules.
                    </p>
                </div>
            </div>
        </div>

        <a href="{{ route('permissions.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700">

            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>

            Create Permission
        </a>

    </div>


    {{-- =========================================================
        FLASH MESSAGES
    ========================================================== --}}

    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-4 text-sm text-green-800">
            <div class="flex items-start gap-3">

                <svg class="mt-0.5 h-5 w-5 flex-shrink-0 text-green-600"
                     fill="none"
                     stroke="currentColor"
                     viewBox="0 0 24 24">

                    <path stroke-linecap="round"
                          stroke-linejoin="round"
                          stroke-width="2"
                          d="M5 13l4 4L19 7"/>
                </svg>

                <span>{{ session('success') }}</span>
            </div>
        </div>
    @endif


    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-4 text-sm text-red-800">
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

                <span>{{ session('error') }}</span>
            </div>
        </div>
    @endif


    {{-- =========================================================
        STATISTICS
    ========================================================== --}}

    @php
        $totalPermissions = $permissions->total();

        $assignedPermissions = \App\Models\Permission::has('roles')->count();

        $unusedPermissions = \App\Models\Permission::doesntHave('roles')->count();

        $moduleCount = \App\Models\Permission::query()
            ->select('module')
            ->distinct()
            ->count('module');
    @endphp


    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">

        {{-- Total --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Total Permissions
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ $totalPermissions }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-green-100 text-green-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.045-.133-2.059-.382-3.016z"/>
                    </svg>
                </div>

            </div>
        </div>


        {{-- Modules --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Modules
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ $moduleCount }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-blue-100 text-blue-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </div>

            </div>
        </div>


        {{-- Assigned --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Assigned
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ $assignedPermissions }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-emerald-100 text-emerald-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M5 13l4 4L19 7"/>
                    </svg>
                </div>

            </div>
        </div>


        {{-- Unused --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">

                <div>
                    <p class="text-sm font-medium text-slate-500">
                        Unused
                    </p>

                    <p class="mt-2 text-3xl font-bold text-slate-900">
                        {{ $unusedPermissions }}
                    </p>
                </div>

                <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-amber-100 text-amber-600">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="M12 9v2m0 4h.01M10.29 3.86l-7.5 13A2 2 0 004.5 20h15a2 2 0 001.71-3.14l-7.5-13a2 2 0 00-3.42 0z"/>
                    </svg>
                </div>

            </div>
        </div>

    </div>


    {{-- =========================================================
        SEARCH
    ========================================================== --}}

    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <form method="GET"
              action="{{ route('permissions.index') }}"
              class="flex flex-col gap-3 md:flex-row">

            <div class="relative flex-1">

                <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4">
                    <svg class="h-5 w-5 text-slate-400"
                         fill="none"
                         stroke="currentColor"
                         viewBox="0 0 24 24">

                        <path stroke-linecap="round"
                              stroke-linejoin="round"
                              stroke-width="2"
                              d="m21 21-4.35-4.35m0 0A7.5 7.5 0 1010.5 3a7.5 7.5 0 006.15 13.65z"/>
                    </svg>
                </div>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search permissions..."
                    class="w-full rounded-xl border border-slate-300 bg-white py-3 pl-11 pr-4 text-sm text-slate-900 outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100"
                >

            </div>

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-xl bg-slate-900 px-6 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">

                Search
            </button>

            @if(request('search'))

                <a href="{{ route('permissions.index') }}"
                   class="inline-flex items-center justify-center rounded-xl border border-slate-300 px-6 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">

                    Clear
                </a>

            @endif

        </form>

    </div>


    {{-- =========================================================
        PERMISSIONS TABLE
    ========================================================== --}}

    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        {{-- Header --}}
        <div class="border-b border-slate-200 px-6 py-5">

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="text-lg font-bold text-slate-900">
                        System Permissions
                    </h2>

                    <p class="mt-1 text-sm text-slate-500">
                        Permissions available throughout the KUNAMBI Hardware Management System.
                    </p>
                </div>

                <div class="text-sm text-slate-500">
                    Showing
                    <span class="font-semibold text-slate-900">
                        {{ $permissions->firstItem() ?? 0 }}
                    </span>
                    -
                    <span class="font-semibold text-slate-900">
                        {{ $permissions->lastItem() ?? 0 }}
                    </span>
                    of
                    <span class="font-semibold text-slate-900">
                        {{ $permissions->total() }}
                    </span>
                </div>

            </div>

        </div>


        {{-- Desktop Table --}}
        <div class="hidden overflow-x-auto lg:block">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Permission
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Module
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            System Name
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Roles
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100 bg-white">

                    @forelse($permissions as $permission)

                        <tr class="transition hover:bg-slate-50">

                            {{-- Permission --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-green-50 text-green-600">

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
                                        <p class="font-semibold text-slate-900">
                                            {{ $permission->display_name }}
                                        </p>

                                        @if($permission->description)

                                            <p class="mt-1 max-w-md text-xs text-slate-500">
                                                {{ $permission->description }}
                                            </p>

                                        @endif
                                    </div>

                                </div>

                            </td>


                            {{-- Module --}}
                            <td class="px-6 py-4">

                                <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                    {{ $permission->module }}
                                </span>

                            </td>


                            {{-- System Name --}}
                            <td class="px-6 py-4">

                                <code class="rounded-lg bg-slate-100 px-3 py-1.5 text-xs font-medium text-slate-700">
                                    {{ $permission->name }}
                                </code>

                            </td>


                            {{-- Roles --}}
                            <td class="px-6 py-4 text-center">

                                @if($permission->roles_count > 0)

                                    <span class="inline-flex min-w-9 items-center justify-center rounded-full bg-green-100 px-3 py-1 text-xs font-bold text-green-700">
                                        {{ $permission->roles_count }}
                                    </span>

                                @else

                                    <span class="inline-flex min-w-9 items-center justify-center rounded-full bg-slate-100 px-3 py-1 text-xs font-bold text-slate-500">
                                        0
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('permissions.edit', $permission) }}"
                                        class="inline-flex items-center gap-1.5 rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:border-green-300 hover:bg-green-50 hover:text-green-700">

                                        <svg class="h-4 w-4"
                                             fill="none"
                                             stroke="currentColor"
                                             viewBox="0 0 24 24">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M11 5h2m-1-1v2m0 12a8 8 0 100-16 8 8 0 000 16zm3-9l-6 6-2 1 1-2 6-6 1 1z"/>

                                        </svg>

                                        Edit
                                    </a>


                                    @if($permission->roles_count === 0)

                                        <form
                                            method="POST"
                                            action="{{ route('permissions.destroy', $permission) }}"
                                            onsubmit="return confirm('Are you sure you want to delete this permission?');">

                                            @csrf
                                            @method('DELETE')

                                            <button
                                                type="submit"
                                                class="inline-flex items-center gap-1.5 rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 transition hover:bg-red-50">

                                                <svg class="h-4 w-4"
                                                     fill="none"
                                                     stroke="currentColor"
                                                     viewBox="0 0 24 24">

                                                    <path stroke-linecap="round"
                                                          stroke-linejoin="round"
                                                          stroke-width="2"
                                                          d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6M9 7V4a1 1 0 011-1h4a1 1 0 011 1v3m-9 0h12"/>

                                                </svg>

                                                Delete
                                            </button>

                                        </form>

                                    @else

                                        <span
                                            title="This permission is assigned to a role and cannot be deleted."
                                            class="inline-flex cursor-not-allowed items-center gap-1.5 rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-400">

                                            <svg class="h-4 w-4"
                                                 fill="none"
                                                 stroke="currentColor"
                                                 viewBox="0 0 24 24">

                                                <path stroke-linecap="round"
                                                      stroke-linejoin="round"
                                                      stroke-width="2"
                                                      d="M18.364 18.364A9 9 0 005.636 5.636m12.728 12.728A9 9 0 015.636 5.636"/>

                                            </svg>

                                            Assigned
                                        </span>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-16 text-center">

                                <div class="mx-auto flex h-16 w-16 items-center justify-center rounded-2xl bg-slate-100 text-slate-400">

                                    <svg class="h-8 w-8"
                                         fill="none"
                                         stroke="currentColor"
                                         viewBox="0 0 24 24">

                                        <path stroke-linecap="round"
                                              stroke-linejoin="round"
                                              stroke-width="2"
                                              d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622C17.176 19.29 21 14.591 21 9c0-1.045-.133-2.059-.382-3.016z"/>

                                    </svg>

                                </div>

                                <h3 class="mt-4 text-lg font-semibold text-slate-900">
                                    No permissions found
                                </h3>

                                <p class="mt-1 text-sm text-slate-500">
                                    Create your first permission to start managing system access.
                                </p>

                                <a
                                    href="{{ route('permissions.create') }}"
                                    class="mt-5 inline-flex items-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white hover:bg-green-700">

                                    Create Permission
                                </a>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Mobile Cards --}}
        <div class="divide-y divide-slate-100 lg:hidden">

            @forelse($permissions as $permission)

                <div class="p-5">

                    <div class="flex items-start justify-between gap-4">

                        <div class="flex min-w-0 items-start gap-3">

                            <div class="flex h-10 w-10 flex-shrink-0 items-center justify-center rounded-lg bg-green-50 text-green-600">

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

                            <div class="min-w-0">

                                <h3 class="truncate font-semibold text-slate-900">
                                    {{ $permission->display_name }}
                                </h3>

                                <code class="mt-1 block truncate text-xs text-slate-500">
                                    {{ $permission->name }}
                                </code>

                            </div>

                        </div>

                        <span class="flex-shrink-0 rounded-full bg-blue-50 px-2.5 py-1 text-xs font-semibold text-blue-700">
                            {{ $permission->module }}
                        </span>

                    </div>


                    @if($permission->description)

                        <p class="mt-3 text-sm text-slate-500">
                            {{ $permission->description }}
                        </p>

                    @endif


                    <div class="mt-4 flex items-center justify-between">

                        <div class="text-sm text-slate-500">

                            Roles:

                            <span class="font-semibold text-slate-900">
                                {{ $permission->roles_count }}
                            </span>

                        </div>


                        <div class="flex gap-2">

                            <a
                                href="{{ route('permissions.edit', $permission) }}"
                                class="rounded-lg border border-slate-300 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50">

                                Edit
                            </a>


                            @if($permission->roles_count === 0)

                                <form
                                    method="POST"
                                    action="{{ route('permissions.destroy', $permission) }}"
                                    onsubmit="return confirm('Are you sure you want to delete this permission?');">

                                    @csrf
                                    @method('DELETE')

                                    <button
                                        type="submit"
                                        class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50">

                                        Delete
                                    </button>

                                </form>

                            @endif

                        </div>

                    </div>

                </div>

            @empty

                <div class="px-6 py-16 text-center">

                    <h3 class="text-lg font-semibold text-slate-900">
                        No permissions found
                    </h3>

                    <p class="mt-1 text-sm text-slate-500">
                        Create your first permission.
                    </p>

                </div>

            @endforelse

        </div>


        {{-- Pagination --}}
        @if($permissions->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $permissions->links() }}
            </div>

        @endif

    </div>


    {{-- =========================================================
        INFORMATION PANEL
    ========================================================== --}}

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
                          d="M13 16h-1v-4h-1m1-4h.01M12 22a10 10 0 100-20 10 10 0 000 20z"/>

                </svg>

            </div>

            <div>

                <h3 class="font-semibold text-green-900">
                    How Permissions Work
                </h3>

                <p class="mt-1 text-sm leading-6 text-green-800">
                    Permissions define what users are allowed to do inside the system.
                    Permissions are assigned to roles, and users receive access through
                    the roles assigned to their accounts.
                </p>

                <p class="mt-2 text-sm font-medium text-green-900">
                    Example:
                    <span class="font-normal">
                        <code>create-sale</code> allows a role to create sales,
                        while <code>view-sales</code> allows the role to view sales.
                    </span>
                </p>

            </div>

        </div>

    </div>

</div>

@endsection
```
