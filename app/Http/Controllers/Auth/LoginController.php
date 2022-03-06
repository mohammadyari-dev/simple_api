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
        $admin = $user->isAdministrator();
        $tokenAbilities = [];
        if ($admin) {
            $tokenAbilities = [
                'admin'
            ];
        }
        $token = $user->createToken('auth-token', $tokenAbilities)->plainTextToken;
        $data = [
            'auth_token' => $token,
            'token_type' => 'Bearer'
        ];

        return $this->tokenResponse($data, 201);
    }

    /**
     * Register new user
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        // Validate user data
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'email:rfc|unique:users,email',
            'password'   => 'required|min:6|confirmed'
        ]);

        // Add new user to database
        $data               = $request->all();
        $data['password']   = bcrypt($request->password);
        $data['admin']      = User::REGULAR_USER;

        $user               = User::create($data);

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
