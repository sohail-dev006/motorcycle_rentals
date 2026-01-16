<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MotorcycleController;



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
});




require __DIR__.'/auth.php';
