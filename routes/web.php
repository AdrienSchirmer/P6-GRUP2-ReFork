<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use App\Http\Controllers\contactans;
use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\admin_index_controller;


// Public Routes
Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');
Route::resource('assignments', AssignmentsController::class);


// Private Routes
Route::prefix('admin')->middleware(['auth', 'verified', 'isAdmin'])->group(function () {
    Route::get('/', [admin_index_controller::class, 'index'])->name('admindashboard');
});

Route::inertia('contactans', [contactans::class, 'show'])->name('contactans');

require __DIR__ . '/settings.php';
