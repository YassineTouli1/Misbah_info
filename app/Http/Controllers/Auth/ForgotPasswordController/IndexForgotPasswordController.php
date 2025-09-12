<?php

namespace App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\Controller;

class IndexForgotPasswordController extends Controller
{
    public function __invoke(){
        return view('auth.email');
    }

}
