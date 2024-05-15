<?php

namespace App\Providers;

use App\MApplication;
use App\User;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use Laravel\Passport\Passport;

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
        //if (! app()->runningInConsole()) {
        //    Passport::routes();
        //}

        /**
         * MApplication
         */
        Gate::define('is-cartographer-m-application', function (User $user, MApplication $application) {
            if (! config('app.cartographers', false) || $user->isAdmin()) {
                return true;
            }
            return $application->hasCartographer($user);
        });
    }
}
