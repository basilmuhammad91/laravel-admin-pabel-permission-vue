<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use Symfony\Component\HttpFoundation\Response;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        // Gate::define('view_roles', function ($user) {
        //     return $user->email === "access@gmail.com";
        // });

        Gate::define('access_org', function ($user) {
            foreach ($user->organization->permissions as $permission) {
                if ($permission->name == 'create_permission') {
                    return true;
                }
            }
        });
    }
}
