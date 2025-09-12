<?php

namespace App\Http\Controllers\Manager;


use App\Http\Controllers\Controller;
use App\Models\MenuItem;
use Illuminate\Http\Request;
use App\Models\Client;

class DashboardController extends Controller
{
    public function __invoke(Request $request)
    {
        $nbrClient=Client::count();
        $nbrPlat=MenuItem::count();
        return view('dashboard.dashboard',compact('nbrClient','nbrPlat'));
    }
}





