<?php

namespace App\Http\Controllers\Auth\Login;


use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CreateLoginController extends Controller
{
    public function __invoke(Request $request)
    {
        return view('Auth.login');
    }
}





