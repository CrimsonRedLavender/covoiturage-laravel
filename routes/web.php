<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\VehicleController;


Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware(['auth'])->group(function () {

    // Show the User's vehicle
    Route::get('/vehicles/my-vehicles', [VehicleController::class, 'index'])->name('vehicles.my');
    Route::get('/vehicles', function () {
        return redirect()->route('vehicles.my');
    });

    // Create a vehicle
    Route::get('/vehicles/create', [VehicleController::class, 'create'])->name('vehicles.create');
    Route::post('/vehicles', [VehicleController::class, 'store'])->name('vehicles.store');

    // Edit a vehicle
    Route::get('/vehicles/{vehicle}/edit', [VehicleController::class, 'edit'])->name('vehicles.edit');
    Route::put('/vehicles/{vehicle}', [VehicleController::class, 'update'])->name('vehicles.update');


    Route::delete('/vehicles/{vehicle}', [VehicleController::class, 'destroy'])->name('vehicles.destroy');
});

Route::middleware(['auth'])->group(function () {

    // Show all trips of the user
    Route::get('/trips/my-trips', [TripController::class, 'index'])->name('trips.my');

    // Create a trip (proposal)
    Route::get('/trips/create', [TripController::class, 'create'])->name('trips.create');
    Route::post('/trips', [TripController::class, 'store'])->name('trips.store');

    //Search for a trip
    Route::get('/trips/search', [TripController::class, 'search'])->name('trips.search');

    // Show one trip
    Route::get('/trips/{trip}', [TripController::class, 'show'])->name('trips.show');

    // Edit + update a trip
    Route::get('/trips/{trip}/edit', [TripController::class, 'edit'])->name('trips.edit');
    Route::put('/trips/{trip}', [TripController::class, 'update'])->name('trips.update');

    // Delete
    Route::delete('/trips/{trip}', [TripController::class, 'destroy'])->name('trips.destroy');
});


require __DIR__ . '/auth.php';
