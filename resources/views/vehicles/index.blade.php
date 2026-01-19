<x-app-layout>

    <a class="btn" href="{{ route('vehicles.create') }}">Ajouter un véhicule</a>

    <table>
        <thead>
        <tr>
            <th>Marque</th>
            <th>Modèle</th>
            <th>Places</th>
            <th>Couleur</th>
            <th>Immatriculation</th>
            <th>Actions</th>
        </tr>
        </thead>

        <tbody>
        @foreach ($vehicles as $vehicle)
            <tr>
                <td>{{ $vehicle->brand }}</td>
                <td>{{ $vehicle->model }}</td>
                <td>{{ $vehicle->seats }}</td>
                <td>{{ $vehicle->color }}</td>
                <td>{{ $vehicle->license_plate }}</td>

                <td>
                    <!-- Modify button -->
                    <a class="btn" href="{{ route('vehicles.edit', $vehicle->id) }}">
                        Modifier
                    </a>

                    <!-- Delete button -->
                    <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" onclick="return confirm('Supprimer ce véhicule ?');">
                            Supprimer
                        </button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

</x-app-layout>
