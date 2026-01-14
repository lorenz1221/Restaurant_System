<?php

use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Settings\TwoFactor;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;

// --- New Imports for Restaurant System Controllers ---
use App\Http\Controllers\MenuItemController;
use App\Http\Controllers\CategoryController;
// -----------------------------------------------------

Route::get('/', function () {
    return view('welcome');
})->name('home');

// 1. DASHBOARD (Primary Management Page)
// The original Route::view is replaced to call the MenuItemController
// to load statistics, categories, and the menu item table data.
Route::get('dashboard', [MenuItemController::class, 'index'])
    ->middleware(['auth', 'verified'])
    ->name('dashboard');

Route::middleware(['auth'])->group(function () {

    // --- Existing Settings Routes ---
    Route::redirect('settings', 'settings/profile');

    Route::get('settings/profile', Profile::class)->name('profile.edit');
    Route::get('settings/password', Password::class)->name('user-password.edit');
    Route::get('settings/appearance', Appearance::class)->name('appearance.edit');

    Route::get('settings/two-factor', TwoFactor::class)
        ->middleware(
            when(
                Features::canManageTwoFactorAuthentication()
                    && Features::optionEnabled(Features::twoFactorAuthentication(), 'confirmPassword'),
                ['password.confirm'],
                [],
            ),
        )
        ->name('two-factor.show');

    // --- RESTAURANT MANAGEMENT CRUD ROUTES ---

    // Menu Item Management (CRUD actions for the Dashboard)
    // POST for creating new items
    Route::post('/menu-items', [MenuItemController::class, 'store'])->name('menu-items.store');
    // PUT for updating items
    Route::put('/menu-items/{menuItem}', [MenuItemController::class, 'update'])->name('menu-items.update');
    // DELETE for removing items
    Route::delete('/menu-items/{menuItem}', [MenuItemController::class, 'destroy'])->name('menu-items.destroy');

    // Category Management (Secondary Management Page - Required Feature 3)
    // GET for displaying the categories index page
    Route::get('/categories', [CategoryController::class, 'index'])->name('categories');
    // POST for creating new categories
    Route::post('/categories', [CategoryController::class, 'store'])->name('categories.store');
    // PUT for updating categories
    Route::put('/categories/{category}', [CategoryController::class, 'update'])->name('categories.update');
    // DELETE for removing categories
    Route::delete('/categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy');

});