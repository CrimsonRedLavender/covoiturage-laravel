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

    public function deactivate(Trip $trip)
    {
        if ($trip->proposal->user_id !== auth()->id()) { abort(403); }
        $trip->update(["is_active" => false]);

        return redirect()->route('trips.my')->with('success', 'Trajet annulé.');
    }

    public function search(Request $request)
    {
        // 1. Si aucun critère → afficher seulement le formulaire
        if (!$request->hasAny(['from', 'to', 'date'])) {
            return view('trips.search');
        }

        // 2. Validation uniquement après soumission
        if ($request->hasAny(['from', 'to'])) {
            $request->validate([
                'from' => 'required|string|max:255',
                'to'   => 'required|string|max:255',
                'date' => 'nullable|date',
            ]);
        }

        // 3. Requête de recherche
        $query = Trip::query()
            ->where('is_active', true)
            ->where('available_seats', '>', 0)
            ->whereHas('stops', function ($q) use ($request) {
                // Recherche dans les arrêts correspondants aux adresses de départ et d'arrivée en insensible à la casse
                if ($request->has('from')) {
                    $q->whereRaw('LOWER(address) LIKE ?', ['%' . strtolower($request->from) . '%']); // Recherche insensible à la casse pour départ
                }
                if ($request->has('to')) {
                    $q->orWhereRaw('LOWER(address) LIKE ?', ['%' . strtolower($request->to) . '%']); // Recherche insensible à la casse pour arrivée
                }
            })
            ->with(['stops', 'proposal.vehicle', 'proposal.user']);

        // Filtrer par date si renseignée
        if ($request->filled('date')) {
            $query->whereHas('stops', function ($q) use ($request) {
                $q->whereDate('departure_time', $request->date);
            });
        }

        // Récupérer les résultats
        $trips = $query->get();

        return view('trips.search', [
            'trips' => $trips,
        ]);
    }
public function show(Trip $trip)
{
    $trip->load(['stops', 'proposal.vehicle', 'proposal.user']);

    return view('trips.show', compact('trip'));
}
}
