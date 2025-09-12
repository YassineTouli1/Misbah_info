<?php

namespace App\Http\Controllers\Manager\ClientController;


use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class IndexClientController extends Controller
{
    public function __invoke(Request $request)
    {
        $clients=Client::with('user')->get();
        return view('dashboard.client.clients',compact('clients'));
    }
}





