@extends('layouts.app')

@section('title', 'Brands')
@section('page-title', 'Brands')

@section('content')

<div class="space-y-6">

    {{-- Header --}}
    <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

        <div>
            <h1 class="text-2xl font-bold tracking-tight text-slate-900">
                Brands
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Manage hardware product brands.
            </p>
        </div>

        <a
            href="{{ route('brands.create') }}"
            class="inline-flex items-center justify-center gap-2 rounded-xl bg-green-600 px-5 py-3 text-sm font-semibold text-white shadow-sm transition hover:-translate-y-0.5 hover:bg-green-700"
        >
            <svg xmlns="http://www.w3.org/2000/svg"
                 class="h-5 w-5"
                 fill="none"
                 viewBox="0 0 24 24"
                 stroke="currentColor">
                <path stroke-linecap="round"
                      stroke-linejoin="round"
                      stroke-width="2"
                      d="M12 4v16m8-8H4"/>
            </svg>

            Add Brand
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


    {{-- Search & Filter --}}
    <div class="rounded-2xl border border-slate-200 bg-white p-5 shadow-sm">

        <form
            method="GET"
            action="{{ route('brands.index') }}"
            class="grid grid-cols-1 gap-4 md:grid-cols-4"
        >

            <div class="md:col-span-2">

                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Search
                </label>

                <input
                    type="text"
                    name="search"
                    value="{{ request('search') }}"
                    placeholder="Search brand..."
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                >

            </div>


            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                >

                    <option value="">
                        All Status
                    </option>

                    <option
                        value="active"
                        @selected(request('status') === 'active')
                    >
                        Active
                    </option>

                    <option
                        value="inactive"
                        @selected(request('status') === 'inactive')
                    >
                        Inactive
                    </option>

                </select>

            </div>


            <div class="flex items-end">

                <button
                    type="submit"
                    class="w-full rounded-xl bg-slate-900 px-5 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800"
                >
                    Filter
                </button>

            </div>

        </form>

    </div>


    {{-- Table --}}
    <div class="overflow-hidden rounded-2xl border border-slate-200 bg-white shadow-sm">

        <div class="overflow-x-auto">

            <table class="min-w-full divide-y divide-slate-200">

                <thead class="bg-slate-50">

                    <tr>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Brand
                        </th>

                        <th class="px-6 py-4 text-left text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Slug
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Products
                        </th>

                        <th class="px-6 py-4 text-center text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Status
                        </th>

                        <th class="px-6 py-4 text-right text-xs font-semibold uppercase tracking-wider text-slate-500">
                            Actions
                        </th>

                    </tr>

                </thead>


                <tbody class="divide-y divide-slate-100">

                    @forelse($brands as $brand)

                        <tr class="transition hover:bg-slate-50">

                            {{-- Brand --}}
                            <td class="px-6 py-4">

                                <div class="flex items-center gap-3">

                                    <div class="flex h-10 w-10 items-center justify-center rounded-xl bg-green-50 text-green-600">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-5 w-5"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M20 7l-8-4-8 4m16 0v10l-8 4-8-4V7m16 0l-8 4m0 0L4 7m8 4v10"/>

                                        </svg>

                                    </div>

                                    <div>

                                        <p class="font-semibold text-slate-900">
                                            {{ $brand->name }}
                                        </p>

                                        @if($brand->description)

                                            <p class="mt-1 max-w-xs truncate text-xs text-slate-500">
                                                {{ $brand->description }}
                                            </p>

                                        @endif

                                    </div>

                                </div>

                            </td>


                            {{-- Slug --}}
                            <td class="px-6 py-4">

                                <span class="rounded-lg bg-slate-100 px-3 py-1 text-xs font-medium text-slate-600">
                                    {{ $brand->slug }}
                                </span>

                            </td>


                            {{-- Products --}}
                            <td class="px-6 py-4 text-center">

                                <span class="font-semibold text-slate-700">
                                    {{ $brand->products_count }}
                                </span>

                            </td>


                            {{-- Status --}}
                            <td class="px-6 py-4 text-center">

                                @if($brand->status === 'active')

                                    <span class="inline-flex rounded-full bg-green-100 px-3 py-1 text-xs font-semibold text-green-700">
                                        Active
                                    </span>

                                @else

                                    <span class="inline-flex rounded-full bg-slate-100 px-3 py-1 text-xs font-semibold text-slate-600">
                                        Inactive
                                    </span>

                                @endif

                            </td>


                            {{-- Actions --}}
                            <td class="px-6 py-4">

                                <div class="flex justify-end gap-2">

                                    <a
                                        href="{{ route('brands.show', $brand) }}"
                                        class="rounded-lg border border-slate-200 px-3 py-2 text-xs font-semibold text-slate-700 hover:bg-slate-50"
                                    >
                                        View
                                    </a>

                                    <a
                                        href="{{ route('brands.edit', $brand) }}"
                                        class="rounded-lg border border-blue-200 px-3 py-2 text-xs font-semibold text-blue-600 hover:bg-blue-50"
                                    >
                                        Edit
                                    </a>

                                    <form
                                        method="POST"
                                        action="{{ route('brands.destroy', $brand) }}"
                                        onsubmit="return confirm('Are you sure you want to delete this brand?')"
                                    >

                                        @csrf
                                        @method('DELETE')

                                        <button
                                            type="submit"
                                            class="rounded-lg border border-red-200 px-3 py-2 text-xs font-semibold text-red-600 hover:bg-red-50"
                                        >
                                            Delete
                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5" class="px-6 py-16 text-center">

                                <div class="mx-auto max-w-sm">

                                    <div class="mx-auto flex h-14 w-14 items-center justify-center rounded-2xl bg-slate-100">

                                        <svg xmlns="http://www.w3.org/2000/svg"
                                             class="h-7 w-7 text-slate-400"
                                             fill="none"
                                             viewBox="0 0 24 24"
                                             stroke="currentColor">

                                            <path stroke-linecap="round"
                                                  stroke-linejoin="round"
                                                  stroke-width="2"
                                                  d="M20 7l-8-4-8 4m16 0v10l-8 4-8-4V7m16 0l-8 4m0 0L4 7m8 4v10"/>

                                        </svg>

                                    </div>

                                    <h3 class="mt-4 text-lg font-semibold text-slate-900">
                                        No brands found
                                    </h3>

                                    <p class="mt-1 text-sm text-slate-500">
                                        Start by adding your first brand.
                                    </p>

                                    <a
                                        href="{{ route('brands.create') }}"
                                        class="mt-5 inline-flex rounded-xl bg-green-600 px-5 py-2.5 text-sm font-semibold text-white hover:bg-green-700"
                                    >
                                        Add Brand
                                    </a>

                                </div>

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>


        @if($brands->hasPages())

            <div class="border-t border-slate-200 px-6 py-4">
                {{ $brands->links() }}
            </div>

        @endif

    </div>

</div>

@endsection