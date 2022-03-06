<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\ApiController;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Authectication
 * @author Mohammad.Y <mhd.yari021@gmail.com>
 */
class LoginController extends ApiController
{
    /**
     * Constructor
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     */
    public function __construct()
    {
        // Prevent access routes
        $this->middleware('auth:sanctum')->only(['logout']);
    }
    /**
     * Authenticated users
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email:rfc'],
            'password' => ['required'],
        ]);

        if (!Auth::attempt($credentials)) {
            return $this->errorResponse("The provided credentials do not match our records.", 401);
        }

        $user = User::where('email', $request['email'])->firstOrFail();
        $token = $user->createToken('auth-token')->plainTextToken;
        $data = [
            'auth_token' => $token,
            'token_type' => 'Bearer'
        ];

        return $this->tokenResponse($data, 201);
    }

    /**
     * Logout
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        // Revoke the token that was used to authenticate the current request...
        $request->user()->currentAccessToken()->delete();

        $data = [
            'message' => 'Tokens Revoked',
        ];

        return $this->tokenResponse($data);
    }
}
