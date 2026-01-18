<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Trip Gates
        Gate::define('cancel-trip', function ($user, $trip) {
            return $user->id === $trip->proposal->user_id;
        });

        Gate::define('subscribe-trip', function ($user, $trip) {
            return $user->id !== $trip->proposal->user_id // ne peut pas s'inscrire à sa propre proposition
                && !$trip->reservations->contains('user_id', $user->id); // ne s'est pas déjà inscrit
        });

        Gate::define('unsubscribe-trip', function ($user, $trip) {
            return $trip->reservations->contains('user_id', $user->id); // si il a réserver le trajet
        });

        // Vehicule Gates
        Gate::define('manage-vehicle', function ($user, $vehicle) {
            return $vehicle->user_id === $user->id;
        });

    }
}
