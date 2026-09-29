@extends('layouts.app')

@section('title', 'Add User')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

    {{-- Header --}}
    <div>
        <a href="{{ route('users.index') }}"
           class="mb-3 inline-flex items-center gap-2 text-sm font-medium text-slate-500 hover:text-green-600">
            ← Back to Users
        </a>

        <h1 class="text-2xl font-bold text-slate-900">
            Add New User
        </h1>

        <p class="mt-1 text-sm text-slate-500">
            Create a new staff account and assign a role.
        </p>
    </div>


    {{-- Errors --}}
    @if($errors->any())

        <div class="rounded-xl border border-red-200 bg-red-50 p-4 text-sm text-red-700">

            <ul class="list-disc space-y-1 pl-5">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <form method="POST"
          action="{{ route('users.store') }}">

        @csrf


        {{-- Account Information --}}
        <div class="rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="font-semibold text-slate-900">
                    Account Information
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Basic information for the staff account.
                </p>

            </div>


            <div class="grid gap-6 p-6 md:grid-cols-2">

                {{-- Name --}}
                <div class="md:col-span-2">

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Full Name <span class="text-red-500">*</span>
                    </label>

                    <input type="text"
                           name="name"
                           value="{{ old('name') }}"
                           required
                           placeholder="e.g. John Michael"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100">

                </div>


                {{-- Email --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Email Address <span class="text-red-500">*</span>
                    </label>

                    <input type="email"
                           name="email"
                           value="{{ old('email') }}"
                           required
                           placeholder="john@kunambi.com"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100">

                </div>


                {{-- Phone --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Phone Number
                    </label>

                    <input type="text"
                           name="phone"
                           value="{{ old('phone') }}"
                           placeholder="07XX XXX XXX"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100">

                </div>


                {{-- Password --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Password <span class="text-red-500">*</span>
                    </label>

                    <input type="password"
                           name="password"
                           required
                           placeholder="Minimum 8 characters"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100">

                </div>


                {{-- Confirm Password --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Confirm Password <span class="text-red-500">*</span>
                    </label>

                    <input type="password"
                           name="password_confirmation"
                           required
                           placeholder="Repeat password"
                           class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm outline-none transition focus:border-green-500 focus:ring-2 focus:ring-green-100">

                </div>

            </div>

        </div>


        {{-- Role & Status --}}
        <div class="mt-6 rounded-2xl border border-slate-200 bg-white shadow-sm">

            <div class="border-b border-slate-200 px-6 py-5">

                <h2 class="font-semibold text-slate-900">
                    Role & Access
                </h2>

                <p class="mt-1 text-sm text-slate-500">
                    Choose what this user is allowed to access.
                </p>

            </div>


            <div class="grid gap-6 p-6 md:grid-cols-2">

                {{-- Role --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        User Role <span class="text-red-500">*</span>
                    </label>

                    <select name="role_id"
                            required
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100">

                        <option value="">
                            Select role
                        </option>

                        @foreach($roles as $role)

                            <option value="{{ $role->id }}"
                                @selected(old('role_id') == $role->id)>
                                {{ $role->display_name }}
                            </option>

                        @endforeach

                    </select>

                </div>


                {{-- Status --}}
                <div>

                    <label class="mb-2 block text-sm font-semibold text-slate-700">
                        Account Status <span class="text-red-500">*</span>
                    </label>

                    <select name="status"
                            required
                            class="w-full rounded-xl border border-slate-300 bg-white px-4 py-3 text-sm outline-none focus:border-green-500 focus:ring-2 focus:ring-green-100">

                        <option value="active"
                            @selected(old('status', 'active') === 'active')>
                            Active
                        </option>

                        <option value="inactive"
                            @selected(old('status') === 'inactive')>
                            Inactive
                        </option>

                    </select>

                </div>

            </div>

        </div>


        {{-- Buttons --}}
        <div class="mt-6 flex flex-col-reverse gap-3 sm:flex-row sm:justify-end">

            <a href="{{ route('users.index') }}"
               class="rounded-xl border border-slate-300 bg-white px-6 py-3 text-center text-sm font-semibold text-slate-700 hover:bg-slate-50">
                Cancel
            </a>

            <button type="submit"
                    class="rounded-xl bg-green-600 px-6 py-3 text-sm font-semibold text-white shadow-sm hover:bg-green-700">
                Create User
            </button>

        </div>

    </form>

</div>

@endsection