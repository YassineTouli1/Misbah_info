<?php

namespace App\Http\Controllers\Manager\CaisseController;

use App\Http\Controllers\Controller;

class AjouterALaCaisseController extends Controller
{
    public function __invoke(){
        return view('dashboard.Caisse.ajouter_pop_up');
    }
}
