<?php

namespace App\Http\Controllers\User;

use App\Models\User;
use App\Http\Controllers\ApiController;
use Illuminate\Http\Request;

/**
 * Crud users
 * @author Mohammad.Y <mhd.yari021@gmail.com>
 */
class UserController extends ApiController
{
    /**
     * Constructor
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     */
    public function __construct()
    {
        // Prevent access routes
        $this->middleware(['auth:sanctum', 'abilities:admin'])->except(['index', 'show']);
    }
    /**
     * Display a listing of the resource.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all();

        return $this->showAll($users);
    }

    /**
     * Store a newly created resource in storage.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate user data
        $request->validate([
            'first_name' => 'required',
            'last_name'  => 'required',
            'email'      => 'required|email:rfc|unique:users,email',
            'password'   => 'required|min:6|confirmed'
        ]);

        // Add new user to database
        $data               = $request->all();
        $data['password']   = bcrypt($request->password);

        $user               = User::create($data);

        return $this->showOne($user, 201);
    }

    /**
     * Display the specified resource.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user)
    {
        return $this->showOne($user);
    }

    /**
     * Update the specified resource in storage.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        // Validate user data
        $request->validate([
            'email'      => 'email:rfc|unique:users,email,' . $user->id,
            'password'   => 'min:6|confirmed'
        ]);

        // Check data is change or not
        if ($request->has('first_name')) {
            $user->first_name = $request->first_name;
        }

        if ($request->has('last_name')) {
            $user->last_name = $request->last_name;
        }

        if ($request->has('email') && $user->email != $request->email) {
            $user->email = $request->email;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        if (!$user->isDirty()) {
            return $this->errorResponse("You need to specify a diffrent value to update", 422);
        }

        // Update user data
        $user->save();

        return $this->showOne($user);
    }

    /**
     * Remove the specified resource from storage.
     * @author Mohammad.Y <mhd.yari021@gmail.com>
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        if (!$user->posts->isEmpty()) {
            return $this->errorResponse("You can't remove user, the user currently has posts", 409);
        }

        $user->delete();

        return $this->showOne($user);
    }
}
