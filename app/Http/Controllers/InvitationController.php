<?php

namespace App\Http\Controllers;

use App\User;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateInvitedUser;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;

class InvitationController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    public function show(User $user)
    {
        if ($user->type === 'invited') {
            return view('invitation', ['user' => $user]);
        } else {
            abort(403);
        }
    }

    /**
     * Updates a user instance from invited to a valid registration.
     *
     * @param array $data
     * @return \App\User
     */
    public function update(UpdateInvitedUser $request, User $user)
    {

        if ($user->type === 'invited') {
            $validated = $request->validated();

            $user->update([
                'name' => $validated['name'],
                'password' => Hash::make($validated['password']),
                'access_level' => 'premium',
                'type' => 'registered'
            ]);

            return redirect('/login')->with('message', 'Successfully fullfilled invitation. You can login now!');
        } else {
            abort(403);
        }

    }
}
