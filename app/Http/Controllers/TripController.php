<?php

namespace App\Http\Controllers;

use App\Models\Trip;
use App\Models\Stop;
use App\Models\Proposal;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;


class TripController extends Controller
{
    /**
     * Affiche les trajets de l'utilisateur
     */
    public function index()
    {
        $user = Auth::user();

        $reservations = $user->reservations()->with(['trip.stops', 'trip.proposal.vehicle'])->get();
        $proposals = $user->proposals()->with(['trip.stops', 'trip.proposal.vehicle'])->get();

        return view('trips.index', ['reservations' => $reservations, 'proposals' => $proposals]);
    }

    /**
     * Affiche le formulaire de proposition d'un trajet
     */
    public function create()
    {
        $vehicles = Auth::user()->vehicles;

        return view('trips.create', ['vehicles' => $vehicles]);
    }

    /**
     * Traite le formulaire de proposition d'un trajet
     */
    public function store(Request $request)
    {
        // Récupérer le véhicule du trajet pour valider le nombre de places max
        $vehicle = Vehicle::findOrFail($request->vehicle_id);
        $maxSeats = $vehicle->seats - 1;

        $validated = $request->validate([
            'vehicle_id' => 'required|exists:vehicles,id', // exists vérifie si l'id existe dans la table véhicule
            'available_seats' => "required|integer|min:1|max:{$maxSeats}",
            'comment' => 'nullable|string|max:200',
            'stops' => 'required|array|min:1|max:10',
            'stops.*.address' => 'required|string|max:255', // * sélectionne tous les éléments de la collection
            'stops.*.departure_time' => 'required|date',
            'stops.*.arrival_time' => 'required|date|after_or_equal:stops.*.departure_time',
        ]);

        // Validation manuelle des horaires des étapes (qui doivent être après l'étape précédente)

        $previousArrival = null;

        // Chaque stop a son $index dans le tableau et sa valeur $stop
        foreach ($validated['stops'] as $index => $stop) {
            $currentDeparture = strtotime($stop['departure_time']);

            // Envoie erreur si le départ de l'étape est avant l'arrivée de la précédente
            if ($previousArrival !== null && $currentDeparture < $previousArrival) {
                return back()
                    ->withErrors([
                        "stops.$index.departure_time" =>
                            "L'horaire de départ de cette étape doit être après l'arrivée du précédent."
                    ])
                    ->withInput(); // restore les données du formulaire
            }

            $previousArrival = strtotime($stop['arrival_time']);
        }

        $trip = Trip::create([
            'available_seats' => $validated['available_seats'],
        ]);

        $proposal = Proposal::create([
            'trip_id' => $trip->id,
            'vehicle_id' => $validated['vehicle_id'],
            'user_id' => auth()->id(),
            'comment' => $validated['comment'] ?? null,
        ]);

        foreach ($validated['stops'] as $index => $stopData) {
            Stop::create([
                'trip_id' => $trip->id,
                'order' => $index + 1, // ordre de l'étape en fonction de la position dans le tableau
                'address' => $stopData['address'],
                'departure_time' => $stopData['departure_time'],
                'arrival_time' => $stopData['arrival_time'],
            ]);
        }

        return redirect()
            ->route('trips.my')
            ->with('success', 'Trajet créé.');
    }

    /**
     * Annule un trajet (pas de suppression !!!)
     */
    public function cancel(Trip $trip)
    {
        // Seul le proposeur peut annuler le trajet
        Gate::authorize('cancel-trip', $trip);

        $trip->update(["is_active" => false]);

        return redirect()->route('trips.show', $trip)->with('success', 'Trajet annulé.');
    }

    /**
     * affiche et traite la recherche de trajet
     */
    public function search(Request $request)
    {
        // Récupérer les données de recherche
        $stopAddress = $request->input('address');
        $dateFrom = $request->input('date_from');
        $dateTo = $request->input('date_to');
        $minSeats = $request->input('min_seats');
        $active = $request->input('active'); // string "1" ou "0", null sinon

        // Check si il y a des données de recherche
        $noFilters =
            !$stopAddress &&
            !$dateFrom &&
            !$dateTo &&
            !$minSeats &&
            $active === null; // !$active renvoie true si $active = "0"

        // Renvoie les 50 derniers trajets si le formulaire de recherche est vide
        if ($noFilters) {
            $trips = Trip::with(['stops', 'proposal.vehicle', 'proposal.user'])
                ->whereHas('proposal') // vérifie que le trajet a une proposition
                ->orderBy('id', 'desc')
                ->take(50)
                ->get();

            return view('trips.search', compact('trips'));
        }

        // Créé la query pour chercher les étapes correspondants à la rechercheS
        $query = Trip::query()
            ->with(['stops', 'proposal.vehicle', 'proposal.user', 'reservations.user'])
            ->whereHas('proposal');

        // Adresse de l'étape
        if ($stopAddress) {
            $query->whereHas('stops', function ($q) use ($stopAddress) {
                $q->where('address', 'LIKE', '%' . strtolower($stopAddress) . '%');
            });
        }

        // Date (borne inférieure)
        if ($dateFrom) {
            $query->whereHas('stops', function ($q) use ($dateFrom) {
                $q->whereDate('departure_time', '>=', $dateFrom);
            });
        }

        // Date (borne supérieure)
        if ($dateTo) {
            $query->whereHas('stops', function ($q) use ($dateTo) {
                $q->whereDate('arrival_time', '<=', $dateTo);
            });
        }

        // Nombre de sièges dispos minimum
        if ($minSeats) {
            $query->where('available_seats', '>=', $minSeats);
        }

        // Le trajet est actif/inactif
        if ($active !== null) {
            $query->where('is_active', $active);
        }

        // Exécuter la query
        $trips = $query->get();

        return view('trips.search', ['trips' => $trips]);
    }

    /**
     * Affiche les détails d'un seul trajet
     */
    public function show(Trip $trip)
    {
        $trip->load(['stops', 'proposal.vehicle', 'reservations']);
        return view('trips.show', ['trip' => $trip]);
    }
}
