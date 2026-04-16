<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use Laravel\Fortify\Features;
use Inertia\Inertia;
use App\Http\Resources\ServiceResource;



// Public Routes
Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');
//pedir cita 
//Route::get('/pedir-cita', function () { return Inertia::render('PedirCita');})->name('pedir-cita');
Route::get('/pedir-cita', [ServiceController::class, 'index'])->name('pedir-cita');
Route::post('/appointments', [ServiceController::class, 'store'])
    ->name('appointments.store');

// Private Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__ . '/settings.php';
