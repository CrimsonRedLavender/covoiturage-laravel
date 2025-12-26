<nav>
    <div class="nav-container">
        <div class="logo">
            <a href="/">BestMeds Covoiturage</a>
        </div>

        <ul class="links">
            <li>
                <a href="{{ route('dashboard') }}"
                   class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                    Dashboard
                </a>
            </li>

            <li><a href="{{ route('vehicles.my') }}">Gérer mes véhicules</a></li>

            <li><a href="{{ route('trips.my') }}">Gérer mes trajets</a></li>

            <li><a href="{{ route('trips.create') }}">Proposer un trajet</a></li>

            <li><a href="{{ route('trips.search') }}">Rechercher un trajet</a></li>

            <li>
                <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                    @csrf
                    <a href="{{ route('logout') }}"
                       onclick="event.preventDefault(); this.closest('form').submit();"
                       style="cursor: pointer;">
                        Déconnexion
                    </a>
                </form>
            </li>

            <li><a href="{{ route('profile.edit') }}">Mon profil</a></li>
        </ul>
    </div>
</nav>
