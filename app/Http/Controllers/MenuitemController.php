<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;

class MenuItemController extends Controller
{
    /**
     * Display the Dashboard listing of the Menu Items (the primary management page).
     */
    public function index()
    {
        // Get all Menu Items, eagerly loading the related Category name
        $menuItems = MenuItem::with('category')->get();

        // Get all Categories for the dropdown in the Add/Edit forms
        $categories = Category::all();

        // Required Feature 2A: Three Statistics Cards (First two dynamic)
        $totalItems = MenuItem::count();
        $totalCategories = Category::count();
        // A simple static/derived metric for the third card
        $averagePrice = MenuItem::avg('price');

        return view('dashboard', compact(
            'menuItems',
            'categories',
            'totalItems',
            'totalCategories',
            'averagePrice'
        ));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Required: Form validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
            // category_id is optional due to the nullable foreign key requirement
            'category_id' => 'nullable|exists:categories,id',
        ]);

        MenuItem::create($validatedData);

        // Required: Success message
        return redirect()->route('dashboard')->with('success', 'Menu Item added successfully!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, MenuItem $menuItem)
    {
        // Required: Form validation
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric|min:0.01',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        $menuItem->update($validatedData);

        // Required: Success message
        return redirect()->route('dashboard')->with('success', 'Menu Item updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        // Required: Success message
        return redirect()->route('dashboard')->with('success', 'Menu Item deleted successfully.');
    }
}