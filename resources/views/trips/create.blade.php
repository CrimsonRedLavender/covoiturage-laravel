<x-app-layout>

    <x-slot name="header">
        <h1>Proposer un trajet</h1>
    </x-slot>

    <h2>Créer un nouveau trajet</h2>

    <form action="{{ route('trips.store') }}" method="POST">
        @csrf

        <label>Nombre de places disponibles</label><br>
        <input type="number" name="available_seats" required><br><br>

        <label>Véhicule utilisé</label><br>
        <select name="vehicle_id" required>
            @foreach ($vehicles as $vehicle)
                <option value="{{ $vehicle->id }}">
                    {{ $vehicle->brand }} {{ $vehicle->model }} ({{ $vehicle->license_plate }})
                </option>
            @endforeach
        </select><br><br>

        <h3>Départ</h3>

        <label>Adresse de départ</label><br>
        <input type="text" name="departure_address" required><br><br>

        <label>Heure de départ</label><br>
        <input type="datetime-local" name="departure_time" required><br><br>

        <h3>Arrivée</h3>

        <label>Adresse d'arrivée</label><br>
        <input type="text" name="arrival_address" required><br><br>

        <label>Heure d'arrivée</label><br>
        <input type="datetime-local" name="arrival_time" required><br><br>

        <label>Commentaire (optionnel)</label><br>
        <textarea name="comment" rows="3"></textarea><br><br>

        <button type="submit">Créer le trajet</button>
    </form>

    <br>
    <a href="{{ route('trips.my') }}">Retour</a>

</x-app-layout>
