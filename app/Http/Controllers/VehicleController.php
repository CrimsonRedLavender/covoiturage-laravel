<?php

namespace App\Http\Controllers;

use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VehicleController extends Controller
{
    public function index()
    {
        $vehicles = Auth::user()->vehicles;
        return view('vehicles.index', ['vehicles' => $vehicles]);
    }

    public function create()
    {
        return view('vehicles.create');
    }

    public function edit(Vehicle $vehicle)
    {
        if ($vehicle->user_id !== Auth::id()) abort(403);
        return view('vehicles.edit', ['vehicle' => $vehicle]);
    }

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

    public function update(Request $request, Vehicle $vehicle)
    {
        if ($vehicle->user_id !== Auth::id()) abort(403);

        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'seats' => 'required|integer|min:1',
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


    public function destroy(Vehicle $vehicle)
    {
        if ($vehicle->user_id !== Auth::id()) abort(403);
        $vehicle->delete();
        return redirect()->route('vehicles.my')->with('success', 'Véhicule supprimé.');
    }
}
