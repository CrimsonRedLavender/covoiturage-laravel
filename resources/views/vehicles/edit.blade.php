<x-app-layout>

    <x-slot:title>
        Modifier un véhicule
    </x-slot>

    <form action="{{ route('vehicles.update', $vehicle->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Marque</label><br>
        <input type="text" name="brand" value="{{ $vehicle->brand }}" required><br><br>

        <label>Modèle</label><br>
        <input type="text" name="model" value="{{ $vehicle->model }}" required><br><br>

        <label>Nombre de places</label><br>
        <input type="number" name="seats" value="{{ $vehicle->seats }}" required><br><br>

        <label>Immatriculation</label><br>
        <input type="text" name="license_plate" value="{{ $vehicle->license_plate }}" required><br><br>

        <label>Couleur</label><br>
        <input type="text" name="color" value="{{ $vehicle->color }}" required><br><br>

        <button type="submit">Mettre à jour</button>
    </form>

    <br>
    <a href="{{ route('vehicles.my') }}">Retour</a>

</x-app-layout>
