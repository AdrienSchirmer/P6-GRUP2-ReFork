<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Inertia\Inertia;


// Public Routes
Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');
//pedir cita 
Route::get('/pedir-cita', function () {
    return Inertia::render('PedirCita');
})->name('pedir-cita');

// Private Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

require __DIR__ . '/settings.php';
