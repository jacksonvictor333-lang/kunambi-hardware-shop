@extends('layouts.app')

@section('title', 'Users & Staff')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Users & Staff
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage system users, roles and account status.
            </p>
        </div>

        <a href="{{ route('users.create') }}"
           class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700">

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

            Add User
        </a>

    </div>


    {{-- Success --}}
    @if(session('success'))
        <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
            {{ session('success') }}
        </div>
    @endif


    {{-- Error --}}
    @if(session('error'))
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            {{ session('error') }}
        </div>
    @endif


    {{-- Validation Errors --}}
    @if($errors->any())
        <div class="rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
            <ul class="list-disc space-y-1 pl-5">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif


    {{-- Users Card --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="border-b border-slate-200 px-6 py-5">
            <div class="flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">

                <div>
                    <h2 class="font-semibold text-slate-900">
                        System Users
                    </h2>

                    <p class="text-sm text-slate-500">
                        {{ $users->total() }} user(s) registered
                    </p>
                </div>

            </div>
        </div>


        {{-- Desktop Table --}}
        <div class="hidden overflow-x-auto md:block">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            User
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Email
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Role
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100 bg-white">

                    @forelse($users as $user)

                        <tr class="transition hover:bg-slate-50">

                            {{-- User --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-full bg-green-100 font-bold text-green-700">
                                        {{ strtoupper(substr($user->name, 0, 1)) }}
                                    </div>

                                    <div>
                                        <p class="font-semibold text-slate-900">
                                            {{ $user->name }}
                                        </p>

                                        @if($user->id === auth()->id())
                                            <span class="text-xs text-green-600">
                                                You
                                            </span>
                                        @endif
                                    </div>

                                </div>

                            </td>


                            {{-- Email --}}
                            <td class="whitespace-nowrap px-6 py-4 text-sm text-slate-600">
                                {{ $user->email }}
                            </td>


                            {{-- Role --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                @forelse($user->roles as $role)

                                    <span class="inline-flex rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                        {{ $role->display_name }}
                                    </span>

                                @empty

                                    <span class="text-xs text-slate-400">
                                        No role assigned
                                    </span>

                                @endforelse

                            </td>


                            {{-- Status --}}
                            <td class="whitespace-nowrap px-6 py-4">

                                @if($user->status === 'active')

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-green-500"></span>

                                        Active
                                    </span>

                                @else

                                    <span class="inline-flex items-center gap-1.5 rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">

                                        <span class="h-1.5 w-1.5 rounded-full bg-red-500"></span>

                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="whitespace-nowrap px-6 py-4 text-right">

                                <div class="flex justify-end gap-2">

                                    {{-- Edit --}}
                                    <a href="{{ route('users.edit', $user) }}"
                                       class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 transition hover:bg-slate-100">
                                        Edit
                                    </a>


                                    {{-- Activate --}}
                                    @if($user->status !== 'active')

                                        <form method="POST"
                                              action="{{ route('users.activate', $user) }}">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="rounded-lg border border-green-200 bg-green-50 px-3 py-2 text-xs font-semibold text-green-700 hover:bg-green-100">
                                                Activate
                                            </button>

                                        </form>

                                    @elseif($user->id !== auth()->id())

                                        {{-- Deactivate --}}
                                        <form method="POST"
                                              action="{{ route('users.deactivate', $user) }}">

                                            @csrf
                                            @method('PATCH')

                                            <button type="submit"
                                                    class="rounded-lg border border-orange-200 bg-orange-50 px-3 py-2 text-xs font-semibold text-orange-700 hover:bg-orange-100"
                                                    onclick="return confirm('Deactivate this user?')">
                                                Deactivate
                                            </button>

                                        </form>

                                    @endif


                                    {{-- Delete --}}
                                    @if($user->id !== auth()->id())

                                        <form method="POST"
                                              action="{{ route('users.destroy', $user) }}">

                                            @csrf
                                            @method('DELETE')

                                            <button type="submit"
                                                    class="rounded-lg border border-red-200 bg-red-50 px-3 py-2 text-xs font-semibold text-red-700 hover:bg-red-100"
                                                    onclick="return confirm('Delete this user permanently?')">
                                                Delete
                                            </button>

                                        </form>

                                    @endif

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="px-6 py-12 text-center">

                                <div class="mx-auto max-w-sm">

                                    <div class="mx-auto mb-4 flex h-14 w-14 items-center justify-center rounded-full bg-slate-100">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-7 w-7 text-slate-400"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor"
                                             stroke-width="2">
                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  d="M17 20h5v-2a4 4 0 00-4-4h-1m-4 6H3v-2a4 4 0 014-4h6a4 4 0 014 4v2zM9 10a4 4 0 100-8 4 4 0 000 8zm8-2a3 3 0 100-6 3 3 0 000 6z"/>
                                        </svg>

                                    </div>

                                    <h3 class="font-semibold text-slate-900">
                                        No users found
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Add your first system user to get started.
                                    </p>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        {{-- Mobile Cards --}}
        <div class="divide-y divide-slate-100 md:hidden">

            @forelse($users as $user)

                <div class="space-y-4 p-5">

                    <div class="flex items-center gap-3">

                        <div class="flex h-11 w-11 items-center justify-center rounded-full bg-green-100 font-bold text-green-700">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>

                        <div class="min-w-0 flex-1">

                            <p class="truncate font-semibold text-slate-900">
                                {{ $user->name }}
                            </p>

                            <p class="truncate text-sm text-slate-500">
                                {{ $user->email }}
                            </p>

                        </div>

                    </div>


                    <div class="flex flex-wrap gap-2">

                        @foreach($user->roles as $role)

                            <span class="rounded-full bg-blue-50 px-3 py-1 text-xs font-semibold text-blue-700">
                                {{ $role->display_name }}
                            </span>

                        @endforeach


                        @if($user->status === 'active')

                            <span class="rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                Active
                            </span>

                        @else

                            <span class="rounded-full bg-red-50 px-3 py-1 text-xs font-semibold text-red-700">
                                Inactive
                            </span>

                        @endif

                    </div>


                    <div class="flex flex-wrap gap-2">

                        <a href="{{ route('users.edit', $user) }}"
                           class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700">
                            Edit
                        </a>

                        @if($user->status !== 'active')

                            <form method="POST"
                                  action="{{ route('users.activate', $user) }}">

                                @csrf
                                @method('PATCH')

                                <button class="rounded-lg bg-green-50 px-3 py-2 text-xs font-semibold text-green-700">
                                    Activate
                                </button>

                            </form>

                        @elseif($user->id !== auth()->id())

                            <form method="POST"
                                  action="{{ route('users.deactivate', $user) }}">

                                @csrf
                                @method('PATCH')

                                <button class="rounded-lg bg-orange-50 px-3 py-2 text-xs font-semibold text-orange-700">
                                    Deactivate
                                </button>

                            </form>

                        @endif

                    </div>

                </div>

            @empty

                <div class="p-8 text-center text-sm text-slate-500">
                    No users found.
                </div>

            @endforelse

        </div>


        {{-- Pagination --}}
        @if($users->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $users->links() }}
            </div>

        @endif

    </div>

</div>

@endsection