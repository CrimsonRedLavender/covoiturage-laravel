<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container">

        <h2 class="page-title">Dashboard</h2>

        <div class="card-row">

            <!-- Propositions actives -->
            <div class="card card-half card-border-success">
                <h3 class="section-title">Propositions actives</h3>
                <p class="stat-number stat-success">
                    {{ $activeProposed }}
                </p>
            </div>

            <!-- Réservations actives -->
            <div class="card card-half card-border-primary">
                <h3 class="section-title">Réservations actives</h3>
                <p class="stat-number stat-primary">
                    {{ $activeReserved }}
                </p>
            </div>

        </div>

        <div class="card-row">

            <!-- Propositions inactives -->
            <div class="card card-half card-border-danger">
                <h3 class="section-title">Propositions inactives</h3>
                <p class="stat-number stat-danger">
                    {{ $inactiveProposed }}
                </p>
            </div>

            <!-- Réservations inactives -->
            <div class="card card-half card-border-darkred">
                <h3 class="section-title">Réservations inactives</h3>
                <p class="stat-number stat-darkred">
                    {{ $inactiveReserved }}
                </p>
            </div>

        </div>

    </div>
</x-app-layout>
