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
        $request->validate([
            'available_seats' => 'required|integer|min:1',
            'vehicle_id' => 'required|exists:vehicles,id',

            'departure_address' => 'required|string|max:255',
            'departure_time' => 'required|date',

            'arrival_address' => 'required|string|max:255',
            'arrival_time' => 'required|date',
        ]);


        $trip = Trip::create([
            'available_seats' => $request->available_seats,
        ]);

        Stop::create([
            'order' => 1,
            'address' => $request->departure_address,
            'departure_time' => $request->departure_time,
            'arrival_time' => $request->departure_time,
            'trip_id' => $trip->id,
        ]);

        Stop::create([
            'order' => 2,
            'address' => $request->arrival_address,
            'departure_time' => $request->arrival_time,
            'arrival_time' => $request->arrival_time,
            'trip_id' => $trip->id,
        ]);

        Proposal::create([
            'comment' => $request->comment,
            'trip_id' => $trip->id,
            'vehicle_id' => $request->vehicle_id,
            'user_id' => Auth::id(),
        ]);

        return redirect()->route('trips.my')->with('message', 'Trajet proposé avec succès');
    }

    public function search()
    {
        return view('trips.search');
    }
}
