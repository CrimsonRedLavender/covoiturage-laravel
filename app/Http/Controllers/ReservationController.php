<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Trip;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * Subscribe to a trip
     */
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
        ]);

        $trip = Trip::findOrFail($request->trip_id);

        // Prevent driver from subscribing
        if ($trip->proposal->user_id === Auth::id()) {
            abort(403, 'Vous ne pouvez pas vous inscrire à votre propre trajet.');
        }

        // Prevent duplicate reservation
        if ($trip->reservations()->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'Vous êtes déjà inscrit à ce trajet.');
        }

        // Prevent subscribing to inactive trip
        if (!$trip->is_active) {
            return back()->with('error', 'Ce trajet est inactif.');
        }

        // Prevent subscribing if no seats left
        if ($trip->available_seats <= 0) {
            return back()->with('error', 'Plus aucune place disponible.');
        }

        // Create reservation
        Reservation::create([
            'trip_id' => $trip->id,
            'user_id' => Auth::id(),
        ]);

        // Decrease available seats
        $trip->decrement('available_seats');

        return back()->with('success', 'Vous êtes inscrit au trajet.');
    }

    /**
     * Unsubscribe from a trip
     */
    public function destroy(Reservation $reservation)
    {
        // Only the owner of the reservation can delete it
        if ($reservation->user_id !== Auth::id()) {
            abort(403);
        }

        $trip = $reservation->trip;

        // Delete reservation
        $reservation->delete();

        // Increase available seats
        $trip->increment('available_seats');

        return back()->with('success', 'Vous vous êtes désinscrit du trajet.');
    }
}
