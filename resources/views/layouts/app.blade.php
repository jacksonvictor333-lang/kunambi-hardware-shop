<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>
        {{ config('app.name', 'KUNAMBI HARDWARE SHOP') }}
        - @yield('title', 'Dashboard')
    </title>

    {{-- Tailwind CDN --}}
    <script src="https://cdn.tailwindcss.com?plugins=forms"></script>

    <style>
        input:not([type="checkbox"]):not([type="radio"]):not([type="hidden"]),
        select,
        textarea {
            padding-top: 0.7rem;
            padding-bottom: 0.7rem;
            font-size: 0.95rem;
        }
    </style>

    {{-- Alpine --}}
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-slate-50 text-slate-900 antialiased">

@php
    /*
    |--------------------------------------------------------------------------
    | Safe Route Helper
    |--------------------------------------------------------------------------
    | Accepts a single route name or an array of names.
    | Returns the URL of the first route that exists, otherwise '#'.
    */
    $url = function ($names) {
        foreach ((array) $names as $name) {
            if (\Illuminate\Support\Facades\Route::has($name)) {
                return route($name);
            }
        }

        return '#';
    };

    /*
    |--------------------------------------------------------------------------
    | Active Route Helper (accepts a string or an array of patterns)
    |--------------------------------------------------------------------------
    */
    $is = fn ($patterns) => request()->routeIs(...(array) $patterns);

    /*
    |--------------------------------------------------------------------------
    | Current User
    |--------------------------------------------------------------------------
    */
    $currentUser = auth()->user();

    /*
    |--------------------------------------------------------------------------
    | Permission Helpers
    |--------------------------------------------------------------------------
    */
    $can = function (string $permission) use ($currentUser): bool {
        if (! $currentUser) {
            return false;
        }

        return $currentUser->hasPermission($permission);
    };

    $canAny = function (array $permissions) use ($currentUser): bool {
        if (! $currentUser) {
            return false;
        }

        return $currentUser->hasAnyPermission($permissions);
    };

    /*
    |--------------------------------------------------------------------------
    | Navigation Classes
    |--------------------------------------------------------------------------
    */
    $activeClass   = 'bg-green-50 font-semibold text-green-700';
    $inactiveClass = 'font-medium text-slate-600 hover:bg-slate-100 hover:text-slate-900';

    /*
    |--------------------------------------------------------------------------
    | Main Navigation
    |--------------------------------------------------------------------------
    */
    $mainNav = [];

    // Dashboard
    if ($can('view-dashboard')) {
        $mainNav[] = [
            'label' => 'Dashboard',
            'icon'  => '🏠',
            'route' => 'dashboard',
            'match' => 'dashboard',
        ];
    }

    // Products
    if ($can('view-products')) {
        $mainNav[] = [
            'label' => 'Products',
            'icon'  => '📦',
            'route' => 'products.index',
            'match' => 'products.*',
        ];
    }

    // Categories
    if ($can('view-categories')) {
        $mainNav[] = [
            'label' => 'Categories',
            'icon'  => '🏷️',
            'route' => 'categories.index',
            'match' => 'categories.*',
        ];
    }

    // Brands
    if ($can('view-brands')) {
        $mainNav[] = [
            'label' => 'Brands',
            'icon'  => '🔖',
            'route' => 'brands.index',
            'match' => 'brands.*',
        ];
    }

    // Inventory
    if ($canAny([
        'view-inventory',
        'stock-in',
        'stock-adjustment',
        'view-stock-movements',
    ])) {

        $inventoryChildren = [];

        if ($can('view-inventory')) {
            $inventoryChildren[] = [
                'label' => 'Overview',
                'route' => 'inventory.index',
                'match' => 'inventory.index',
            ];
        }

        if ($can('stock-in')) {
            $inventoryChildren[] = [
                'label' => 'Stock In',
                'route' => 'inventory.stock-in',
                'match' => 'inventory.stock-in*',
            ];
        }

        if ($can('stock-adjustment')) {
            $inventoryChildren[] = [
                'label' => 'Adjustment',
                'route' => 'inventory.adjustment',
                'match' => 'inventory.adjustment*',
            ];
        }

        if ($can('view-stock-movements')) {
            $inventoryChildren[] = [
                'label' => 'Movement History',
                'route' => 'inventory.movements',
                'match' => 'inventory.movements',
            ];
        }

        if (count($inventoryChildren) > 0) {
            $mainNav[] = [
                'label'    => 'Inventory',
                'icon'     => '📊',
                'match'    => 'inventory.*',
                'children' => $inventoryChildren,
            ];
        }
    }

    // Sales / POS
    if ($canAny([
        'view-sales',
        'create-sale',
        'print-receipt',
    ])) {

        $salesChildren = [];

        if ($can('create-sale')) {
            $salesChildren[] = [
                'label' => 'Point of Sale',
                'route' => 'sales.pos',
                'match' => 'sales.pos',
            ];
        }

        if ($can('view-sales')) {
            $salesChildren[] = [
                'label' => 'Sales History',
                // Tries each name in order; uses the first route that exists.
                'route' => ['sales.history', 'sales.index'],
                'match' => ['sales.history', 'sales.index', 'sales.show'],
            ];
        }

        if (count($salesChildren) > 0) {
            $mainNav[] = [
                'label'    => 'Sales / POS',
                'icon'     => '🛒',
                'match'    => 'sales.*',
                'children' => $salesChildren,
            ];
        }
    }

    // Customers
    if ($can('view-customers')) {
        $mainNav[] = [
            'label' => 'Customers',
            'icon'  => '👥',
            'route' => 'customers.index',
            'match' => 'customers.*',
        ];
    }

    // Expenses
    if ($can('view-expenses')) {
        $mainNav[] = [
            'label' => 'Expenses',
            'icon'  => '💰',
            'route' => 'expenses.index',
            'match' => 'expenses.*',
        ];
    }

    // Reports
    if ($can('view-reports')) {
        $mainNav[] = [
            'label' => 'Reports',
            'icon'  => '📈',
            'route' => 'reports.index',
            'match' => 'reports.*',
        ];
    }

    /*
    |--------------------------------------------------------------------------
    | System Navigation
    |--------------------------------------------------------------------------
    */
    $systemNav = [];

    // Notifications (no permission yet, always visible)
    $systemNav[] = [
        'label' => 'Notifications',
        'icon'  => '🔔',
        'route' => 'notifications.index',
        'match' => 'notifications.*',
    ];

    // Users
    if ($can('view-users')) {
        $systemNav[] = [
            'label' => 'Users',
            'icon'  => '👤',
            'route' => 'users.index',
            'match' => 'users.*',
        ];
    }

    // Roles
    if ($can('view-roles')) {
        $systemNav[] = [
            'label' => 'Roles',
            'icon'  => '🛡️',
            'route' => 'roles.index',
            'match' => 'roles.*',
        ];
    }

    // Permissions (part of role administration)
    if ($can('view-roles')) {
        $systemNav[] = [
            'label' => 'Permissions',
            'icon'  => '🔐',
            'route' => 'permissions.index',
            'match' => 'permissions.*',
        ];
    }

    // Settings
    if ($can('view-settings')) {
        $systemNav[] = [
            'label' => 'Settings',
            'icon'  => '⚙️',
            'route' => 'settings.index',
            'match' => 'settings.*',
        ];
    }
@endphp

<div x-data="{ sidebarOpen: false }" class="min-h-screen">

    {{-- ============================================================= --}}
    {{-- MOBILE OVERLAY --}}
    {{-- ============================================================= --}}
    <div
        x-show="sidebarOpen"
        x-transition.opacity
        @click="sidebarOpen = false"
        class="fixed inset-0 z-40 bg-slate-900/50 lg:hidden"
        style="display: none;"
    ></div>

    {{-- ============================================================= --}}
    {{-- SIDEBAR --}}
    {{-- ============================================================= --}}
    <aside
        class="fixed inset-y-0 left-0 z-50 flex w-64 flex-col border-r border-slate-200 bg-white transition-transform duration-300 lg:translate-x-0"
        :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
    >

        {{-- LOGO --}}
        <div class="flex h-20 items-center border-b border-slate-100 px-6">
            <div class="flex items-center gap-3">

                <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-600 text-white shadow-sm">
                    <svg
                        xmlns="http://www.w3.org/2000/svg"
                        class="h-5 w-5"
                        fill="none"
                        viewBox="0 0 24 24"
                        stroke="currentColor"
                        stroke-width="2"
                    >
                        <path
                            stroke-linecap="round"
                            stroke-linejoin="round"
                            d="M3 7h18M5 7v10a2 2 0 002 2h10a2 2 0 002-2V7M8 11h8M9 4h6"
                        />
                    </svg>
                </div>

                <div>
                    <h1 class="text-base font-bold text-slate-900">
                        KUNAMBI HARDWARE SHOP
                    </h1>
                    <p class="text-xs text-slate-500">
                        Management System
                    </p>
                </div>

            </div>
        </div>

        {{-- NAVIGATION --}}
        <nav class="flex-1 overflow-y-auto px-4 py-6">

            {{-- Main Menu --}}
            <p class="mb-3 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
                Main Menu
            </p>

            <div class="space-y-1">

                @forelse ($mainNav as $item)

                    @if (isset($item['children']))

                        {{-- Parent with Children --}}
                        <div x-data="{ open: {{ $is($item['match']) ? 'true' : 'false' }} }">

                            <button
                                type="button"
                                @click="open = !open"
                                class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition {{ $is($item['match']) ? $activeClass : $inactiveClass }}"
                            >
                                <span>{{ $item['icon'] }}</span>
                                <span>{{ $item['label'] }}</span>

                                <span
                                    class="ml-auto text-xs transition-transform duration-200"
                                    :class="open ? 'rotate-90' : ''"
                                >
                                    ›
                                </span>
                            </button>

                            {{-- Children --}}
                            <div
                                x-show="open"
                                x-transition
                                class="mt-1 space-y-1 pl-9"
                                @if (! $is($item['match']))
                                    style="display: none;"
                                @endif
                            >
                                @foreach ($item['children'] as $child)
                                    <a
                                        href="{{ $url($child['route']) }}"
                                        class="block rounded-lg px-3 py-2 text-[13px] transition {{ $is($child['match']) ? 'bg-green-50 font-semibold text-green-700' : 'font-medium text-slate-500 hover:bg-slate-100 hover:text-slate-900' }}"
                                    >
                                        {{ $child['label'] }}
                                    </a>
                                @endforeach
                            </div>

                        </div>

                    @else

                        {{-- Single Menu Item --}}
                        <a
                            href="{{ $url($item['route']) }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition {{ $is($item['match']) ? $activeClass : $inactiveClass }}"
                        >
                            <span>{{ $item['icon'] }}</span>
                            <span>{{ $item['label'] }}</span>
                        </a>

                    @endif

                @empty

                    <div class="rounded-xl border border-dashed border-slate-200 p-4 text-center">
                        <p class="text-xs font-medium text-slate-500">
                            No menu items available.
                        </p>
                    </div>

                @endforelse

            </div>

            {{-- SYSTEM --}}
            @if (count($systemNav) > 0)

                <p class="mb-3 mt-8 px-3 text-xs font-semibold uppercase tracking-wider text-slate-400">
                    System
                </p>

                <div class="space-y-1">
                    @foreach ($systemNav as $item)
                        <a
                            href="{{ $url($item['route']) }}"
                            class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm transition {{ $is($item['match']) ? $activeClass : $inactiveClass }}"
                        >
                            <span>{{ $item['icon'] }}</span>
                            <span>{{ $item['label'] }}</span>
                        </a>
                    @endforeach
                </div>

            @endif

        </nav>

        {{-- USER SECTION --}}
        <div class="border-t border-slate-100 p-4">
            <div class="flex items-center gap-3 rounded-xl bg-slate-50 p-3">

                {{-- Avatar --}}
                <div class="flex h-10 w-10 shrink-0 items-center justify-center rounded-full bg-green-600 font-semibold text-white">
                    {{ strtoupper(substr($currentUser->name ?? 'A', 0, 1)) }}
                </div>

                {{-- User Info --}}
                <div class="min-w-0 flex-1">
                    <p class="truncate text-sm font-semibold text-slate-900">
                        {{ $currentUser->name ?? 'Administrator' }}
                    </p>

                    <p class="truncate text-xs text-slate-500">
                        @if ($currentUser && $currentUser->roles->count())
                            {{ $currentUser->roles->first()->display_name }}
                        @else
                            User
                        @endif
                    </p>
                </div>

                {{-- Logout --}}
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button
                        type="submit"
                        title="Logout"
                        class="text-slate-400 transition hover:text-red-600"
                    >
                        ↪
                    </button>
                </form>

            </div>
        </div>

    </aside>

    {{-- ============================================================= --}}
    {{-- MAIN AREA --}}
    {{-- ============================================================= --}}
    <div class="lg:pl-64">

        {{-- TOPBAR --}}
        <header
            class="sticky top-0 z-30 flex h-20 items-center justify-between border-b border-slate-200 bg-white/95 px-4 backdrop-blur sm:px-6"
        >

            <div class="flex items-center gap-3">

                {{-- Mobile Menu Button --}}
                <button
                    @click="sidebarOpen = true"
                    class="rounded-lg p-2 text-slate-600 hover:bg-slate-100 lg:hidden"
                >
                    ☰
                </button>

                <div>
                    <p class="text-sm text-slate-500">
                        Welcome back 👋
                    </p>
                    <h2 class="text-lg font-bold text-slate-900">
                        @yield('page-title', 'Dashboard')
                    </h2>
                </div>

            </div>

            <div class="flex items-center gap-3">

                {{-- NOTIFICATIONS --}}
                @if (\Illuminate\Support\Facades\Route::has('notifications.index'))
                    <a
                        href="{{ route('notifications.index') }}"
                        class="relative rounded-xl p-2.5 text-slate-500 transition hover:bg-slate-100 hover:text-slate-900"
                    >
                        🔔
                        <span class="absolute right-1.5 top-1.5 h-2 w-2 rounded-full bg-red-500"></span>
                    </a>
                @endif

                {{-- USER DROPDOWN --}}
                <div
                    class="relative border-l border-slate-200 pl-3"
                    x-data="{ userMenu: false }"
                    @click.outside="userMenu = false"
                    @keydown.escape.window="userMenu = false"
                >

                    <button
                        type="button"
                        @click="userMenu = !userMenu"
                        class="flex items-center gap-3 rounded-xl px-2 py-1.5 text-left transition hover:bg-slate-100"
                    >
                        <div class="flex h-9 w-9 items-center justify-center rounded-full bg-green-600 text-sm font-semibold text-white">
                            {{ strtoupper(substr($currentUser->name ?? 'A', 0, 1)) }}
                        </div>

                        <div class="hidden sm:block">
                            <p class="text-sm font-semibold leading-tight text-slate-900">
                                {{ $currentUser->name ?? 'Admin' }}
                            </p>

                            <p class="text-xs text-slate-500">
                                @if ($currentUser && $currentUser->roles->count())
                                    {{ $currentUser->roles->first()->display_name }}
                                @else
                                    User
                                @endif
                            </p>
                        </div>

                        <svg
                            class="hidden h-4 w-4 text-slate-400 transition-transform duration-200 sm:block"
                            :class="userMenu ? 'rotate-180' : ''"
                            xmlns="http://www.w3.org/2000/svg"
                            fill="none"
                            viewBox="0 0 24 24"
                            stroke="currentColor"
                            stroke-width="2"
                        >
                            <path
                                stroke-linecap="round"
                                stroke-linejoin="round"
                                d="M19 9l-7 7-7-7"
                            />
                        </svg>
                    </button>

                    {{-- Dropdown --}}
                    <div
                        x-show="userMenu"
                        x-transition
                        style="display: none;"
                        class="absolute right-0 z-50 mt-3 w-64 rounded-2xl border border-slate-200 bg-white p-2 shadow-xl"
                    >

                        <div class="border-b border-slate-100 px-3 pb-3 pt-2">
                            <p class="truncate text-sm font-bold text-slate-900">
                                {{ $currentUser->name ?? 'Admin' }}
                            </p>
                            <p class="truncate text-xs text-slate-500">
                                {{ $currentUser->email ?? '' }}
                            </p>
                        </div>

                        <div class="py-1">
                            @if (\Illuminate\Support\Facades\Route::has('profile.show'))
                                <a
                                    href="{{ route('profile.show') }}"
                                    class="flex items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-slate-700 transition hover:bg-slate-100"
                                >
                                    <span>👤</span>
                                    My Profile
                                </a>
                            @endif
                        </div>

                        <div class="border-t border-slate-100 pt-1">
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button
                                    type="submit"
                                    class="flex w-full items-center gap-3 rounded-xl px-3 py-2.5 text-sm font-medium text-red-600 transition hover:bg-red-50"
                                >
                                    <span>↪</span>
                                    Logout
                                </button>
                            </form>
                        </div>

                    </div>

                </div>

            </div>

        </header>

        {{-- PAGE CONTENT --}}
        <main class="p-4 sm:p-6 lg:p-8">

            @if (session('success'))
                <div class="mb-6 rounded-xl border border-green-200 bg-green-50 px-4 py-3 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="mb-6 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                    {{ session('error') }}
                </div>
            @endif

            @yield('content')

        </main>

    </div>

</div>

</body>
</html>