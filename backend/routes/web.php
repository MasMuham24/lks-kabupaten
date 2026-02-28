<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\EquipmentController;
use App\Http\Controllers\RentalController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest')->group(function () {
    Route::view('/', 'auth.login')->name('login');
    Route::view('/login', 'auth.login');
    Route::view('/register', 'auth.register')->name('register');

    Route::post('/login', [AuthController::class, 'login'])->name('login.process');
    Route::post('/register', [AuthController::class, 'register'])->name('register.process');
});

Route::middleware('auth')->group(function () {

    Route::get('/dashboard', [RentalController::class, 'indexUser'])->name('dashboard');

    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

    Route::middleware('admin')->prefix('admin')->group(function () {

        Route::get('/dashboard', function () {
            return view('admin.dashboard');
        })->name('admin.dashboard');

        Route::resource('equipment', EquipmentController::class);

        Route::get('/rentals', [RentalController::class, 'index'])->name('admin.rentals.index');
        Route::post('/rentals/{id}/return', [RentalController::class, 'returnRental'])->name('admin.rentals.return');
    });

    Route::resource('rental', RentalController::class)->only([
        'store',
        'show'
    ]);

});
