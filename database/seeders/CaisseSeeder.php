<?php

namespace Database\Seeders;

use App\Models\Caisse;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CaisseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        Caisse::updateOrCreate(
            ['id' => 1],
            [
                'montant' => 0,
                'date' => now()->format('Y-m-d'),
                'notes' => 'Initialisation de la caisse'
            ]
        );
    }
}
