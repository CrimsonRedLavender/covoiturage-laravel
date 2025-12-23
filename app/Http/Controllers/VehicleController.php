<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Vehicle;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class VehicleController extends Controller
{
    /**
     * Display all vehicles of the authenticated user.
     */
    public function index(): View
    {
        $user = User::find(1);
        $vehicles = $user->vehicles;

        return view('vehicles.index', ['vehicles' => $vehicles]);
    }

    /**
     * Show the form to create a new vehicle.
     */
    public function create(): View
    {
        return view('vehicles.create');
    }

    /**
     * Store a new vehicle for the authenticated user.
     */
    public function store(Request $request)
    {
        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'seats' => 'required|integer|min:1|max:9',
        ]);

        Auth::user()->vehicles()->create([
            'brand' => $request->brand,
            'model' => $request->model,
            'seats' => $request->seats,
        ]);

        return redirect('/vehicles')->with('success', 'Vehicle added successfully');
    }

    /**
     * Display a single vehicle (only if it belongs to the user).
     */
    public function show(Vehicle $vehicle): View
    {
        $this->authorizeVehicle($vehicle);

        return view('vehicles.show', compact('vehicle'));
    }

    /**
     * Show the edit form for a vehicle.
     */
    public function edit(Vehicle $vehicle): View
    {
        $this->authorizeVehicle($vehicle);

        return view('vehicles.edit', compact('vehicle'));
    }

    /**
     * Update a vehicle.
     */
    public function update(Request $request, Vehicle $vehicle)
    {
        $this->authorizeVehicle($vehicle);

        $request->validate([
            'brand' => 'required|string|max:255',
            'model' => 'required|string|max:255',
            'seats' => 'required|integer|min:1|max:9',
        ]);

        $vehicle->update([
            'brand' => $request->brand,
            'model' => $request->model,
            'seats' => $request->seats,
        ]);

        return redirect('/vehicles')->with('success', 'Vehicle updated successfully');
    }

    /**
     * Delete a vehicle.
     */
    public function destroy(Vehicle $vehicle)
    {
        $this->authorizeVehicle($vehicle);

        $vehicle->delete();

        return redirect('/vehicles')->with('success', 'Vehicle deleted successfully');
    }

    /**
     * Helper: ensure the vehicle belongs to the authenticated user.
     */
    private function authorizeVehicle(Vehicle $vehicle)
    {
        if ($vehicle->user_id !== Auth::id()) {
            abort(403, 'Unauthorized');
        }
    }
}
