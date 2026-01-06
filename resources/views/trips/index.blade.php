<x-app-layout>

    <h2>Mes réservations</h2>

    @if ($reservations->isEmpty())
        <p>Vous n'avez réservé aucun trajet.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>Trip ID</th>
                <th>Étapes</th>
                <th>Conducteur</th>
                <th>Véhicule</th>
                <th>Commentaire</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($reservations as $reservation)
                @php
                    $trip = $reservation->trip;
                    $proposal = $trip->proposal;
                    $stops = $trip->stops->sortBy('order');
                    $first = $stops->first();
                    $last = $stops->last();
                @endphp

                <tr>
                    <td>{{ $trip->id }}</td>

                    <td>
                        @if ($stops->count() === 1)
                            <div>
                                <strong>Une seule étape :</strong><br>
                                {{ $first->address }} — {{ $first->departure_time }}
                            </div>
                        @else
                            <div>
                                <strong>Départ :</strong><br>
                                {{ $first->address }} — {{ $first->departure_time }}
                            </div>

                            <div style="margin-top:6px;">
                                <strong>Arrivée :</strong><br>
                                {{ $last->address }} — {{ $last->departure_time }}
                            </div>
                        @endif
                    </td>

                    <td>{{ $proposal->user->last_name }} {{ $proposal->user->first_name }}</td>

                    <td>
                        {{ $proposal->vehicle->brand }}
                        {{ $proposal->vehicle->model }}
                        ({{ $proposal->vehicle->license_plate }})
                    </td>

                    <td>{{ $reservation->comment ?? '—' }}</td>

                    <td>
                        <a class="btn" href="">Voir</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif





    <h2 style="margin-top:40px;">Mes trajets proposés</h2>

    <a class="btn" href="{{ route('trips.create') }}">Proposer un trajet</a>

    @if ($proposals->isEmpty())
        <p>Vous n'avez proposé aucun trajet.</p>
    @else
        <table>
            <thead>
            <tr>
                <th>Trip ID</th>
                <th>Étapes</th>
                <th>Commentaire</th>
                <th>Places</th>
                <th>Véhicule</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($proposals as $proposal)
                @php
                    $trip = $proposal->trip;
                    $stops = $trip->stops->sortBy('order');
                    $first = $stops->first();
                    $last = $stops->last();
                @endphp

                <tr>
                    <td>{{ $trip->id }}</td>

                    <td>
                        @if ($stops->count() === 1)
                            <div>
                                <strong>Une seule étape :</strong><br>
                                {{ $first->address }} — {{ $first->departure_time }}
                            </div>
                        @else
                            <div>
                                <strong>Départ :</strong><br>
                                {{ $first->address }} — {{ $first->departure_time }}
                            </div>

                            <div style="margin-top:6px;">
                                <strong>Arrivée :</strong><br>
                                {{ $last->address }} — {{ $last->departure_time }}
                            </div>
                        @endif
                    </td>

                    <td>{{ $proposal->comment ?? '—' }}</td>

                    <td>{{ $trip->available_seats }}</td>

                    <td>
                        {{ $proposal->vehicle->brand }}
                        {{ $proposal->vehicle->model }}
                        ({{ $proposal->vehicle->license_plate }})
                    </td>

                    <td>
                        @if($trip->is_active)
                            <span class="text-success">Actif</span>
                        @else
                            <span class="text-danger">Inactif</span>
                        @endif
                    </td>

                    <td>
                        <a class="btn" href="">Voir</a>

                        <form action="{{ route('trips.deactivate', $trip) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('PATCH')
                            <button class="btn-danger"
                                    onclick="return confirm('Voulez-vous vraiment annuler ce trajet ?');">
                                Annuler
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    @endif


</x-app-layout>
