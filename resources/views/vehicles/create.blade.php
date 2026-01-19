<x-app-layout>

    <x-slot:title>
        Ajouter un véhicule
    </x-slot>

    <form action="{{ route('vehicles.store') }}" method="POST">
        @csrf

        <label>Marque</label><br>
        <input type="text" name="brand" required><br><br>

        <label>Modèle</label><br>
        <input type="text" name="model" required><br><br>

        <label>Nombre de places (y compris conducteur)</label><br>
        <input type="number" name="seats" required><br><br>

        <label>Immatriculation</label><br>
        <input type="text" name="license_plate" required><br><br>

        <label>Couleur</label><br>
        <input type="text" name="color" required><br><br>

        <button type="submit">Enregistrer</button>
    </form>

    <br>
    <a href="{{ route('vehicles.my') }}">Retour</a>

</x-app-layout>
