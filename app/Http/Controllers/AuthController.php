<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Cookie;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $user = User::create([
            'first_name' => $request->input('first_name'),
            'last_name' => $request->input('last_name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password')),
            'role_id' => 2,
        ]);

        return response($user, Response::HTTP_CREATED);
    }

    public function login(Request $request)
    {
        if(!Auth::attempt($request->only(['email', 'password']))){
            return response([
                'error' => 'Invalid Credentials!'
            ], Response::HTTP_UNAUTHORIZED);
        }

        $user = Auth::user()->load('role');
        $jwt = $user->createToken('token')->plainTextToken;

        $cookie = cookie('jwt', $jwt, 60 * 24);

        return response([
            'jwt' => $jwt,
            'role' => $user->role->id
        ])->withCookie($cookie);
    }

    public function user(Request $request)
    {
        return $request->user()->load('role');
    }

    public function logout()
    {
        $cookie = Cookie::forget('jwt');

        return \response([
            'message' => 'success'
        ])->withCookie($cookie);
    }
}
