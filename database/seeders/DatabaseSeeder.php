<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Création des rôles
        $gestionnaire = Role::firstOrCreate(['name' => 'gestionnaire']);
        $client = Role::firstOrCreate(['name' => 'client']);

        // Création des permissions
        $permissions = [
            'manage products',
            'manage orders',
            'manage payments',
            'view stats',             // Permission pour voir les statistiques
            'manage notifications',   // Permission pour gérer les notifications
            'change order status',    // Permission pour changer le statut des commandes
        ];

        foreach ($permissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        // Attribution des permissions au rôle gestionnaire
        $gestionnaire->syncPermissions($permissions);

        // Attribution de permissions spécifiques au rôle client
        $clientPermissions = [
            'view own orders',        // Permission pour voir ses propres commandes
            'place orders',           // Permission pour passer des commandes
        ];

        foreach ($clientPermissions as $permission) {
            Permission::firstOrCreate(['name' => $permission]);
        }

        $client->syncPermissions($clientPermissions);

        // Création de l'administrateur (gestionnaire)
        $admin = User::firstOrCreate([
            'email' => 'aliou.18.ndour@gmail.com',
        ], [
            'name' => 'Linho ',
            'password' => Hash::make('P@sser123'),
        ]);

        // Création de l'utilisateur (client)
        $user = User::firstOrCreate([
            'email' => 'jadonplimesancho117@gmail.com',
        ], [
            'name' => 'jules ',
            'password' => Hash::make('P@sser123'),
        ]);

        // Attribution des rôles aux utilisateurs
        if (!$admin->hasRole('gestionnaire')) {
            $admin->assignRole($gestionnaire);
        }

        if (!$user->hasRole('client')) {
            $user->assignRole($client);
        }

        // Création de quelques produits pour démonstration
        if (\App\Models\Product::count() === 0) {
            $this->createSampleProducts();
        }

        $this->command->info('Bingo ! Base de données initialisée avec succès.');
    }

    /**
     * Crée quelques produits pour la démonstration
     */
    private function createSampleProducts()
    {
        $products = [
            [
                'name' => 'Classic Burger',
                'description' => 'Notre burger classique avec du bœuf, de la salade, des tomates et notre sauce signature.',
                'price' => 5000,
                'stock' => 50,
                'is_active' => true,
            ],
            [
                'name' => 'Cheese Burger',
                'description' => 'Un délicieux burger avec du fromage fondant, viande juteuse et des condiments frais.',
                'price' => 6000,
                'stock' => 40,
                'is_active' => true,
            ],
            [
                'name' => 'Double Burger',
                'description' => 'Pour les grandes faims ! Double viande, double fromage et tous nos ingrédients premium.',
                'price' => 8000,
                'stock' => 30,
                'is_active' => true,
            ],
            [
                'name' => 'Veggie Burger',
                'description' => 'Alternative végétarienne avec galette de légumes, avocat, tomates et notre sauce spéciale.',
                'price' => 5500,
                'stock' => 25,
                'is_active' => true,
            ],
            [
                'name' => 'Spicy Burger',
                'description' => 'Pour les amateurs de sensations fortes, avec sauce piquante, jalapeños et viande épicée.',
                'price' => 7000,
                'stock' => 35,
                'is_active' => true,
            ],
        ];

        foreach ($products as $productData) {
            \App\Models\Product::create($productData);
        }
    }
}
