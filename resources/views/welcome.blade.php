<x-guest-layout>
    <main class="welcome-hero">
        <h1>BestMeds Covoiturage</h1>
        <p>La plateforme interne pour simplifier vos déplacements professionnels.</p>

        @guest
            <div class="cta-buttons">
                <a href="{{ route('login') }}" class="btn btn-primary">Se connecter</a>

                @if (Route::has('register'))
                    <a href="{{ route('register') }}" class="btn btn-outline">Créer un compte</a>
                @endif
            </div>
        @endguest

        @auth
            <div class="cta-buttons">
                <a href="{{ url('/dashboard') }}" class="btn btn-primary">Accéder au tableau de bord</a>
            </div>
        @endauth
    </main>
</x-guest-layout>
