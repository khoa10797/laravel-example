<?php

namespace App\Providers;

use App\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('create-product', function ($user) {
            return $this->authorization($user, 'CREATE_PRODUCT');
        });

        Gate::define('delete-product', function ($user) {
            return $this->authorization($user, 'DELETE_PRODUCT');
        });

        Gate::define('update-product', function ($user) {
            return $this->authorization($user, 'UPDATE_PRODUCT');
        });
    }

    private function authorization(User $user, $roleName)
    {
        return $user->roles->contains(function ($value) use ($roleName) {
            return $value->name == $roleName;
        });
    }
}
