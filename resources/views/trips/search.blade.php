<x-app-layout>

    <x-slot:title>
        Rechercher un trajet
    </x-slot>

    {{-- Formulaire de recherche --}}
    <div class="card search-card">
        <h2 class="section-title">Filtres</h2>

        <form method="GET" action="{{ route('trips.search') }}" class="search-form">

            <div class="form-group">
                <label>Adresse d'arrêt :</label>
                <input type="text" name="address" value="{{ request('address') }}">
            </div>

            <div class="form-group">
                <label>Date de départ minimale :</label>
                <input type="date" name="date_from" value="{{ request('date_from') }}">
            </div>

            <div class="form-group">
                <label>Date d'arrivée maximale :</label>
                <input type="date" name="date_to" value="{{ request('date_to') }}">
            </div>

            <div class="form-group">
                <label>Places minimum :</label>
                <input type="number" name="min_seats" min="1" value="{{ request('min_seats') }}">
            </div>

            <div class="form-group">
                <label>Actif :</label>
                <select name="active">
                    <option value="">Tous</option>
                    <option value="1" @selected(request('active') === "1")>Actif</option>
                    <option value="0" @selected(request('active') === "0")>Inactif</option>
                </select>
            </div>

            <button class="btn search-btn">Rechercher</button>
        </form>
    </div>



    {{-- Résultat --}}
    <h2 class="section-title">Résultats</h2>

    @if ($trips->isEmpty())
        <p>Aucun trajet trouvé.</p>
    @else
        <table class="trip-table">
            <thead>
            <tr>
                <th>Trip ID</th>
                <th>Destination finale</th>
                <th>Conducteur</th>
                <th>Véhicule</th>
                <th>Places disponibles</th>
                <th>Nombre de passagers</th>
                <th>Status</th>
                <th>Actions</th>
            </tr>
            </thead>

            <tbody>
            @foreach ($trips as $trip)
                @php
                    $last = $trip->stops->sortBy('order')->last();
                    $proposal = $trip->proposal;
                    $nbPassengers = $trip->reservations->count();
                @endphp

                <tr>
                    <td>{{ $trip->id }}</td>

                    <td>
                        {{ $last->address }} — {{ $last->arrival_time }}
                    </td>

                    <td>{{ $proposal->user->last_name }} {{ $proposal->user->first_name }}</td>

                    <td>
                        {{ $proposal->vehicle->brand }}
                        {{ $proposal->vehicle->model }}
                        ({{ $proposal->vehicle->license_plate }})
                    </td>

                    <td>{{ $trip->available_seats }}</td>

                    <td> {{ $nbPassengers }} </td>

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
