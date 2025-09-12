<?php

namespace App\Http\Controllers\Auth\ForgotPasswordController;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Facades\Hash;

class ResetPasswordController extends Controller
{

    public function __invoke(Request $request){
        $request->validate([
         'token' => 'required',
         'email' => 'required|email|exists:users,email',
         'password' => 'required|string|confirmed|min:6',
                          ]);

          $status = Password::reset(
          $request->only('email', 'password', 'password_confirmation', 'token'),

           function ($user, $password) {
              $user->password = Hash::make($password);
              $user->save();
                                       }
                   );

          return $status === Password::PASSWORD_RESET
                ? redirect()->route('login')->with('status', __($status))
                : back()->withErrors(['email' => [__($status)]]);
    }
}
