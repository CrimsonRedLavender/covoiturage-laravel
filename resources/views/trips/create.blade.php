<x-layouts.app :title="'Proposer un trajet'">


    A AMELIORER

    <form action="{{ route('trips.store') }}" method="POST">
        @csrf

        <div class="form-row">
            <div>
                <label>Adresse de départ</label>
                <input type="text" name="departure_address" required>
            </div>

            <div>
                <label>Heure de départ</label>
                <input type="datetime-local" name="departure_time" required>
            </div>
        </div>

        <div class="form-row">
            <div>
                <label>Adresse d'arrivée</label>
                <input type="text" name="arrival_address" required>
            </div>

            <div>
                <label>Heure d'arrivée</label>
                <input type="datetime-local" name="arrival_time" required>
            </div>
        </div>

        <label>Places disponibles</label>
        <input type="number" name="available_seats" min="1" required>

        <label>Véhicule utilisé</label>
        <select name="vehicle_id" required>
            @foreach ($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}">
                    {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->license_plate }})
                </option>
            @endforeach
        </select>

        <button type="submit">Créer le trajet</button>
    </form>

</x-layouts.app>
