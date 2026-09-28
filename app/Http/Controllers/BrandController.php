<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class BrandController extends Controller
{
    /**
     * Display a listing of brands.
     */
    public function index(Request $request)
    {
        $query = Brand::query();

        if ($request->filled('search')) {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('slug', 'like', "%{$search}%");
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $brands = $query
            ->withCount('products')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('brands.index', compact('brands'));
    }

    /**
     * Show the form for creating a new brand.
     */
    public function create()
    {
        return view('brands.create');
    }

    /**
     * Store a newly created brand.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:brands,name',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:brands,slug',
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ]);

        $validated['slug'] = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']);

        Brand::create($validated);

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand added successfully.');
    }

    /**
     * Display the specified brand.
     */
    public function show(Brand $brand)
    {
        $brand->load('products');

        return view('brands.show', compact('brand'));
    }

    /**
     * Show the form for editing the specified brand.
     */
    public function edit(Brand $brand)
    {
        return view('brands.edit', compact('brand'));
    }

    /**
     * Update the specified brand.
     */
    public function update(Request $request, Brand $brand)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('brands', 'name')->ignore($brand->id),
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('brands', 'slug')->ignore($brand->id),
            ],

            'description' => [
                'nullable',
                'string',
            ],

            'status' => [
                'required',
                Rule::in(['active', 'inactive']),
            ],
        ]);

        $validated['slug'] = !empty($validated['slug'])
            ? Str::slug($validated['slug'])
            : Str::slug($validated['name']);

        $brand->update($validated);

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand updated successfully.');
    }

    /**
     * Remove the specified brand.
     */
    public function destroy(Brand $brand)
    {
        if ($brand->products()->exists()) {
            return redirect()
                ->route('brands.index')
                ->with(
                    'error',
                    'This brand cannot be deleted because it has products.'
                );
        }

        $brand->delete();

        return redirect()
            ->route('brands.index')
            ->with('success', 'Brand deleted successfully.');
    }
}
