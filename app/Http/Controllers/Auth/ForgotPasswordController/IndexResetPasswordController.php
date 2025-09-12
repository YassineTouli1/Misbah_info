<?php

namespace App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class IndexResetPasswordController extends Controller
{

    public function __invoke(Request $request,$token){
        return view('auth.reset', ['token' => $token, 'email' => $request->email]);
    }
}
