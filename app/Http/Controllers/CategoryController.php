<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    /**
     * Display a listing of categories.
     */
    public function index(Request $request)
    {
        $query = Category::query();

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

        $categories = $query
            ->withCount('products')
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'unique:categories,name',
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                'unique:categories,slug',
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

        Category::create($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category added successfully.');
    }

    /**
     * Display the specified category.
     */
    public function show(Category $category)
    {
        $category->load('products');

        return view('categories.show', compact('category'));
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    /**
     * Update the specified category.
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('categories', 'name')->ignore($category->id),
            ],

            'slug' => [
                'nullable',
                'string',
                'max:255',
                Rule::unique('categories', 'slug')->ignore($category->id),
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

        $category->update($validated);

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    /**
     * Remove the specified category.
     */
    public function destroy(Category $category)
    {
        if ($category->products()->exists()) {
            return redirect()
                ->route('categories.index')
                ->with('error', 'This category cannot be deleted because it has products.');
        }

        $category->delete();

        return redirect()
            ->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}
