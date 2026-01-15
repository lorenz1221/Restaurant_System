<?php

namespace App\Http\Controllers;

use App\Models\MenuItem;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class MenuItemController extends Controller
{
    /**
     * Display the Dashboard listing of the Menu Items (the primary management page).
     */
    public function index(Request $request)
    {
        // Search and filter query
        $query = MenuItem::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Paginate results
        $menuItems = $query->paginate(10)->appends($request->query());

        // Get all Categories for the dropdown in the Add/Edit forms and filter
        $categories = Category::all();

        // Required Feature 2A: Three Statistics Cards (First two dynamic)
        $totalItems = MenuItem::count();
        $totalCategories = Category::count();
        // A simple static/derived metric for the third card
        $averagePrice = MenuItem::avg('price');
        $minPrice = MenuItem::min('price');
        $maxPrice = MenuItem::max('price');

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
            'photo' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            $validatedData['photo'] = $request->file('photo')->store('items', 'public');
        }

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
            'photo' => 'nullable|image|mimes:jpg,png|max:2048',
        ]);

        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($menuItem->photo) {
                Storage::disk('public')->delete($menuItem->photo);
            }
            $validatedData['photo'] = $request->file('photo')->store('items', 'public');
        }

        $menuItem->update($validatedData);

        // Required: Success message
        return redirect()->route('dashboard')->with('success', 'Menu Item updated successfully!');
    }

    /**
     * Remove the specified resource from storage (soft delete).
     */
    public function destroy(MenuItem $menuItem)
    {
        $menuItem->delete();

        // Required: Success message
        return redirect()->route('dashboard')->with('success', 'Menu Item moved to trash successfully.');
    }

    /**
     * Display the trash page with soft-deleted items.
     */
    public function trash()
    {
        $trashedItems = MenuItem::onlyTrashed()->with('category')->get();

        return view('menu_items.trash', compact('trashedItems'));
    }

    /**
     * Restore a soft-deleted item.
     */
    public function restore($id)
    {
        $menuItem = MenuItem::withTrashed()->findOrFail($id);
        $menuItem->restore();

        return redirect()->route('menu-items.trash')->with('success', 'Menu Item restored successfully.');
    }

    /**
     * Permanently delete a soft-deleted item.
     */
    public function forceDelete($id)
    {
        $menuItem = MenuItem::withTrashed()->findOrFail($id);

        // Delete photo if exists
        if ($menuItem->photo) {
            Storage::disk('public')->delete($menuItem->photo);
        }

        $menuItem->forceDelete();

        return redirect()->route('menu-items.trash')->with('success', 'Menu Item permanently deleted.');
    }

    /**
     * Export filtered results to PDF.
     */
    public function exportPdf(Request $request)
    {
        // Same query as index for filtered results
        $query = MenuItem::with('category');

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        $menuItems = $query->get();

        $pdf = Pdf::loadView('menu_items.pdf', compact('menuItems'));
        $filename = 'menu_items_' . now()->format('Y-m-d_H-i-s') . '.pdf';

        return $pdf->download($filename);
    }
}
