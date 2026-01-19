<x-guest-layout>

    {{-- Session Status --}}
    <x-auth-session-status :status="session('status')" />

    <form method="POST" action="{{ route('login') }}">
        @csrf

        {{-- Email --}}
        <div class="form-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                type="email"
                name="email"
                :value="old('email')"
                required
                autofocus
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        {{-- Password --}}
        <div class="form-group">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="current-password"
            />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        {{-- Remember Me --}}
        <div class="remember-row">
            <input id="remember_me" type="checkbox" name="remember">
            <label for="remember_me">Se souvenir de moi</label>
        </div>

        {{-- Submit --}}
        <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
            <button class="btn btn-primary">Se connecter</button>

            <a href="{{ route('register') }}" class="btn btn-outline">
                {{ __('Créer un compte') }}
            </a>
        </div>

    </form>

</x-guest-layout>
