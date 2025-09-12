<?php

namespace App\Http\Controllers\Manager\ClientController;


use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class DeleteClientController extends Controller
{
    public function __invoke(Client $client)
    {
        $client->delete();
        return redirect()->route('clients')->with('success', 'Client supprimé avec succès.');
    }
}





