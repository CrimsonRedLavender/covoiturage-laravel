<x-app-layout>
    <x-slot name="header">
        <h1 class="text-xl font-semibold">Rechercher un trajet</h1>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6">

        {{-- FORMULAIRE DE RECHERCHE --}}
        <form method="GET" action="{{ route('trips.search') }}" class="space-y-4 mb-8">

            <div>
                <label class="block font-medium">Départ</label>
                <input
                    type="text"
                    name="from"
                    value="{{ request('from') }}"
                    required
                    class="w-full border rounded p-2"
                    placeholder="Ville ou adresse de départ">
            </div>

            <div>
                <label class="block font-medium">Arrivée</label>
                <input
                    type="text"
                    name="to"
                    value="{{ request('to') }}"
                    required
                    class="w-full border rounded p-2"
                    placeholder="Ville ou adresse d’arrivée">
            </div>

            <div>
                <label class="block font-medium">Date (optionnelle)</label>
                <input
                    type="date"
                    name="date"
                    value="{{ request('date') }}"
                    class="w-full border rounded p-2">
            </div>

            <button type="submit"
                    class="bg-blue-600 text-white px-4 py-2 rounded">
                Rechercher
            </button>
        </form>

        {{-- RÉSULTATS --}}
        @isset($trips)

            <h2 class="text-lg font-semibold mb-4">
                Résultats ({{ $trips->count() }})
            </h2>

            @forelse ($trips as $trip)
                <div class="border rounded p-4 mb-4">

                    <p><strong>Conducteur :</strong> {{ $trip->proposal->user->name }}</p>
                    <p><strong>Véhicule :</strong> {{ $trip->proposal->vehicle->brand ?? '' }} {{ $trip->proposal->vehicle->model ?? '' }}</p>
                    <p><strong>Places disponibles :</strong> {{ $trip->available_seats }}</p>

                    <p class="mt-2 font-medium">Étapes :</p>
                    <ul class="list-disc list-inside">
                        @foreach ($trip->stops as $stop)
                            <li>
                                {{ $stop->address }} —
                                Départ : {{ \Carbon\Carbon::parse($stop->departure_time)->format('d/m/Y H:i') }}
                            </li>
                        @endforeach
                    </ul>

                   <a href="{{ route('trips.show', ['trip' => $trip->id]) }}">Voir le trajet</a>

                </div>
            @empty
                <p>Aucun trajet ne correspond à votre recherche.</p>
            @endforelse

        @endisset

    </div>
</x-app-layout>
