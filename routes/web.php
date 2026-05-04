<?php

use App\Http\Controllers\HomePageController;
use Illuminate\Support\Facades\Route;
use Laravel\Fortify\Features;
use Inertia\Inertia;
use App\Http\Resources\ServiceResource;

use App\Http\Controllers\ServiceController;
use App\Http\Controllers\AssignmentsController;
use App\Http\Controllers\Admin\admin_index_controller;
use App\Http\Controllers\Admin\admin_users_controller;
use App\Http\Controllers\Admin\admin_pharmacyguards_controller;
use App\Http\Controllers\Admin\admin_pharmacies_controller;
use App\Http\Controllers\Contactans;
use App\Http\Controllers\Admin\MailController;
use App\Http\Controllers\Admin\AdminServiceController as AdminServiceController;
use App\Http\Controllers\Admin\AssignmentsController as AdminAssignmentsController;
use App\Http\Controllers\Admin\ServiceScheduleController as ServiceScheduleController;




// Public Routes
Route::inertia('/', 'Welcome', [
    'canRegister' => Features::enabled(Features::registration()),
])->name('home');
//pedir cita 
//Route::get('/pedir-cita', function () { return Inertia::render('PedirCita');})->name('pedir-cita');
Route::get('/pedir-cita', [ServiceController::class, 'index'])->name('pedir-cita');
Route::post('/appointments', [ServiceController::class, 'store'])->name('appointments.store');
Route::get('/appointments/pdf', [ServiceController::class, 'downloadPdf'])->name('appointments.pdf');
Route::get('/appointments/booked-times', [ServiceController::class, 'getBookedTimes']);
Route::get('/appointments/schedule', [ServiceController::class, 'getSchedule']);
// Private Routes
Route::prefix('admin')->middleware(['auth', 'verified', 'isAdmin'])->group(function () {
    Route::get('/', [admin_index_controller::class, 'index'])->name('admindashboard');
    Route::resource('users', admin_users_controller::class);
    Route::resource('mail', MailController::class);
    Route::get('pharmacyguards/filter', [admin_pharmacyguards_controller::class, 'filter'])->name('pharmacyguards.filter');
    Route::resource('pharmacyguards', admin_pharmacyguards_controller::class);

    Route::resource('pharmacies', admin_pharmacies_controller::class);
    Route::resource('services', AdminServiceController::class);
    Route::resource('adminAssignments', AdminAssignmentsController::class);
    Route::resource('service-schedules', ServiceScheduleController::class);
});
Route::resource('assignments', AssignmentsController::class);

Route::get('/contactans', [Contactans::class, 'index'])->name('contactans');

require __DIR__ . '/settings.php';
