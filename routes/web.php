<?php

use App\Http\Controllers\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TripController;
use App\Http\Controllers\VehicleController;
use App\Http\Controllers\ReservationController;


Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/dashboard', [DashboardController::class, 'index']) ->middleware('verified') ->name('dashboard');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

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

    // Show all trips of the user
    Route::get('/trips/my-trips', [TripController::class, 'index'])->name('trips.my');

    // Create a trip (proposal)
    Route::get('/trips/create', [TripController::class, 'create'])->name('trips.create');
    Route::post('/trips', [TripController::class, 'store'])->name('trips.store');

    // Search for a trip
    Route::get('/trips/search', [TripController::class, 'search'])->name('trips.search');

    // Show one trip
    Route::get('/trips/{trip}', [TripController::class, 'show'])->name('trips.show');

    // Update a trip by cancelling it
    Route::patch('/trips/{trip}/cancel', [TripController::class, 'cancel'])->name('trips.cancel');

    // S'inscrire a un trajet -> créer une réservation
    Route::post('/reservations', [ReservationController::class, 'store'])
        ->name('reservations.store');

    // Se désinscrire -> supprimer la réservation
    Route::delete('/reservations/{reservation}', [ReservationController::class, 'destroy'])
        ->name('reservations.destroy');
});

require __DIR__ . '/auth.php';
