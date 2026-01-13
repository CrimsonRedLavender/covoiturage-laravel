<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h1 class="text-xl font-semibold">Trajet #{{ $trip->id }}</h1>

            <a href="{{ route('trips.search') }}"
               class="text-sm text-blue-700 hover:underline">
                ← Retour à la recherche
            </a>
        </div>
    </x-slot>

    <div class="max-w-4xl mx-auto p-6 space-y-6">

        {{-- Carte résumé --}}
        <div class="bg-white rounded-lg shadow p-5 border">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <div class="text-sm text-gray-500">Places disponibles</div>
                    <div class="text-2xl font-bold">{{ $trip->available_seats }}</div>
                </div>

                <div>
                    <div class="text-sm text-gray-500">Statut</div>
                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-sm font-medium
                        {{ $trip->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-700' }}">
                        {{ $trip->is_active ? 'Actif' : 'Inactif' }}
                    </span>
                </div>

                <div>
                    <div class="text-sm text-gray-500">Conducteur</div>
                    <div class="font-semibold">
                        {{ optional($trip->proposal?->user)->name ?? '—' }}
                    </div>
                    <div class="text-sm text-gray-500 mt-1">Véhicule</div>
                    <div class="text-sm">
                        {{ optional($trip->proposal?->vehicle)->brand ?? '' }}
                        {{ optional($trip->proposal?->vehicle)->model ?? '—' }}
                    </div>
                </div>
            </div>
        </div>

        {{-- Étapes --}}
        <div class="bg-white rounded-lg shadow p-5 border">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-semibold">Étapes</h2>
                <span class="text-sm text-gray-500">
                    {{ $trip->stops->count() }} étape(s)
                </span>
            </div>

            @php
                $stops = $trip->stops->sortBy('order');
            @endphp

            @forelse($stops as $stop)
                <div class="flex items-start gap-4 py-4 border-t first:border-t-0">
                    <div class="mt-1">
                        <div class="w-3 h-3 rounded-full bg-blue-600"></div>
                    </div>

                    <div class="flex-1">
                        <div class="font-semibold text-gray-900">
                            {{ $stop->address }}
                        </div>

                        <div class="text-sm text-gray-600 mt-1">
                            Départ :
                            {{ \Carbon\Carbon::parse($stop->departure_time)->format('d/m/Y H:i') }}
                        </div>
                    </div>

                    <div class="text-xs text-gray-500">
                        #{{ $stop->order ?? '—' }}
                    </div>
                </div>
            @empty
                <div class="text-gray-600">Aucune étape</div>
            @endforelse
        </div>

    </div>
</x-app-layout>
