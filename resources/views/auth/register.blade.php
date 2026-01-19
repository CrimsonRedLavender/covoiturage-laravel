<x-guest-layout>
    <form method="POST" action="{{ route('register') }}">
        @csrf

        {{-- Last Name --}}
        <div class="form-group">
            <x-input-label for="last_name" :value="__('Nom')" />
            <x-text-input
                id="last_name"
                type="text"
                name="last_name"
                :value="old('last_name')"
                required
                autofocus
                autocomplete="family-name"
            />
            <x-input-error :messages="$errors->get('last_name')" />
        </div>

        {{-- First Name --}}
        <div class="form-group">
            <x-input-label for="first_name" :value="__('Prénom')" />
            <x-text-input
                id="first_name"
                type="text"
                name="first_name"
                :value="old('first_name')"
                required
                autocomplete="given-name"
            />
            <x-input-error :messages="$errors->get('first_name')" />
        </div>

        {{-- Email --}}
        <div class="form-group">
            <x-input-label for="email" :value="__('Email')" />
            <x-text-input
                id="email"
                type="email"
                name="email"
                :value="old('email')"
                required
                autocomplete="username"
            />
            <x-input-error :messages="$errors->get('email')" />
        </div>

        {{-- Mobile --}}
        <div class="form-group">
            <x-input-label for="mobile" :value="__('Téléphone')" />
            <x-text-input
                id="mobile"
                type="text"
                name="mobile"
                :value="old('mobile')"
                required
                autocomplete="tel"
            />
            <x-input-error :messages="$errors->get('mobile')" />
        </div>

        {{-- Address --}}
        <div class="form-group">
            <x-input-label for="address" :value="__('Adresse')" />
            <x-text-input
                id="address"
                type="text"
                name="address"
                :value="old('address')"
                required
                autocomplete="street-address"
            />
            <x-input-error :messages="$errors->get('address')" />
        </div>

        {{-- Password --}}
        <div class="form-group">
            <x-input-label for="password" :value="__('Mot de passe')" />
            <x-text-input
                id="password"
                type="password"
                name="password"
                required
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password')" />
        </div>

        {{-- Confirm Password --}}
        <div class="form-group">
            <x-input-label for="password_confirmation" :value="__('Confirmer votre mot de passe')" />
            <x-text-input
                id="password_confirmation"
                type="password"
                name="password_confirmation"
                required
                autocomplete="new-password"
            />
            <x-input-error :messages="$errors->get('password_confirmation')" />
        </div>

        {{-- Actions --}}
        <div style="margin-top: 20px; display: flex; justify-content: space-between; align-items: center;">
            <button class="btn btn-primary">
                {{ __("S'inscrire") }}
            </button>

            <a href="{{ route('login') }}" class="btn btn-outline">
                {{ __('Déjà inscrit ?') }}
            </a>
        </div>
    </form>
</x-guest-layout>
