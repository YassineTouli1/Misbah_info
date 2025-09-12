<?php

namespace App\Http\Controllers\Manager\CaisseController;

use App\Http\Controllers\Controller;

class TirerDeLaCaisseController extends Controller
{

    public function __invoke(){
            return view('dashboard.Caisse.tirer_caisse_pop_up');
        }

}
