<x-app-layout :title="'Mes trajets'">

    A AMERLIORER

    @if ($trips->isEmpty())
        <p>Vous n'avez proposé aucun trajet.</p>
        <a class="btn" href="{{ route('trips.create') }}">Proposer un trajet</a>
    @else
        <table>
            <thead>
            <tr>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Places</th>
                <th>Véhicule</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($trips as $trip)
                @php
                    $departure = $trip->stops->where('order', 1)->first();
                    $arrival = $trip->stops->where('order', 2)->first();
                    $proposal = $trip->proposals->first();
                @endphp

                <tr>
                    <td>{{ $departure?->address }}<br>{{ $departure?->departure_time }}</td>
                    <td>{{ $arrival?->address }}<br>{{ $arrival?->arrival_time }}</td>
                    <td>{{ $trip->available_seats }}</td>
                    <td>
                        {{ $proposal->vehicle->brand }}
                        {{ $proposal->vehicle->model }}
                        ({{ $proposal->vehicle->license_plate }})
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

</x-app-layout>
