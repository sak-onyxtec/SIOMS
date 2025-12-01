<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        Gate::define('view-products', function ($user) {
            return $user->hasPermissionTo('view-products');
        });

        Gate::define('create-products', function ($user) {
            return $user->hasPermissionTo('create-products');
        });

        Gate::define('edit-products', function ($user) {
            return $user->hasPermissionTo('edit-products');
        });

        Gate::define('delete-products', function ($user) {
            return $user->hasPermissionTo('delete-products');
        });

        Gate::define('manage-users', function ($user) {
            return $user->hasPermissionTo('manage-users');
        });
        Gate::define('manage-staffs', function ($user) {
            return $user->hasPermissionTo('manage-staffs');
        });
        Gate::define('manage-permissions', function ($user) {
            return $user->hasPermissionTo('manage-permissions');
        });
        Gate::define('manage-orders', function ($user) {
            return $user->hasPermissionTo('manage-orders');
        });
        Gate::define('manage-inventory', function ($user) {
            return $user->hasPermissionTo('manage-inventory');
        });

        Gate::define('is-admin', function ($user) {
            return $user->hasRole('admin');
        });

        Gate::define('is-staff', function ($user) {
            return $user->hasRole('staff');
        });
    }
}
