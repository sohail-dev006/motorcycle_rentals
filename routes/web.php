<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotorcycleController;
use App\Http\Controllers\AddOnController;
use App\Http\Controllers\BrandController;
use App\Http\Controllers\TourController;
use App\Http\Controllers\CustomerController;

Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
    // List all motorcycles
    Route::get('/motorcycles', [MotorcycleController::class, 'index'])->name('motorcycles.index');

    // Show create form
    Route::get('/motorcycles/create', [MotorcycleController::class, 'create'])->name('motorcycles.create');

    // Store new motorcycle
    Route::post('/motorcycles', [MotorcycleController::class, 'store'])->name('motorcycles.store');

    // Show edit form
    Route::get('/motorcycles/{motorcycle}/edit', [MotorcycleController::class, 'edit'])->name('motorcycles.edit');

    // Update existing motorcycle
    Route::put('/motorcycles/{motorcycle}', [MotorcycleController::class, 'update'])->name('motorcycles.update');

    // Delete motorcycle
    Route::delete('/motorcycles/{motorcycle}', [MotorcycleController::class, 'destroy'])->name('motorcycles.destroy');

    // Optional: show single motorcycle
    Route::get('/motorcycles/{motorcycle}', [MotorcycleController::class, 'show'])->name('motorcycles.show');

    Route::get('/add-on', [AddOnController::class, 'index'])->name('add.index');
    Route::get('/add-on/create', [AddOnController::class, 'create'])->name('add.create');
    Route::post('/add-on', [AddOnController::class, 'store'])->name('add.store');
    Route::get('/add-on/{add}/edit', [AddOnController::class, 'edit'])->name('add.edit');
    Route::put('/add-on/{add}', [AddOnController::class, 'update'])->name('add.update');
    Route::get('/add-on/{add}', [AddOnController::class, 'show'])->name('add.show');
    // Delete add-on
    Route::delete('/add-on/{add}', [AddOnController::class, 'destroy'])->name('add.destroy');

    // Brands 
    Route::get('/brands', [BrandController::class, 'index'])->name('brands.index');
    Route::get('/brands/create', [BrandController::class, 'create'])->name('brands.create');
    Route::post('/brands', [BrandController::class, 'store'])->name('brands.store');

    // Use {brand} consistently
    Route::get('/brands/{brand}/edit', [BrandController::class, 'edit'])->name('brands.edit');
    Route::put('/brands/{brand}', [BrandController::class, 'update'])->name('brands.update');
    Route::get('/brands/{brand}', [BrandController::class, 'show'])->name('brands.show');
    Route::delete('/brands/{brand}', [BrandController::class, 'destroy'])->name('brands.destroy');



    // Tours
    Route::get('/tours', [TourController::class, 'index'])->name('tours.index');
    Route::get('/tours/create', [TourController::class, 'create'])->name('tours.create');
    Route::post('/tours', [TourController::class, 'store'])->name('tours.store');

    Route::get('/tours/{tour}/edit', [TourController::class, 'edit'])->name('tours.edit');
    Route::put('/tours/{tour}', [TourController::class, 'update'])->name('tours.update');
    Route::get('/tours/{tour}', [TourController::class, 'show'])->name('tours.show');
    Route::delete('/tours/{tour}', [TourController::class, 'destroy'])->name('tours.destroy');


    // Customers 
    Route::get('/customers', [CustomerController::class, 'index'])->name('customers.index');
    Route::get('/customers/create', [CustomerController::class, 'create'])->name('customers.create');
    Route::post('/customers', [CustomerController::class, 'store'])->name('customers.store');
    Route::get('/customers/{customer}/edit', [CustomerController::class, 'edit'])->name('customers.edit');
    Route::put('/customers/{customer}', [CustomerController::class, 'update'])->name('customers.update');
    Route::get('/customers/{customer}', [CustomerController::class, 'show'])->name('customers.show');
    Route::delete('/customers/{customer}', [CustomerController::class, 'destroy'])->name('customers.destroy');

});




require __DIR__.'/auth.php';
