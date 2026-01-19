<x-app-layout>
    <x-slot name="header"></x-slot>

    <div class="container">

        <h2 class="page-title">Dashboard</h2>

        <div class="card-row">

            <!-- Active Proposed Trips -->
            <div class="card card-half" style="border-left: 6px solid #198754;">
                <h3 class="section-title">Trajets proposés actifs</h3>
                <p style="font-size: 2rem; font-weight: bold; color: #198754;">
                    {{ $activeProposed }}
                </p>
            </div>

            <!-- Active Reservations -->
            <div class="card card-half" style="border-left: 6px solid #004aad;">
                <h3 class="section-title">Réservations actives</h3>
                <p style="font-size: 2rem; font-weight: bold; color: #004aad;">
                    {{ $activeReserved }}
                </p>
            </div>

        </div>

        <div class="card-row">

            <!-- Inactive Proposed Trips -->
            <div class="card card-half" style="border-left: 6px solid #dc3545;">
                <h3 class="section-title">Trajets proposés inactifs</h3>
                <p style="font-size: 2rem; font-weight: bold; color: #dc3545;">
                    {{ $inactiveProposed }}
                </p>
            </div>

            <!-- Inactive Reservations -->
            <div class="card card-half" style="border-left: 6px solid #8e1c1c;">
                <h3 class="section-title">Réservations inactives</h3>
                <p style="font-size: 2rem; font-weight: bold; color: #8e1c1c;">
                    {{ $inactiveReserved }}
                </p>
            </div>

        </div>

    </div>
</x-app-layout>
