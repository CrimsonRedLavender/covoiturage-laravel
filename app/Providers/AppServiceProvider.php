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
        Gate::define('cancel-trip', function ($user, $trip) {
            return $user->id === $trip->proposal->user_id;
        });

        Gate::define('subscribe-trip', function ($user, $trip) {
            return $user->id !== $trip->proposal->user_id
                && !$trip->reservations->contains('user_id', $user->id);
        });

        Gate::define('unsubscribe-trip', function ($user, $trip) {
            return $trip->reservations->contains('user_id', $user->id);
        });

        Gate::define('viewPassengers-trip', function ($user, $trip) {
            return $user->id === $trip->proposal->user_id;
        });

    }
}
