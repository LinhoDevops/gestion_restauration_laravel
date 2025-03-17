<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;
use App\Models\User;
use App\Models\Order;
use App\Models\Product;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array<class-string, class-string>
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

        // Gate pour vérifier si un utilisateur est gestionnaire et peut gérer les produits
        Gate::define('manage-products', function (User $user) {
            return $user->hasRole('gestionnaire');
        });

        // Gate pour vérifier si un utilisateur est gestionnaire et peut gérer les commandes
        Gate::define('manage-orders', function (User $user) {
            return $user->hasRole('gestionnaire');
        });

        // Gate pour vérifier si un utilisateur peut voir une commande (propriétaire ou gestionnaire)
        Gate::define('view-order', function (User $user, Order $order) {
            return $user->id === $order->user_id || $user->hasRole('gestionnaire');
        });

        // Gate pour vérifier si un utilisateur peut modifier une commande
        Gate::define('update-order', function (User $user, Order $order) {
            return $user->hasRole('gestionnaire');
        });

        // Gate pour vérifier si un utilisateur peut supprimer une commande
        Gate::define('delete-order', function (User $user, Order $order) {
            return $user->hasRole('gestionnaire');
        });

        // Gate pour vérifier si un utilisateur peut gérer les paiements
        Gate::define('manage-payments', function (User $user) {
            return $user->hasRole('gestionnaire');
        });

        // Gate pour vérifier si un utilisateur peut voir les statistiques
        Gate::define('view-statistics', function (User $user) {
            return $user->hasRole('gestionnaire');
        });

        // Gate pour vérifier si un utilisateur peut créer un produit
        Gate::define('create-product', function (User $user) {
            return $user->hasRole('gestionnaire');
        });

        // Gate pour vérifier si un utilisateur peut modifier un produit
        Gate::define('update-product', function (User $user, Product $product) {
            return $user->hasRole('gestionnaire');
        });

        // Gate pour vérifier si un utilisateur peut supprimer un produit
        Gate::define('delete-product', function (User $user, Product $product) {
            return $user->hasRole('gestionnaire');
        });
    }
}
