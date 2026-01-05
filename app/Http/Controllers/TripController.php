<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Stop;
use App\Models\Proposal;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TripController extends Controller
{
    public function index()
    {
        $user = Auth::user();

        $reservations = $user->reservations()->with(['trip.stops', 'trip.proposals.vehicle'])->get();
        $proposedTrips = $user->proposals()->with(['trip.stops', 'trip.proposals.vehicle'])->get()->pluck('trip');


        return view('trips.index', ['reservations' => $reservations, 'proposedTrips' => $proposedTrips,]);
    }


    public function create()
    {
        $vehicles = Auth::user()->vehicles;
        return view('trips.create', ['vehicles' => $vehicles]);
    }

    public function store(Request $request)
    {
        // -------------------------
        // 1. VALIDATION
        // -------------------------
        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id',
            'available_seats' => 'required|integer|min:1',
            'comment' => 'nullable|string|max:200',

            'stops' => 'required|array|min:1|max:10',
            'stops.*.address' => 'required|string|max:255',
            'stops.*.departure_time' => 'required|date',
            'stops.*.arrival_time' => 'required|date|after_or_equal:stops.*.departure_time',
        ]);


        // -------------------------
        // 2. CREATE TRIP
        // -------------------------
        $trip = Trip::create([
            'available_seats' => $validated['available_seats'],
        ]);


        // -------------------------
        // 3. CREATE PROPOSAL
        // -------------------------
        $proposal = Proposal::create([
            'trip_id' => $trip->id,
            'vehicle_id' => $validated['vehicle_id'],
            'user_id' => auth()->id(),
            'comment' => $validated['comment'] ?? null,
        ]);


        // -------------------------
        // 4. CREATE STOPS
        // -------------------------
        foreach ($validated['stops'] as $index => $stopData) {
            Stop::create([
                'trip_id' => $trip->id,
                'order' => $index + 1,
                'address' => $stopData['address'],
                'departure_time' => $stopData['departure_time'],
                'arrival_time' => $stopData['arrival_time'],
            ]);
        }


        // -------------------------
        // 5. REDIRECT
        // -------------------------
        return redirect()
            ->route('trips.my')
            ->with('success', 'Trajet créé avec succès !');
    }



    public function search()
    {
        return view('trips.search');
    }
}
