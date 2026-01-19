<x-app-layout>

    <h1 class="page-title">Gestion de vos trajets</h1>

    {{-- ========================= --}}
    {{--        MES RÉSERVATIONS   --}}
    {{-- ========================= --}}
    <h2>Mes réservations</h2>

    @if ($reservations->isEmpty())
        <p>Vous n'avez réservé aucun trajet.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>Trip ID</th>
                <th>Destination finale</th>
                <th>Conducteur</th>
                <th>Véhicule</th>
                <th>Votre commentaire</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($reservations as $reservation)
                @php
                    $trip = $reservation->trip;
                    $proposal = $trip->proposal;
                    $last = $trip->stops->sortBy('order')->last();
                @endphp

                <tr>
                    <td>{{ $trip->id }}</td>

                    <td>{{ $last->address }} — {{ $last->arrival_time }}</td>

                    <td>{{ $proposal->user->last_name }} {{ $proposal->user->first_name }}</td>

                    <td>
                        {{ $proposal->vehicle->brand }}
                        {{ $proposal->vehicle->model }}
                        ({{ $proposal->vehicle->license_plate }})
                    </td>

                    <td>{{ $reservation->comment ?? 'Aucun commentaire.' }}</td>

                    <td>
                        @if($trip->is_active)
                            <span class="text-success">Actif</span>
                        @else
                            <span class="text-danger">Inactif</span>
                        @endif
                    </td>

                    <td>
                        <a class="btn" href="{{ route('trips.show', $trip) }}">Voir</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif



    {{-- ========================= --}}
    {{--     MES TRAJETS PROPOSÉS  --}}
    {{-- ========================= --}}
    <h2 style="margin-top:40px;">Mes trajets proposés</h2>

    <a class="btn" href="{{ route('trips.create') }}">Proposer un trajet</a>

    @if ($proposals->isEmpty())
        <p>Vous n'avez proposé aucun trajet.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>Trip ID</th>
                <th>Destination finale</th>
                <th>Véhicule</th>
                <th>Places disponibles</th>
                <th>Votre commentaire</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($proposals as $proposal)
                @php
                    $trip = $proposal->trip;
                    $last = $trip->stops->sortBy('order')->last();
                @endphp

                <tr>
                    <td>{{ $trip->id }}</td>

                    <td>{{ $last->address }} — {{ $last->arrival_time }}</td>
                    <td>
                        {{ $proposal->vehicle->brand }}
                        {{ $proposal->vehicle->model }}
                        ({{ $proposal->vehicle->license_plate }})
                    </td>

                    <td>{{ $trip->available_seats }}</td>

                    <td>{{ $proposal->comment ?? 'Aucun commentaire.' }}</td>

                    <td>
                        @if($trip->is_active)
                            <span class="text-success">Actif</span>
                        @else
                            <span class="text-danger">Inactif</span>
                        @endif
                    </td>

                    <td>
                        <a class="btn" href="{{ route('trips.show', $trip) }}">Voir</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif

</x-app-layout>
