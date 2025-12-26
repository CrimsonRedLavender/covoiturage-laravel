<x-app-layout :title="'Mes trajets'">

    {{-- ========================= --}}
    {{-- 1. TRIPS THE USER RESERVED --}}
    {{-- ========================= --}}

    <h2>Mes réservations</h2>

    @if ($reservations->isEmpty())
        <p>Vous n'avez réservé aucun trajet.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>Trip ID</th>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Places réservées</th>
                <th>Conducteur</th>
                <th>Véhicule</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($reservations as $reservation)
                @php
                    $trip = $reservation->trip;
                    $departure = $trip->stops->where('order', 1)->first();
                    $arrival = $trip->stops->where('order', 2)->first();
                    $proposal = $trip->proposals->first();
                @endphp

                <tr>
                    <td>{{ $trip->id }}</td>
                    <td>{{ $departure?->address }}<br>{{ $departure?->departure_time }}</td>
                    <td>{{ $arrival?->address }}<br>{{ $arrival?->arrival_time }}</td>
                    <td>{{ $reservation->seats_reserved }}</td>
                    <td>{{ $proposal->user->last_name }} {{ $proposal->user->first_name }}</td>
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



    {{-- ========================= --}}
    {{-- 2. TRIPS THE USER PROPOSED --}}
    {{-- ========================= --}}

    <h2 style="margin-top:40px;">Mes trajets proposés</h2>

    <a class="btn" href="{{ route('trips.create') }}">Proposer un trajet</a>

    @if ($proposedTrips->isEmpty())
        <p>Vous n'avez proposé aucun trajet.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>Trip ID</th>
                <th>Départ</th>
                <th>Arrivée</th>
                <th>Places</th>
                <th>Véhicule</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($proposedTrips as $trip)
                @php
                    $departure = $trip->stops->where('order', 1)->first();
                    $arrival = $trip->stops->where('order', 2)->first();
                    $proposal = $trip->proposals->first();
                @endphp

                <tr>
                    <td>{{ $trip->id }}</td>
                    <td>{{ $departure?->address }}<br>{{ $departure?->departure_time }}</td>
                    <td>{{ $arrival?->address }}<br>{{ $arrival?->arrival_time }}</td>
                    <td>{{ $trip->available_seats }}</td>
                    <td>
                        {{ $proposal->vehicle->brand }}
                        {{ $proposal->vehicle->model }}
                        ({{ $proposal->vehicle->license_plate }})
                    </td>

                    <td>
                        <a class="btn" href="{{ route('trips.edit', $trip->id) }}">Modifier</a>

                        <form action="{{ route('trips.destroy', $trip->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button class="btn-danger" onclick="return confirm('Supprimer ce trajet ?');">
                                Supprimer
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

</x-app-layout>
