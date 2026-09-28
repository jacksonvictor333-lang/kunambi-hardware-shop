<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Login - KUNAMBI HARDWARE SHOP</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        * { box-sizing: border-box; }
        body { margin: 0; }

        /* ---------- LEFT PHOTO PANEL ---------- */
        .hardware-image {
            background-color: #14532d; /* fallback if the image is missing */
            background-image:
                linear-gradient(135deg,
                    rgba(5, 46, 22, 0.70),
                    rgba(22, 101, 52, 0.42),
                    rgba(6, 78, 59, 0.55)),
                url('{{ asset('images/hardware-login.jpg') }}');
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
        }

        .image-overlay {
            background: linear-gradient(to bottom,
                rgba(2, 44, 34, 0.10),
                rgba(2, 44, 34, 0.72));
        }

        .grid-pattern {
            background-image:
                linear-gradient(rgba(255,255,255,0.055) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.055) 1px, transparent 1px);
            background-size: 42px 42px;
        }

        /* ---------- ANIMATIONS ---------- */
        @keyframes floatOne {
            0%, 100% { transform: translateY(0) translateX(0); }
            50%      { transform: translateY(-25px) translateX(10px); }
        }
        @keyframes floatTwo {
            0%, 100% { transform: translateY(0); }
            50%      { transform: translateY(25px); }
        }
        .float-one { animation: floatOne 10s ease-in-out infinite; }
        .float-two { animation: floatTwo 12s ease-in-out infinite; }

        @keyframes cardIn {
            from { opacity: 0; transform: translateY(20px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .login-card { animation: cardIn .7s ease-out both; }

        /* ---------- BUTTON SHINE ---------- */
        .login-button { position: relative; overflow: hidden; }
        .login-button::before {
            content: "";
            position: absolute;
            top: 0; left: -100%;
            width: 50%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,.20), transparent);
            transform: skewX(-20deg);
            transition: .6s;
        }
        .login-button:hover::before { left: 130%; }

        /* ---------- MOBILE BRAND ---------- */
        @media (max-width: 1023px) {
            .mobile-brand-bg {
                background-color: #14532d;
                background-image:
                    linear-gradient(rgba(20, 83, 45, .82), rgba(6, 78, 59, .82)),
                    url('{{ asset('images/hardware-login.jpg') }}');
                background-size: cover;
                background-position: center;
            }
        }
    </style>
</head>

<body class="min-h-screen bg-slate-50 antialiased">

<div class="flex min-h-screen">

    {{-- =========================================================
         LEFT: HARDWARE PHOTO + BRAND
    ========================================================== --}}
    <section class="hardware-image relative hidden w-1/2 overflow-hidden lg:flex">

        <div class="image-overlay absolute inset-0"></div>
        <div class="grid-pattern absolute inset-0"></div>

        <div class="float-one absolute -left-24 -top-24 h-80 w-80 rounded-full bg-green-300/10 blur-3xl"></div>
        <div class="float-two absolute -bottom-32 -right-24 h-[28rem] w-[28rem] rounded-full bg-emerald-300/10 blur-3xl"></div>

        <div class="relative z-10 flex min-h-screen w-full flex-col justify-between p-10 xl:p-14">

            {{-- TOP --}}
            <div class="flex items-center gap-3">
                <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-white/15 text-white shadow-xl ring-1 ring-white/25 backdrop-blur">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7M8 11h8M9 4h6"/>
                    </svg>
                </div>

                <div class="leading-tight">
                    <p class="text-sm font-semibold text-green-100/90">KUNAMBI</p>
                    <p class="text-xs font-medium tracking-[.18em] text-white/70">HARDWARE SHOP</p>
                </div>
            </div>


            {{-- CENTER --}}
            <div class="max-w-xl">

                <div class="mb-6 inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-4 py-2 backdrop-blur">
                    <span class="h-2 w-2 rounded-full bg-green-300 shadow-lg shadow-green-300/60"></span>
                    <span class="text-xs font-semibold uppercase tracking-wider text-green-50">
                        Hardware Management System
                    </span>
                </div>

                <h1 class="leading-none tracking-tight text-white drop-shadow-lg">
                    <span class="block text-6xl font-black xl:text-7xl">KUNAMBI</span>
                    <span class="mt-3 block text-3xl font-bold tracking-[.12em] text-green-100 xl:text-4xl">
                        HARDWARE SHOP
                    </span>
                </h1>

                <p class="mt-7 max-w-lg text-base leading-7 text-green-50/90 xl:text-lg">
                    Manage your products, stock, sales, customers and daily
                    hardware operations from one simple system.
                </p>

                <div class="mt-8 flex flex-wrap gap-3">
                    <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-medium text-white backdrop-blur">✓ Inventory</span>
                    <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-medium text-white backdrop-blur">✓ Sales</span>
                    <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-medium text-white backdrop-blur">✓ Products</span>
                    <span class="rounded-full border border-white/15 bg-white/10 px-4 py-2 text-xs font-medium text-white backdrop-blur">✓ Customers</span>
                </div>

            </div>


            {{-- BOTTOM --}}
            <div class="flex items-end justify-between gap-6">
                <div>
                    <p class="text-sm font-semibold text-white">Building better business.</p>
                    <p class="mt-1 text-xs text-green-100/70">Simple • Fast • Reliable</p>
                </div>

                <p class="text-right text-xs text-green-100/60">
                    © {{ date('Y') }}<br>
                    KUNAMBI HARDWARE SHOP
                </p>
            </div>

        </div>

    </section>


    {{-- =========================================================
         RIGHT: LOGIN CARD
    ========================================================== --}}
    <section class="relative flex w-full items-center justify-center overflow-hidden px-5 py-10 lg:w-1/2">

        <div class="pointer-events-none absolute -right-24 -top-24 h-80 w-80 rounded-full bg-green-100 blur-3xl"></div>
        <div class="pointer-events-none absolute -bottom-24 -left-24 h-72 w-72 rounded-full bg-emerald-100 blur-3xl"></div>

        <div class="login-card relative z-10 w-full max-w-md">

            {{-- MOBILE BRAND --}}
            <div class="mobile-brand-bg mb-6 rounded-2xl p-5 shadow-lg lg:hidden">
                <div class="flex items-center gap-3">
                    <div class="flex h-12 w-12 items-center justify-center rounded-xl bg-white/15 text-white ring-1 ring-white/20">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7M8 11h8M9 4h6"/>
                        </svg>
                    </div>

                    <div class="leading-tight">
                        <span class="block text-xl font-black text-white">KUNAMBI</span>
                        <span class="block text-xs font-bold tracking-[.15em] text-green-100">HARDWARE SHOP</span>
                    </div>
                </div>
            </div>


            {{-- CARD --}}
            <div class="rounded-[2rem] border border-slate-200/80 bg-white p-7 shadow-2xl shadow-slate-200/70 sm:p-9">

                <div class="mb-8">
                    <div class="mb-5 flex h-12 w-12 items-center justify-center rounded-2xl bg-green-50 text-green-600">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 3h4a2 2 0 012 2v14a2 2 0 01-2 2h-4M10 17l5-5-5-5M15 12H3"/>
                        </svg>
                    </div>

                    <h2 class="text-3xl font-extrabold tracking-tight text-slate-900">Welcome back</h2>

                    <p class="mt-2 text-sm leading-6 text-slate-500">
                        Sign in to access your
                        <span class="font-semibold text-green-600">KUNAMBI</span>
                        Hardware Management System.
                    </p>
                </div>


                {{-- Session status --}}
                @if (session('status'))
                    <div class="mb-5 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm font-medium text-green-700">
                        {{ session('status') }}
                    </div>
                @endif


                {{-- FORM --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="mb-2 block text-sm font-semibold text-slate-700">
                            Email Address
                        </label>

                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l9 6 9-6M5 5h14a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V7a2 2 0 012-2z"/>
                                </svg>
                            </div>

                            <input
                                id="email"
                                type="email"
                                name="email"
                                value="{{ old('email') }}"
                                required
                                autofocus
                                autocomplete="username"
                                placeholder="you@example.com"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 py-3.5 pl-12 pr-4 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-green-500 focus:bg-white focus:ring-4 focus:ring-green-100"
                            >
                        </div>

                        @error('email')
                            <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Password --}}
                    <div>
                        <div class="mb-2 flex items-center justify-between">
                            <label for="password" class="block text-sm font-semibold text-slate-700">
                                Password
                            </label>

                            @if (Route::has('password.request'))
                                <a href="{{ route('password.request') }}" class="text-xs font-semibold text-green-600 transition hover:text-green-700">
                                    Forgot password?
                                </a>
                            @endif
                        </div>

                        <div class="relative">
                            <div class="pointer-events-none absolute inset-y-0 left-0 flex items-center pl-4 text-slate-400">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V8a4 4 0 10-8 0v3m-2 0h12a1 1 0 011 1v7a1 1 0 01-1 1H6a1 1 0 01-1-1v-7a1 1 0 011-1z"/>
                                </svg>
                            </div>

                            <input
                                id="password"
                                type="password"
                                name="password"
                                required
                                autocomplete="current-password"
                                placeholder="Enter your password"
                                class="w-full rounded-2xl border border-slate-200 bg-slate-50/70 py-3.5 pl-12 pr-12 text-sm text-slate-900 outline-none transition placeholder:text-slate-400 hover:border-slate-300 focus:border-green-500 focus:bg-white focus:ring-4 focus:ring-green-100"
                            >

                            <button
                                type="button"
                                onclick="togglePassword()"
                                class="absolute inset-y-0 right-0 flex items-center pr-4 text-slate-400 transition hover:text-green-600"
                                aria-label="Show or hide password"
                            >
                                <svg id="eye-open" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2 12s3.6-7 10-7 10 7 10 7-3.6 7-10 7S2 12 2 12z"/>
                                    <circle cx="12" cy="12" r="3"/>
                                </svg>

                                <svg id="eye-closed" xmlns="http://www.w3.org/2000/svg" class="hidden h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.7">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 3l18 18M10.6 10.6a3 3 0 004.2 4.2M9.9 5.2A9.7 9.7 0 0112 5c6.4 0 10 7 10 7a17 17 0 01-3.2 4.1M6.6 6.6C3.7 8.5 2 12 2 12s3.6 7 10 7a9.6 9.6 0 004.4-1"/>
                                </svg>
                            </button>
                        </div>

                        @error('password')
                            <p class="mt-2 text-sm font-medium text-red-600">{{ $message }}</p>
                        @enderror
                    </div>


                    {{-- Remember --}}
                    <div class="flex items-center justify-between pt-1">
                        <label for="remember_me" class="flex cursor-pointer items-center gap-2.5">
                            <input
                                id="remember_me"
                                type="checkbox"
                                name="remember"
                                class="h-4 w-4 rounded border-slate-300 text-green-600 focus:ring-green-500"
                            >
                            <span class="text-sm text-slate-600">Remember me</span>
                        </label>
                    </div>


                    {{-- Submit --}}
                    <button
                        type="submit"
                        class="login-button group flex w-full items-center justify-center gap-2 rounded-2xl bg-green-600 px-5 py-3.5 text-sm font-bold text-white shadow-xl shadow-green-600/20 transition-all hover:-translate-y-0.5 hover:bg-green-700 hover:shadow-green-600/30 focus:outline-none focus:ring-4 focus:ring-green-200 active:translate-y-0"
                    >
                        <span class="relative z-10">Sign In</span>

                        <svg xmlns="http://www.w3.org/2000/svg" class="relative z-10 h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 12h14M13 6l6 6-6 6"/>
                        </svg>
                    </button>

                </form>


                {{-- Security message --}}
                <div class="mt-7 flex items-center justify-center gap-2 text-xs text-slate-400">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 text-green-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 3l7 4v5c0 4.5-3 7.8-7 9-4-1.2-7-4.5-7-9V7l7-4z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4"/>
                    </svg>
                    <span>Secure business management system</span>
                </div>

            </div>


            {{-- Mobile copyright --}}
            <p class="mt-6 text-center text-xs text-slate-400 lg:hidden">
                © {{ date('Y') }} KUNAMBI HARDWARE SHOP. All rights reserved.
            </p>

        </div>

    </section>

</div>


<script>
    function togglePassword() {
        const input  = document.getElementById('password');
        const open   = document.getElementById('eye-open');
        const closed = document.getElementById('eye-closed');
        const show   = input.type === 'password';

        input.type = show ? 'text' : 'password';
        open.classList.toggle('hidden', show);
        closed.classList.toggle('hidden', !show);
    }
</script>

</body>
</html>