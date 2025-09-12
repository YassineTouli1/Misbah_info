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

        $user = User::create([
            'name' => 'Gérant Principal',
            'email' => 'gerant@snack.com',
            'password' => Hash::make('Hello@1234pass'),
            'role' => 'gerant',
        ]);

        Manager::create([
            'user_id' => $user->id,
        ]);
    }
}
