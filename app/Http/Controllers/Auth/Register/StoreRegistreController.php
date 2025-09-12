<?php

namespace App\Http\Controllers\Auth\Register;

use App\Models\Client;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;
use App\Models\User;
use Illuminate\Validation\ValidationException;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class StoreRegistreController extends Controller
{
    public function __invoke(Request $request)
    {
        $attrb = request()->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => [
                'required',
                Password::min(8)
                ->mixedCase()
                ->numbers()
                ->symbols()           
                ->uncompromised(),
                'confirmed',
            ],
            'phone_number' => 'required|string|max:255',
        ]);

        $user = User::create([
            'name' => $attrb['name'],
            'email' => $attrb['email'],
            'password' => Hash::make($attrb['password']),

            'role' => 'client', //obliger de definir role meme si est defini par defaut client dans migration
        ]);

        $client = Client::create([
            'user_id' => $user->id,
            'phone' => $attrb['phone_number'],
        ]);

        if (request()->has('added_by_admin')) {
            return redirect()->route('clients')->with('success', 'Client ajouté avec succès.');
        } else {
            Auth::login($user);
            return redirect('/client/home')->with('success', 'Bienvenue sur Snack El Madina !');
        }
    }
}





