<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\contactans;
use App\Http\Controllers\AssignmentsController;


// Public Routes
Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');
Route::resource('assignments', AssignmentsController::class);


// Private Routes
Route::middleware(['auth', 'verified'])->group(function () {
    Route::inertia('dashboard', 'Dashboard')->name('dashboard');
});

Route::inertia('contactans', [contactans::class, 'show'])->name('contactans');

require __DIR__ . '/settings.php';
