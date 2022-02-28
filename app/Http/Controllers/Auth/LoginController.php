<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends ApiController
{
    /**
     * Handle an authentication attempt.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request, User $user)
    {
        $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt(Auth::attempt(['email' => $request->email, 'password' => $request->password, 'admin' => 'true']))) {
            $request->session()->regenerate();
            $user = User::find(Auth::id());

            return $this->showOne($user);
        }

        return $this->errorResponse("The provided credentials do not match our records.", 401);
    }
}
