<?php

namespace App\Providers;

use App\Models\Cart;
use App\Models\User;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->register();

        Gate::define('cart-owner',function(User $user,Cart $cart){
            return $user->id === $cart->user_id;
        });

        Gate::define('is-seller',function(User $user){
            return $user === config('settings.role.seller');
        });
    }
}
