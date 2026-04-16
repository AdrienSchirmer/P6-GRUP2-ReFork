<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ServiceController;
use Laravel\Fortify\Features;
use Inertia\Inertia;
use App\Http\Resources\ServiceResource;


use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\admin_index_controller;

use App\Http\Controllers\Contactans;

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
Route::prefix('admin')->middleware(['auth', 'verified', 'isAdmin'])->group(function () {
    Route::get('/', [admin_index_controller::class, 'index'])->name('admindashboard');
});

Route::get('/contactans', [Contactans::class, 'index'])->name('contactans');

require __DIR__ . '/settings.php';
