<?php

namespace App\Http\Controllers;
use Illuminate\Support\Facades\Auth;


use App\Models\Reservation;
use App\Models\Trip;

class DashboardController
{
    /**
     * Affiche le dashboard de l'utilisateur avec des informations
     */
    public function index()
    {
        $user = Auth::user();

        $proposedTripsQuery = Trip::whereHas('proposal', fn($q) =>
        $q->where('user_id', $user->id)
        );

        $reservationsQuery = Reservation::where('user_id', $user->id);

        return view('dashboard', [
            'activeProposed'   => (clone $proposedTripsQuery)
                ->where('is_active', true)
                ->count(),

            'inactiveProposed' => (clone $proposedTripsQuery)
                ->where('is_active', false)
                ->count(),

            'activeReserved'   => (clone $reservationsQuery)
                ->whereHas('trip', fn($q) => $q->where('is_active', true))
                ->count(),

            'inactiveReserved' => (clone $reservationsQuery)
                ->whereHas('trip', fn($q) => $q->where('is_active', false))
                ->count(),
        ]);
    }

}
