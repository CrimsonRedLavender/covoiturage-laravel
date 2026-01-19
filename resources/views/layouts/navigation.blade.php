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
                <li><a href="{{ route('dashboard') }}" class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">Tableau de bord</a></li>
                <li><a href="{{ route('vehicles.my') }}">Gérer mes véhicules</a></li>
                <li><a href="{{ route('trips.my') }}">Gérer mes trajets</a></li>
                <li><a href="{{ route('trips.create') }}">Proposer un trajet</a></li>
                <li><a href="{{ route('trips.search') }}">Rechercher un trajet</a></li>
                <li><a href="{{ route('profile.edit') }}">Mon profil</a></li>

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
                <li><a href="{{ route('login') }}">Se connecter</a></li>

                @if (Route::has('register'))
                    <li><a href="{{ route('register') }}">Créer un compte</a></li>
                @endif
            @endauth

        </ul>
    </div>
</nav>
