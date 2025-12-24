<x-app-layout>

    <x-slot name="header">
        <h1>Gérer mes véhicules</h1>
    </x-slot>

    <form action="{{ route('vehicles.create') }}" method="GET">
        <button type="submit">Créer un véhicule</button>
    </form>

    <br><br>

    <h2>Liste de vos véhicules</h2>

    @if ($vehicles->isEmpty())
        <p><strong>Vous n'avez aucun véhicule</strong></p>
    @else

        <style>
            table {
                border-collapse: collapse;
                margin-top: 10px;
            }
            th, td {
                padding: 8px 12px;
                border: 1px solid lightgrey;
                text-align: center;
            }
            th {
                background-color: #f2f2f2;
            }
        </style>

        <table>
            <tr>
                <th>Marque</th>
                <th>Modèle</th>
                <th>Places</th>
                <th>Immatriculation</th>
                <th>Couleur</th>
                <th>Actions</th>
            </tr>

            @foreach ($vehicles as $vehicle)
                <tr>
                    <td>{{ $vehicle->brand }}</td>
                    <td>{{ $vehicle->model }}</td>
                    <td>{{ $vehicle->seats }}</td>
                    <td>{{ $vehicle->license_plate }}</td>
                    <td>{{ $vehicle->color }}</td>

                    <td>
                        <form action="{{ route('vehicles.edit', $vehicle->id) }}" method="GET" style="display:inline;">
                            <button type="submit">Modifier</button>
                        </form>

                        <form action="{{ route('vehicles.destroy', $vehicle->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </table>

    @endif

</x-app-layout>
