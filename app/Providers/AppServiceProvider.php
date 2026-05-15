<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

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
        // Definisikan semua Gate di sini
        $this->defineGates();
    }

    protected function defineGates(): void
    {
        // Gate untuk role
        Gate::define('admin', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('volunteer', function (User $user) {
            return $user->role === 'volunteer';
        });

        Gate::define('participant', function (User $user) {
            return $user->role === 'participant';
        });

        // Gate khusus aksi
        Gate::define('verify-payment', function (User $user) {
            return $user->role === 'admin';
        });

        Gate::define('confirm-racepack', function (User $user) {
            return $user->role === 'volunteer';
        });

        Gate::define('manage-event', function (User $user) {
            return $user->role === 'admin';
        });

        // Gate dinamis untuk kepemilikan data (contoh: registrasi milik sendiri)
        Gate::define('view-registration', function (User $user, $registration) {
            return $user->role === 'admin' || $user->id === $registration->user_id;
        });

        Gate::define('update-registration', function (User $user, $registration) {
            return $user->role === 'participant' 
                && $user->id === $registration->user_id 
                && $registration->status === 'pending';
        });
    }
}

