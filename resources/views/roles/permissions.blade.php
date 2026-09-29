@extends('layouts.app')

@section('title', 'Role Permissions')

@section('content')

<div
    x-data="permissionManager()"
    class="space-y-6"
>
    {{-- Header --}}
    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

```
    <div>
        <div class="flex items-center gap-3">
            <a
                href="{{ route('roles.index') }}"
                class="inline-flex h-10 w-10 items-center justify-center rounded-xl border border-slate-200 bg-white text-slate-600 shadow-sm transition hover:border-green-200 hover:bg-green-50 hover:text-green-700"
                title="Back to Roles"
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
                        d="M15 19l-7-7 7-7"
                    />
                </svg>
            </a>

            <div>
                <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                    Role Permissions
                </h1>

                <p class="mt-1 text-sm text-slate-500">
                    Manage system permissions assigned to this role.
                </p>
            </div>
        </div>
    </div>

    {{-- Role Badge --}}
    <div class="flex items-center gap-3 rounded-2xl border border-green-100 bg-green-50 px-4 py-3">
        <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-green-600 text-white shadow-sm">
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

        <div>
            <p class="text-xs font-medium uppercase tracking-wider text-green-700">
                Current Role
            </p>

            <p class="text-sm font-bold text-slate-900">
                {{ $role->display_name }}
            </p>

            <p class="text-xs text-slate-500">
                {{ $role->name }}
            </p>
        </div>
    </div>
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

@if($errors->any())
    <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-red-800">
        <div class="flex items-start gap-3">
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
                    Please check the following errors:
                </p>

                <ul class="mt-2 list-disc space-y-1 pl-5 text-sm">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
@endif

{{-- Summary --}}
<div class="grid grid-cols-1 gap-4 sm:grid-cols-3">

    {{-- Selected --}}
    <div class="rounded-2xl border border-green-100 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Selected Permissions
                </p>

                <p
                    class="mt-1 text-2xl font-bold text-slate-900"
                    x-text="selectedCount"
                >
                    0
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

    {{-- Total --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Total Permissions
                </p>

                <p class="mt-1 text-2xl font-bold text-slate-900">
                    {{ $permissions->flatten()->count() }}
                </p>
            </div>

            <div class="flex h-11 w-11 items-center justify-center rounded-xl bg-slate-100 text-slate-600">
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
                        d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"
                    />
                </svg>
            </div>
        </div>
    </div>

    {{-- Modules --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
        <div class="flex items-center justify-between">
            <div>
                <p class="text-sm font-medium text-slate-500">
                    Permission Modules
                </p>

                <p class="mt-1 text-2xl font-bold text-slate-900">
                    {{ $permissions->count() }}
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
                        d="M4 6h16M4 12h16M4 18h16"
                    />
                </svg>
            </div>
        </div>
    </div>
</div>

{{-- Control Bar --}}
<div class="sticky top-2 z-20 rounded-2xl border border-slate-200 bg-white/95 p-4 shadow-sm backdrop-blur">

    <div class="flex flex-col gap-4 lg:flex-row lg:items-center lg:justify-between">

        <div>
            <h2 class="font-semibold text-slate-900">
                Permission Matrix
            </h2>

            <p class="text-sm text-slate-500">
                Select the permissions this role should have.
            </p>
        </div>

        <div class="flex flex-wrap items-center gap-2">

            <button
                type="button"
                @click="selectAll()"
                class="inline-flex items-center gap-2 rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-sm font-semibold text-green-700 transition hover:bg-green-100"
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
                        d="M5 13l4 4L19 7"
                    />
                </svg>

                Select All
            </button>

            <button
                type="button"
                @click="clearAll()"
                class="inline-flex items-center gap-2 rounded-lg border border-slate-200 bg-white px-3 py-2 text-sm font-semibold text-slate-600 transition hover:bg-slate-50"
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
                        d="M6 18L18 6M6 6l12 12"
                    />
                </svg>

                Clear All
            </button>

        </div>
    </div>
</div>

{{-- Permission Form --}}
<form
    method="POST"
    action="{{ route('roles.permissions.update', $role) }}"
>
    @csrf
    @method('PUT')

    <div class="space-y-5">

        @forelse($permissions as $module => $modulePermissions)

            @php
                $moduleKey = \Illuminate\Support\Str::slug($module);
            @endphp

            <div
                class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm"
                x-data="{
                    modulePermissions: [
                        @foreach($modulePermissions as $permission)
                            '{{ $permission->id }}',
                        @endforeach
                    ],

                    get selectedModuleCount() {
                        return this.modulePermissions.filter(id =>
                            selectedPermissions.includes(String(id))
                        ).length;
                    },

                    get moduleSelected() {
                        return this.selectedModuleCount === this.modulePermissions.length
                            && this.modulePermissions.length > 0;
                    },

                    toggleModule() {
                        if (this.moduleSelected) {
                            this.modulePermissions.forEach(id => {
                                removePermission(String(id));
                            });
                        } else {
                            this.modulePermissions.forEach(id => {
                                addPermission(String(id));
                            });
                        }
                    },

                    addPermission(id) {
                        if (!selectedPermissions.includes(String(id))) {
                            selectedPermissions.push(String(id));
                        }

                        const checkbox = document.getElementById('permission-' + id);

                        if (checkbox) {
                            checkbox.checked = true;
                        }
                    },

                    removePermission(id) {
                        selectedPermissions = selectedPermissions.filter(
                            permissionId => permissionId !== String(id)
                        );

                        const checkbox = document.getElementById('permission-' + id);

                        if (checkbox) {
                            checkbox.checked = false;
                        }
                    }
                }"
            >

                {{-- Module Header --}}
                <div class="border-b border-slate-200 bg-slate-50 px-5 py-4">

                    <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                        <div class="flex items-center gap-3">

                            <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-100 text-green-700">
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
                                        d="M4 6h16M4 12h16M4 18h16"
                                    />
                                </svg>
                            </div>

                            <div>
                                <h3 class="font-bold text-slate-900">
                                    {{ $module }}
                                </h3>

                                <p class="text-xs text-slate-500">
                                    <span x-text="selectedModuleCount"></span>
                                    of
                                    {{ $modulePermissions->count() }}
                                    selected
                                </p>
                            </div>
                        </div>

                        <label class="inline-flex cursor-pointer items-center gap-2 text-sm font-semibold text-slate-600">

                            <input
                                type="checkbox"
                                @change="toggleModule()"
                                :checked="moduleSelected"
                                class="h-4 w-4 rounded border-slate-300 text-green-600 focus:ring-green-500"
                            >

                            Select All
                        </label>

                    </div>
                </div>

                {{-- Permissions --}}
                <div class="divide-y divide-slate-100">

                    @foreach($modulePermissions as $permission)

                        <label
                            for="permission-{{ $permission->id }}"
                            class="group flex cursor-pointer items-start gap-4 px-5 py-4 transition hover:bg-green-50/40"
                        >

                            <div class="pt-0.5">
                                <input
                                    id="permission-{{ $permission->id }}"
                                    type="checkbox"
                                    name="permissions[]"
                                    value="{{ $permission->id }}"
                                    @checked(in_array($permission->id, $assignedPermissionIds))
                                    @change="togglePermission('{{ $permission->id }}')"
                                    class="permission-checkbox h-5 w-5 rounded border-slate-300 text-green-600 shadow-sm focus:ring-2 focus:ring-green-500"
                                >
                            </div>

                            <div class="min-w-0 flex-1">

                                <div class="flex flex-col gap-1 sm:flex-row sm:items-center sm:justify-between">

                                    <div>
                                        <p class="font-semibold text-slate-900 group-hover:text-green-700">
                                            {{ $permission->display_name }}
                                        </p>

                                        <p class="mt-0.5 font-mono text-xs text-slate-400">
                                            {{ $permission->name }}
                                        </p>
                                    </div>

                                    <span class="w-fit rounded-full bg-slate-100 px-2.5 py-1 text-xs font-medium text-slate-500">
                                        {{ $module }}
                                    </span>

                                </div>

                                @if($permission->description)
                                    <p class="mt-2 text-sm leading-6 text-slate-500">
                                        {{ $permission->description }}
                                    </p>
                                @endif

                            </div>

                        </label>

                    @endforeach

                </div>
            </div>

        @empty

            <div class="rounded-2xl border border-dashed border-slate-300 bg-white p-10 text-center">

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
                            d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h6l5 5v11a2 2 0 01-2 2z"
                        />
                    </svg>
                </div>

                <h3 class="mt-4 text-lg font-bold text-slate-900">
                    No Permissions Found
                </h3>

                <p class="mx-auto mt-2 max-w-md text-sm text-slate-500">
                    There are currently no permissions available in the system.
                    Create permissions first before assigning them to this role.
                </p>

                <a
                    href="{{ route('permissions.create') }}"
                    class="mt-5 inline-flex items-center gap-2 rounded-xl bg-green-600 px-4 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700"
                >
                    Create Permission
                </a>

            </div>

        @endforelse

    </div>

    {{-- Bottom Actions --}}
    @if($permissions->count())

        <div class="mt-6 rounded-2xl border border-slate-200 bg-white p-4 shadow-sm">

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <p class="font-semibold text-slate-900">
                        Ready to save?
                    </p>

                    <p class="text-sm text-slate-500">
                        <span
                            class="font-semibold text-green-700"
                            x-text="selectedCount"
                        >
                            0
                        </span>
                        permissions will be assigned to
                        <span class="font-semibold text-slate-700">
                            {{ $role->display_name }}
                        </span>.
                    </p>
                </div>

                <div class="flex flex-col gap-2 sm:flex-row">

                    <a
                        href="{{ route('roles.index') }}"
                        class="inline-flex items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
                    >
                        Cancel
                    </a>

                    <button
                        type="submit"
                        class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2"
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
                                d="M5 13l4 4L19 7"
                            />
                        </svg>

                        Save Permissions
                    </button>

                </div>

            </div>
        </div>

    @endif

</form>
```

</div>

{{-- Alpine Permission Manager --}}

<script>
    function permissionManager() {
        return {
            selectedPermissions: [
                @foreach($assignedPermissionIds as $permissionId)
                    '{{ $permissionId }}',
                @endforeach
            ],

            get selectedCount() {
                return this.selectedPermissions.length;
            },

            togglePermission(id) {
                id = String(id);

                if (this.selectedPermissions.includes(id)) {
                    this.selectedPermissions =
                        this.selectedPermissions.filter(
                            permissionId => permissionId !== id
                        );
                } else {
                    this.selectedPermissions.push(id);
                }
            },

            selectAll() {
                const checkboxes = document.querySelectorAll(
                    '.permission-checkbox'
                );

                this.selectedPermissions = [];

                checkboxes.forEach((checkbox) => {
                    checkbox.checked = true;

                    const id = String(checkbox.value);

                    if (!this.selectedPermissions.includes(id)) {
                        this.selectedPermissions.push(id);
                    }
                });
            },

            clearAll() {
                const checkboxes = document.querySelectorAll(
                    '.permission-checkbox'
                );

                checkboxes.forEach((checkbox) => {
                    checkbox.checked = false;
                });

                this.selectedPermissions = [];
            }
        }
    }
</script>

@endsection
