<?php

namespace App\Http\Controllers\Manager\ClientController;


use App\Http\Controllers\Controller;
use App\Models\Client;
use Illuminate\Http\Request;

class AddClientController extends Controller
{
    public function __invoke(Request $request)
    {

        return view('dashboard.client.addClient');
    }
}





