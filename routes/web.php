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
    Route::get('/motorcycles', [MotorcycleController::class, 'index'])->name('motorcycles.index');
    Route::get('/motorcycles/create', [MotorcycleController::class, 'create'])->name('motorcycles.create');
    Route::post('/motorcycles', [MotorcycleController::class, 'store'])->name('motorcycles.store');
});



require __DIR__.'/auth.php';
