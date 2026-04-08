<?php

use App\Http\Controllers\FuelEntryController;
use App\Http\Controllers\ProfileController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

// The Welcome/Landing Page
Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

// All routes inside this group require the user to be logged in
Route::middleware(['auth', 'verified'])->group(function () {
    
    // Task 2: Fetch all entries and render the Dashboard
    Route::get('/dashboard', [FuelEntryController::class, 'index'])->name('dashboard');
    
    // Task 2 & 3: Save a new fuel price
    Route::post('/fuel', [FuelEntryController::class, 'store'])->name('fuel.store');
    
    // Task 3: Delete a history entry
    Route::delete('/fuel/{fuelEntry}', [FuelEntryController::class, 'destroy'])->name('fuel.destroy');

    // Profile Management (Default Breeze Routes)
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';