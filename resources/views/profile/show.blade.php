@extends('layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')

<div class="space-y-6">

    <div>
        <h1 class="text-2xl font-bold text-slate-900">My Profile</h1>
        <p class="mt-1 text-sm text-slate-500">Your account information and settings.</p>
    </div>

    @if ($errors->any())
        <div class="rounded-2xl border border-red-200 bg-red-50 p-4 text-red-800">
            <p class="font-semibold">Please correct the following errors:</p>
            <ul class="mt-2 list-inside list-disc text-sm">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="grid grid-cols-1 gap-6 xl:grid-cols-3">

        {{-- ================= USER CARD ================= --}}
        <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

            <div class="flex flex-col items-center text-center">
                <div class="flex h-20 w-20 items-center justify-center rounded-full bg-green-600 text-3xl font-bold text-white">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>

                <h2 class="mt-4 text-lg font-bold text-slate-900">{{ $user->name }}</h2>
                <p class="text-sm text-slate-500">{{ $user->email }}</p>

                <span class="mt-3 rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                    {{ ucfirst($user->role ?? 'Administrator') }}
                </span>
            </div>

            <dl class="mt-6 space-y-3 border-t border-slate-100 pt-5 text-sm">
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Member since</dt>
                    <dd class="font-semibold text-slate-800">{{ $user->created_at?->format('d M Y') }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Sales made</dt>
                    <dd class="font-semibold text-slate-800">{{ number_format($salesCount) }}</dd>
                </div>
                <div class="flex justify-between gap-3">
                    <dt class="text-slate-500">Total sold</dt>
                    <dd class="font-semibold text-slate-800">TSh {{ number_format($salesTotal) }}</dd>
                </div>
            </dl>
        </div>

        {{-- ================= FORMS ================= --}}
        <div class="space-y-6 xl:col-span-2">

            {{-- Account information --}}
            <form method="POST" action="{{ route('profile.update') }}"
                  class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                @csrf
                @method('PATCH')

                <h2 class="text-base font-bold text-slate-900">Account Information</h2>
                <p class="mt-1 text-sm text-slate-500">Update your name and email address.</p>

                <div class="mt-5 grid gap-5 md:grid-cols-2">
                    <div>
                        <label for="name" class="mb-2 block text-sm font-semibold text-slate-700">Full Name</label>
                        <input type="text" id="name" name="name" value="{{ old('name', $user->name) }}" required
                               class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>

                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">Email</label>
                        <input type="email" id="email" name="email" value="{{ old('email', $user->email) }}" required
                               class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                            class="rounded-xl bg-green-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-green-700">
                        Save Changes
                    </button>
                </div>
            </form>

            {{-- Change password --}}
            <form method="POST" action="{{ route('profile.password') }}"
                  class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">
                @csrf
                @method('PUT')

                <h2 class="text-base font-bold text-slate-900">Change Password</h2>
                <p class="mt-1 text-sm text-slate-500">Use a strong password you don't use elsewhere.</p>

                <div class="mt-5 grid gap-5 md:grid-cols-3">
                    <div>
                        <label for="current_password" class="mb-2 block text-sm font-semibold text-slate-700">Current Password</label>
                        <input type="password" id="current_password" name="current_password" required autocomplete="current-password"
                               class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>

                    <div>
                        <label for="password" class="mb-2 block text-sm font-semibold text-slate-700">New Password</label>
                        <input type="password" id="password" name="password" required autocomplete="new-password"
                               class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>

                    <div>
                        <label for="password_confirmation" class="mb-2 block text-sm font-semibold text-slate-700">Confirm Password</label>
                        <input type="password" id="password_confirmation" name="password_confirmation" required autocomplete="new-password"
                               class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500">
                    </div>
                </div>

                <div class="mt-6 flex justify-end">
                    <button type="submit"
                            class="rounded-xl bg-slate-900 px-6 py-2.5 text-sm font-semibold text-white shadow-sm transition hover:bg-slate-800">
                        Update Password
                    </button>
                </div>
            </form>

        </div>
    </div>
</div>

@endsection
