<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt([
            'username'=>$request->get('username'),
            'password'=>$request->get('password')
        ])){
            $token=Auth::user()->createToken('myToken'.Auth::user()->id)->plainTextToken;
            $user = Auth::user()->cast();
            if ($user->role !== User::ROLE_Admin) {
                $user = $user->loadMissing('hospital');
            }
            return \response(['user'=> $user,'token'=>$token]);
        }

        else {
            return \response('error with the username or password', 401);
        }
    }

    public function logout()
    {
        return auth()->user()->tokens()->delete();
    }

    public function update(Request $request)
    {

//        $request->validate([
//            'username' => 'unique:users,username'
//        ]);

        $v = Validator::make($request->only(['username']), [
            'username' => [
                'required',
                Rule::unique('users')->ignore(auth()->user()->cast()->id),
            ],
        ]);

        $v->validate();

        if ($request->get('updatePassword')) {
            if (!Hash::check($request->get('oldPassword'), \auth()->user()->password)) {
                return response("password mismatch", 403);
            }
            \auth()->user()->cast()->update([
                'name' => $request->get('name'),
                'username' => $request->get('username'),
                'password'=> bcrypt($request->get('password'))
            ]);
        } else {
            \auth()->user()->cast()->update([
                'name' => $request->get('name'),
                'username' => $request->get('username'),
            ]);

        }

        $user = User::query()->find(\auth()->user()->id);
        if (\auth()->user()->role !== User::ROLE_Admin) {
            return response($user->cast()->loadMissing('hospital'));
        } else {
            return response($user->cast());
        }

    }
}
