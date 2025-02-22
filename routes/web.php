<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\BookingController;
use App\Http\Controllers\MaintenanceController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/dashboard', function () {
    return Inertia::render('Dashboard/MainDashboard', [
        'vehicles' => \App\Models\Vehicle::all()
    ]);
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/admin', [ProfileController::class, 'admin'])->name('admin.index')->middleware(AdminMiddleware::class);
    Route::put('/admin/role/{id}', [ProfileController::class, 'update_role'])->name('admin.update-role');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::get('/user/list', [UserController::class, 'list'])->name('user.list');

    Route::get('/vehicle', [VehicleController::class, 'view'])->name('vehicle.view');
    Route::get('/vehicle/{id}', [VehicleController::class, 'detail'])->name('vehicle.detail');
    Route::get('/vehicle/{id}/edit', [VehicleController::class, 'edit'])->name('vehicle.edit');
    Route::post('/vehicle', [VehicleController::class, 'store'])->name('vehicle.store');
    Route::put('/vehicle/{vehicle}', [VehicleController::class, 'update'])->name('vehicle.update');
    Route::delete('/vehicle/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicle.destroy');

    Route::get('/booking', [BookingController::class, 'view'])->name('booking.view');
    Route::post('/booking', [BookingController::class, 'store'])->name('booking.store');

    Route::get('/maintenance', [MaintenanceController::class, 'view'])->name('maintenance.view');
    Route::post('/maintenance', [MaintenanceController::class, 'store'])->name('maintenance.store');
});


require __DIR__ . '/auth.php';
