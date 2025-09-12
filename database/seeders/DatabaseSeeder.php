<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use App\Models\Client;
use App\Models\Manager;
use App\Models\MenuItem;
use App\Models\Menu;
use App\Models\Category;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Créer un gérant
        $gerant = User::updateOrCreate(
            ['email' => 'gerant@snack.com'],
            [
                'name' => 'Gérant Snack',
                'password' => Hash::make('password'),
                'role' => 'gerant'
            ]
        );

        Manager::updateOrCreate(
            ['user_id' => $gerant->id],
            []
        );

        // Créer un client
        $client = User::updateOrCreate(
            ['email' => 'client@test.com'],
            [
                'name' => 'Client Test',
                'password' => Hash::make('password'),
                'role' => 'client'
            ]
        );

        Client::updateOrCreate(
            ['user_id' => $client->id],
            [
                'phone' => '0987654321'
            ]
        );

        // Créer une catégorie
        $category = Category::updateOrCreate(
            ['name' => 'Snacks'],
            []
        );

        // Créer un menu
        $menu = Menu::updateOrCreate(
            ['title' => 'Menu Principal'],
            [
                'available' => true
            ]
        );

        // Créer des articles de menu
        $menuItems = [
            [
                'name' => 'Hamburger',
                'price' => 8.50,
                'category_id' => $category->id
            ],
            [
                'name' => 'Pizza Margherita',
                'price' => 12.00,
                'category_id' => $category->id
            ],
            [
                'name' => 'Coca Cola',
                'price' => 2.50,
                'category_id' => $category->id
            ],
            [
                'name' => 'Frites',
                'price' => 4.00,
                'category_id' => $category->id
            ]
        ];

        foreach ($menuItems as $item) {
            MenuItem::updateOrCreate(
                ['name' => $item['name']],
                $item
            );
        }

        // Attacher les articles au menu
        $menu->menuItems()->sync(MenuItem::pluck('id'));

        $this->call([
            CaisseSeeder::class,
        ]);
    }
}
