<x-app-layout>

    <x-slot:title>
        Détails d'un trajet
    </x-slot>



    <div class="card-row">

        {{-- Résumé --}}
        <div class="card card-half">
            <h2 class="section-title">Résumé du trajet</h2>

            <p>
                <strong>Status :</strong>
                @if ($trip->is_active)
                    <span class="text-success">Actif</span>
                @else
                    <span class="text-danger">Inactif</span>
                @endif
            </p>

            <p><strong>Places disponibles :</strong> {{ $trip->available_seats }}</p>
        </div>

        {{-- Actions --}}
        <div class="card card-half">
            <h2 class="section-title">Actions</h2>

            @php
                $user = auth()->user();
                $userReservation = $trip->reservations->firstWhere('user_id', $user?->id);
                $isDriver = $user && $user->id === $trip->proposal->user_id;
            @endphp

            {{-- Trajet inactif : aucunes actions --}}
            @if (!$trip->is_active)
                <p class="text-danger"><strong>Indisponible : le trajet est inactif.</strong></p>

            @else
                {{-- Proposeur : annuler le trajet --}}
                @can('cancel-trip', $trip)
                    <form action="{{ route('trips.cancel', $trip) }}" method="POST">
                        @csrf
                        @method('PATCH')
                        <button class="btn btn-danger" style="width: 100%;">Annuler le trajet</button>
                    </form>
                @endcan

                {{-- Réserveur : se désinscrire --}}
                @can('unsubscribe-trip', $trip)
                    <form action="{{ route('reservations.destroy', $userReservation) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-danger" style="width: 100%;">Se désinscrire</button>
                    </form>
                @endcan

                {{-- Réserveur : s'inscrire --}}
                @can('subscribe-trip', $trip)
                <form action="{{ route('reservations.store') }}" method="POST">
                    @csrf
                    <input type="hidden" name="trip_id" value="{{ $trip->id }}">
                    <label for="comment">Commentaire (optionnel)</label> <textarea name="comment" id="comment"
                                                                                   class="input-textarea"></textarea>
                    <button class="btn" style="width: 100%;">S'inscrire</button>
                </form>
                @endcan
            @endif

        </div>


    </div>


    {{-- Véhicule et Conducteur --}}
    <div class="card-row">

        <div class="card card-half">
            <h2 class="section-title">Véhicule</h2>

            <p><strong>Marque :</strong> {{ $trip->proposal->vehicle->brand }}</p>
            <p><strong>Modèle :</strong> {{ $trip->proposal->vehicle->model }}</p>
            <p><strong>Couleur :</strong> {{ $trip->proposal->vehicle->color }}</p>
            <p><strong>Immatriculation :</strong> {{ $trip->proposal->vehicle->license_plate }}</p>
            <p><strong>Places :</strong> {{ $trip->proposal->vehicle->seats }}</p>
        </div>

        <div class="card card-half">
            <h2 class="section-title">Conducteur</h2>

            <p><strong>Nom :</strong> {{ $trip->proposal->user->last_name }} {{ $trip->proposal->user->first_name }}</p>

            <p><strong>Commentaire :</strong> {{ $trip->proposal->comment ?? 'Aucun commentaire.' }}</p>

            <p><strong>Email :</strong> {{ $trip->proposal->user->email }}</p>

            <p><strong>Téléphone :</strong> {{ $trip->proposal->user->mobile }}</p>

        </div>

    </div>


    {{-- Etapes --}}
    <div class="card">
        <h2 class="section-title">Étapes du trajet</h2>

        <div class="timeline">
            @foreach ($trip->stops->sortBy('order') as $stop)
                <div class="timeline-item">
                    <strong>Étape {{ $stop->order }}</strong><br>
                    {{ $stop->address }}<br>
                    <small>Départ : {{ $stop->departure_time }}</small><br>
                    <small>Arrivée : {{ $stop->arrival_time }}</small>
                </div>
            @endforeach
        </div>
    </div>


    {{-- La réservation de l'utilisateur --}}
    @if ($userReservation)
        <div class="card">
            <h2 class="section-title">Votre réservation</h2>

            @if ($userReservation->comment)
                <p><strong>Votre commentaire :</strong> {{ $userReservation->comment }}</p>
            @else
                <p>Aucun commentaire.</p>
            @endif
        </div>
    @endif



    {{-- Passagers --}}
    <div class="card">
        <h2 class="section-title">Passagers</h2>

        @forelse ($trip->reservations as $reservation)
            <div class="passenger">
                <strong>{{ $reservation->user->last_name }} {{ $reservation->user->first_name }}</strong><br>
                @if ($reservation->comment)
                    <small>Commentaire : {{ $reservation->comment }}</small>
                @else
                    <small>Aucun commentaire.</small>
                @endif
            </div>
        @empty
            <p>Aucun passager pour le moment.</p>
        @endforelse
    </div>

</x-app-layout>
