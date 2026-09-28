@extends('layouts.app')

@section('title', 'Add Brand')
@section('page-title', 'Add Brand')

@section('content')

<div class="mx-auto max-w-3xl space-y-6">

    <div class="flex items-center justify-between">

        <div>
            <h1 class="text-2xl font-bold text-slate-900">
                Add Brand
            </h1>

            <p class="mt-1 text-sm text-slate-500">
                Add a hardware product brand.
            </p>
        </div>

        <a
            href="{{ route('brands.index') }}"
            class="rounded-xl border border-slate-200 bg-white px-4 py-2.5 text-sm font-semibold text-slate-700 shadow-sm hover:bg-slate-50"
        >
            ← Back
        </a>

    </div>


    @if($errors->any())

        <div class="rounded-xl border border-red-200 bg-red-50 p-4">

            <p class="font-semibold text-red-700">
                Please fix the following errors:
            </p>

            <ul class="mt-2 list-disc space-y-1 pl-5 text-sm text-red-600">

                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach

            </ul>

        </div>

    @endif


    <div class="rounded-2xl border border-slate-200 bg-white p-6 shadow-sm">

        <form
            method="POST"
            action="{{ route('brands.store') }}"
            class="space-y-6"
        >

            @csrf


            {{-- Name --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Brand Name
                </label>

                <input
                    type="text"
                    name="name"
                    value="{{ old('name') }}"
                    placeholder="e.g. Schneider Electric"
                    required
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                >

            </div>


            {{-- Slug --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Slug
                </label>

                <input
                    type="text"
                    name="slug"
                    value="{{ old('slug') }}"
                    placeholder="e.g. schneider-electric"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                >

                <p class="mt-1 text-xs text-slate-500">
                    Leave empty to generate automatically.
                </p>

            </div>


            {{-- Description --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Description
                </label>

                <textarea
                    name="description"
                    rows="4"
                    placeholder="Write a short description..."
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                >{{ old('description') }}</textarea>

            </div>


            {{-- Status --}}
            <div>

                <label class="mb-2 block text-sm font-medium text-slate-700">
                    Status
                </label>

                <select
                    name="status"
                    class="w-full rounded-xl border-slate-300 text-sm shadow-sm focus:border-green-500 focus:ring-green-500"
                >

                    <option
                        value="active"
                        @selected(old('status', 'active') === 'active')
                    >
                        Active
                    </option>

                    <option
                        value="inactive"
                        @selected(old('status') === 'inactive')
                    >
                        Inactive
                    </option>

                </select>

            </div>


            {{-- Actions --}}
            <div class="flex justify-end gap-3 border-t border-slate-100 pt-6">

                <a
                    href="{{ route('brands.index') }}"
                    class="rounded-xl border border-slate-200 px-5 py-2.5 text-sm font-semibold text-slate-700 hover:bg-slate-50"
                >
                    Cancel
                </a>

                <button
                    type="submit"
                    class="rounded-xl bg-green-600 px-6 py-2.5 text-sm font-semibold text-white shadow-sm hover:bg-green-700"
                >
                    Save Brand
                </button>

            </div>

        </form>

    </div>

</div>

@endsection