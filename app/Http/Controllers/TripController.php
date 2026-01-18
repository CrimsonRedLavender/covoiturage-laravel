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

        $reservations = $user->reservations()->with(['trip.stops', 'trip.proposal.vehicle'])->get();
        $proposals = $user->proposals()->with(['trip.stops', 'trip.proposal.vehicle'])->get();

        return view('trips.index', ['reservations' => $reservations, 'proposals' => $proposals]);
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

    public function cancel(Trip $trip)
    {
        if ($trip->proposal->user_id !== auth()->id()) {
            abort(403);
        }
        $trip->update(["is_active" => false]);

        return redirect()->route('trips.show')->with('success', 'Trajet annulé.');
    }

    public function search(Request $request)
    {
        // Extract filters
        $stopAddress = $request->input('address');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $minSeats = $request->input('min_seats');
        $active = $request->input('active'); // "1" or "0"

        // If no filters → return last 50 trips
        $noFilters =
            !$stopAddress &&
            !$dateFrom &&
            !$dateTo &&
            !$minSeats &&
            $active === null;

        if ($noFilters) {
            $trips = Trip::with(['stops', 'proposal.vehicle', 'proposal.user'])
                ->whereHas('proposal') // ensure proposal exists
                ->orderBy('id', 'desc')
                ->take(50)
                ->get();

            return view('trips.search', compact('trips'));
        }

        // Start query
        $query = Trip::query()
            ->with(['stops', 'proposal.vehicle', 'proposal.user'])
            ->whereHas('proposal'); // ensure proposal exists

        // Filter by stop address
        if ($stopAddress) {
            $query->whereHas('stops', function ($q) use ($stopAddress) {
                $q->where('address', 'LIKE', '%' . strtolower($stopAddress) . '%');
            });
        }

        // Filter by date range
        if ($dateFrom) {
            $query->whereHas('stops', function ($q) use ($dateFrom) {
                $q->whereDate('departure_time', '>=', $dateFrom);
            });
        }

        if ($dateTo) {
            $query->whereHas('stops', function ($q) use ($dateTo) {
                $q->whereDate('arrival_time', '<=', $dateTo);
            });
        }

        // Filter by minimum seats
        if ($minSeats) {
            $query->where('available_seats', '>=', $minSeats);
        }

        // Filter by active/inactive
        if ($active !== null) {
            $query->where('is_active', $active);
        }

        // Execute
        $trips = $query->get();

        return view('trips.search', compact('trips'));
    }



    public function show(Trip $trip)
    {
        $trip->load(['stops', 'proposal.vehicle', 'reservations']);
        return view('trips.show', ['trip' => $trip]);
    }
}
