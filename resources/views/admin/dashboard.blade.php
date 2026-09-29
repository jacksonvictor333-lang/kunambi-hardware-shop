@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div>
        <h1 class="text-2xl font-bold text-slate-900">
            Administrator Dashboard
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Welcome back, {{ auth()->user()->name }}.
        </p>
    </div>

    {{-- Welcome Card --}}
    <div class="rounded-2xl bg-white border border-slate-200 p-6 shadow-sm">
        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <div>
                <p class="text-sm font-medium text-slate-500">
                    Signed in as
                </p>

                <h2 class="mt-1 text-xl font-bold text-slate-900">
                    {{ auth()->user()->name }}
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    {{ auth()->user()->email }}
                </p>
            </div>

            <div>
                <span class="inline-flex items-center rounded-full bg-green-50 px-3 py-1.5 text-sm font-semibold text-green-700">
                    <span class="mr-2 h-2 w-2 rounded-full bg-green-500"></span>
                    Administrator
                </span>
            </div>

        </div>
    </div>

    {{-- Statistics --}}
    <div class="grid grid-cols-1 gap-5 sm:grid-cols-2 lg:grid-cols-4">

        {{-- Products --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">
                        Products
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        0
                    </p>
                </div>

                <div class="rounded-xl bg-green-50 p-3 text-green-600">
                    📦
                </div>
            </div>
        </div>

        {{-- Sales --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">
                        Today's Sales
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        0
                    </p>
                </div>

                <div class="rounded-xl bg-blue-50 p-3 text-blue-600">
                    💰
                </div>
            </div>
        </div>

        {{-- Customers --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">
                        Customers
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        0
                    </p>
                </div>

                <div class="rounded-xl bg-purple-50 p-3 text-purple-600">
                    👥
                </div>
            </div>
        </div>

        {{-- Users --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm text-slate-500">
                        System Users
                    </p>

                    <p class="mt-2 text-2xl font-bold text-slate-900">
                        {{ \App\Models\User::count() }}
                    </p>
                </div>

                <div class="rounded-xl bg-orange-50 p-3 text-orange-600">
                    👤
                </div>
            </div>
        </div>

    </div>

    {{-- Administration --}}
    <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-4">
            <h2 class="font-semibold text-slate-900">
                System Administration
            </h2>

            <p class="mt-1 text-sm text-slate-500">
                Manage your hardware shop system.
            </p>
        </div>

        <div class="grid grid-cols-1 gap-4 p-6 sm:grid-cols-2 lg:grid-cols-3">

            <a href="{{ route('users.index') }}"
               class="rounded-xl border border-slate-200 p-5 transition hover:border-green-300 hover:bg-green-50">

                <div class="text-2xl">👥</div>

                <h3 class="mt-3 font-semibold text-slate-900">
                    Users
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Manage system users and staff accounts.
                </p>
            </a>

            <a href="#"
               class="rounded-xl border border-slate-200 p-5 transition hover:border-green-300 hover:bg-green-50">

                <div class="text-2xl">🔐</div>

                <h3 class="mt-3 font-semibold text-slate-900">
                    Roles & Permissions
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Manage roles and system permissions.
                </p>
            </a>

            <a href="#"
               class="rounded-xl border border-slate-200 p-5 transition hover:border-green-300 hover:bg-green-50">

                <div class="text-2xl">⚙️</div>

                <h3 class="mt-3 font-semibold text-slate-900">
                    System Settings
                </h3>

                <p class="mt-1 text-sm text-slate-500">
                    Configure your shop system.
                </p>
            </a>

        </div>
    </div>

</div>

@endsection