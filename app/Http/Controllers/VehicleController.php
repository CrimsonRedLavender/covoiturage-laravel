<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;

/*
To eager load (load related models),
- use with() when you are fetching a model and want its related models
- use load() when you already have the model and want its related models
- Auth::user() is the current user's model
 */

class VehicleController extends Controller
{
    /**
     * Affiche les véhicules de l'utilisateur
     */
    public function index()
    {
        // Récupérer les véhicules de l'utilisateur
        $vehicles = Auth::user()->vehicles;

        return view('vehicles.index', ['vehicles' => $vehicles]);
    }

    /**
     * Affiche formulaire création
     */
    public function create()
    {
        return view('vehicles.create');
    }

    /**
     * Affiche formulaire modification
     */
    public function edit(Vehicle $vehicle)
    {
        return view('vehicles.edit', ['vehicle' => $vehicle]);
    }

    /**
     * Traite la création
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'seats' => 'required|integer|min:1',
            'license_plate' => 'required|string|max:255',
            'color' => 'required|string|max:255',
        ]);

        Auth::user()->vehicles()->create([
            'brand' => $request->brand,
            'model' => $request->model,
            'seats' => $request->seats,
            'license_plate' => $request->license_plate,
            'color' => $request->color,
        ]);

        return redirect()->route('vehicles.my')->with('success', 'Véhicule ajouté avec succès.');
    }

    /**
     * Traite la modification
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        Gate::authorize('manage-vehicle', $vehicle);

        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'seats' => 'required|integer|min:1|max:500',
            'license_plate' => 'required|string|max:255',
            'color' => 'required|string|max:255',
        ]);

        $vehicle->update([
            'brand' => $request->brand,
            'model' => $request->model,
            'seats' => $request->seats,
            'license_plate' => $request->license_plate,
            'color' => $request->color,
        ]);

        return redirect()->route('vehicles.my')->with('success', 'Véhicule mis à jour.');
    }

    /**
     * Traite la suppression
     */
    public function destroy(Vehicle $vehicle)
    {
        Gate::authorize('manage-vehicle', $vehicle);

        // Empeche la suppression si le véhicule est utilisé dans un trajet
        if ($vehicle->proposals()->exists()) {
            return back()->with('error', 'Ce véhicule est utilisé dans un trajet et ne peut pas être supprimé.');
        }

        $vehicle->delete();

        return redirect()->route('vehicles.my')->with('success', 'Véhicule supprimé.');
    }
}
