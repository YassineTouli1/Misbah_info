<?php

namespace App\Http\Controllers\Auth\Register;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateRegistreController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('Auth.register');
    }
}





