<?php

namespace Database\Seeders;

use App\Models\Manager;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class ManagerSeeder extends Seeder
{
    public function run()
    {
        $user = User::updateOrCreate(
            ['email' => 'gerant@snack.com'], // check by email
            [
                'name' => 'Gérant Principal',
                'password' => Hash::make('Hello@1234pass'),
                'role' => 'gerant',
            ]
        );

        // Only create Manager if not exists
        Manager::firstOrCreate([
            'user_id' => $user->id,
        ]);
    }
}
