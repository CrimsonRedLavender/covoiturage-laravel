<nav>
    <div>
        <nav>
            <ul>
                <li>
                    <a href="{{ route('dashboard') }}"
                       class="{{ request()->routeIs('dashboard') ? 'active' : '' }}">
                        {{ __('Dashboard') }}
                    </a>
                </li>

                <li><a href="{{ route('vehicles.my') }}">Gérer mes véhicules</a></li>

                <li><a href="{{ route('trips.my') }}">Gérer mes trajets</a></li>

                <li><a href="{{ route('trips.create') }}">Proposer un trajet</a></li>

                <li><a href="{{ route('trips.search') }}">Rechercher un trajet</a></li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();" style="cursor: pointer;">
                            Log Out
                        </a>
                    </form>
                </li>

                <li><a href="{{ route('profile.edit') }}">Mon profil</a></li>
            </ul>
        </nav>
    </div>
</nav>
