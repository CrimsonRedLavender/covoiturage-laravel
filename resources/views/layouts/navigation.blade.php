<nav>
    <div class="logo">
        <a href="/">
            <img src="{{ Vite::asset('resources/images/logo_bm.png') }}"
                 alt="BestMeds Covoiturage"
                 height="60">
        </a>
    </div>

    <div class="nav-container">
        <ul class="links">

            @auth
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        Tableau de bord
                    </a>
                </li>

                <li>
                    <a href="{{ route('vehicles.my') }}"
                       class="{{ request()->routeIs('vehicles.*') ? 'active' : '' }}">
                        Gérer mes véhicules
                    </a>
                </li>

                <li>
                    <a href="{{ route('trips.my') }}"
                       class="{{ request()->routeIs('trips.*') ? 'active' : '' }}">
                        Gérer mes trajets
                    </a>
                </li>

                <li>
                    <a href="{{ route('trips.create') }}"
                       class="{{ request()->routeIs('trips.create') ? 'active' : '' }}">
                        Proposer un trajet
                    </a>
                </li>

                <li>
                    <a href="{{ route('trips.search') }}"
                       class="{{ request()->routeIs('trips.search') ? 'active' : '' }}">
                        Rechercher un trajet
                    </a>
                </li>

                <li>
                    <a href="{{ route('profile.edit') }}"
                       class="{{ request()->routeIs('profile.*') ? 'active' : '' }}">
                        Mon profil
                    </a>
                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}" style="display:inline;">
                        @csrf
                        <a href="{{ route('logout') }}"
                           onclick="event.preventDefault(); this.closest('form').submit();">
                            Déconnexion
                        </a>
                    </form>
                </li>

            @else
                <li><a href="{{ route('login') }}" class="{{ request()->routeIs('login') ? 'active' : '' }}">Se connecter</a></li>

                @if (Route::has('register'))
                    <li><a href="{{ route('register') }}" class="{{ request()->routeIs('register') ? 'active' : '' }}">Créer un compte</a></li>
                @endif
            @endauth

        </ul>
    </div>
</nav>
