<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        if (Auth::attempt([
            'username'=>$request->get('username'),
            'password'=>$request->get('password')
        ])){
            $token=Auth::user()->createToken('myToken'.Auth::user()->id)->plainTextToken;
            return \response(['user'=>Auth::user(),'token'=>$token]);
        }

        else {
            return \response('error with the username or password', 401);
        }
    }

    public function logout()
    {
        return auth()->user()->tokens()->delete();
    }
}
