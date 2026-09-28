@extends('layouts.app')

@section('title', 'My Profile')
@section('page-title', 'My Profile')

@section('content')

<div class="mx-auto max-w-4xl space-y-6">

```
{{-- Header --}}
<div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

    <div class="flex flex-col gap-5 sm:flex-row sm:items-center">

        <div class="flex h-20 w-20 items-center justify-center rounded-full bg-green-600 text-2xl font-bold text-white shadow-lg">
            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
        </div>

        <div>

            <h1 class="text-2xl font-bold text-slate-900">
                {{ Auth::user()->name }}
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                {{ Auth::user()->email }}
            </p>

            <span class="mt-3 inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                {{ ucfirst(Auth::user()->role ?? 'User') }}
            </span>

        </div>

    </div>

</div>


{{-- Success Message --}}
@if(session('success'))

    <div class="rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
        {{ session('success') }}
    </div>

@endif


{{-- Profile Form --}}
<div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

    <div class="border-b border-slate-100 px-6 py-5">

        <h2 class="text-base font-bold text-slate-900">
            Profile Information
        </h2>

        <p class="mt-1 text-sm text-slate-500">
            Update your personal account information.
        </p>

    </div>


    <form
        method="POST"
        action="{{ route('profile.update') }}"
        class="space-y-6 p-6"
    >

        @csrf

        {{-- Name --}}
        <div>

            <label class="mb-2 block text-sm font-semibold text-slate-700">
                Full Name
            </label>

            <input
                type="text"
                name="name"
                value="{{ old('name', Auth::user()->name) }}"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 focus:border-green-500 focus:ring-2 focus:ring-green-500/20"
                required
            >

            @error('name')
                <p class="mt-1 text-xs text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Email --}}
        <div>

            <label class="mb-2 block text-sm font-semibold text-slate-700">
                Email Address
            </label>

            <input
                type="email"
                name="email"
                value="{{ old('email', Auth::user()->email) }}"
                class="w-full rounded-xl border border-slate-300 px-4 py-3 text-sm text-slate-900 focus:border-green-500 focus:ring-2 focus:ring-green-500/20"
                required
            >

            @error('email')
                <p class="mt-1 text-xs text-red-600">
                    {{ $message }}
                </p>
            @enderror

        </div>


        {{-- Role --}}
        <div>

            <label class="mb-2 block text-sm font-semibold text-slate-700">
                Account Role
            </label>

            <input
                type="text"
                value="{{ ucfirst(Auth::user()->role ?? 'User') }}"
                class="w-full cursor-not-allowed rounded-xl border border-slate-200 bg-slate-50 px-4 py-3 text-sm text-slate-500"
                disabled
            >

        </div>


        {{-- Actions --}}
        <div class="flex flex-col gap-3 border-t border-slate-100 pt-5 sm:flex-row sm:justify-end">

            <a
                href="{{ route('dashboard') }}"
                class="inline-flex items-center justify-center rounded-xl border border-slate-300 bg-white px-5 py-2.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50"
            >
                Cancel
            </a>

            <button
                type="submit"
                class="inline-flex items-center justify-center rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-green-700"
            >
                Save Changes
            </button>

        </div>

    </form>

</div>
```

</div>

@endsection
