<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource (the secondary management page).
     * The Category page must show the count of related items.
     */
    public function index()
    {
        // Eagerly load the related item count
        $categories = Category::withCount('menuItems')->get();

        return view('categories', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name',
            'description' => 'nullable|string',
        ]);

        // Convert empty/whitespace-only descriptions to null before saving
        $validatedData['description'] = trim($validatedData['description'] ?? '') === ''
            ? null
            : $validatedData['description'];

        Category::create($validatedData);

        return redirect()->route('categories')->with('success', 'Menu Category created successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255|unique:categories,name,' . $category->id,
            'description' => 'nullable|string',
        ]);

        // Convert empty/whitespace-only descriptions to null before updating
        $validatedData['description'] = trim($validatedData['description'] ?? '') === ''
            ? null
            : $validatedData['description'];

        $category->update($validatedData);

        return redirect()->route('categories')->with('success', 'Menu Category updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        try {
            $category->delete();

            return redirect()->route('categories')->with('success', 'Menu Category deleted successfully.');
        } catch (\Exception $e) {
            return redirect()->route('categories')->with('error', 'Error deleting category: ' . $e->getMessage());
        }
    }
}
