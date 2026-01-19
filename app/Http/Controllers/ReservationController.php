<?php

namespace App\Http\Controllers;

use App\Models\Reservation;
use App\Models\Trip;
use Illuminate\Support\Facades\Gate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReservationController extends Controller
{
    /**
     * S'inscrire à un trajet
     */
    public function store(Request $request)
    {
        $request->validate([
            'trip_id' => 'required|exists:trips,id',
        ]);

        $trip = Trip::find($request->trip_id) ?? abort(404);

        // L'utilisateur ne peut pas s'inscrire à sa propre proposition et n'est pas déjà inscrit au trajet
        Gate::authorize('subscribe-trip', $trip);

        // Ne peut pas s'inscire à un trajet inactif
        if (!$trip->is_active) {
            return back()->with('error', "Impossible de s'inscrire : Ce trajet est inactif.");
        }

        // Ne peut pas s'inscrire si plus de places disponibles
        if ($trip->available_seats <= 0) {
            return back()->with('error', "Impossible de s'inscrire : Plus aucune place disponible.");
        }

        Reservation::create([
            'trip_id' => $trip->id,
            'user_id' => Auth::id(),
        ]);

        // Décrémenter les places dispos
        $trip->decrement('available_seats');

        return back()->with('success', 'Vous vous êtes inscrit au trajet.');
    }

    /**
     * Se désinscrire à un trajet
     */
    public function destroy(Reservation $reservation)
    {
        $trip = $reservation->trip;

        // Seul le réserveur peut supprimer sa réservation
        Gate::authorize('unsubscribe-trip', $trip);

        $reservation->delete();

        // Incrémenter les places disposs
        $trip->increment('available_seats');

        return back()->with('success', 'Vous vous êtes désinscrit du trajet.');
    }
}
