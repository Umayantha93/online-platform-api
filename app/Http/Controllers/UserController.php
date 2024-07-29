<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use Hash;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return UserResource::collection(User::paginate(10));
    }

    public function store(Request $request)
    {
        $user = User::create(
            $request->only('first_name', 'last_name', 'email') +
            ['role_id' => 1, 'password' => Hash::make('password')]
        );

        return response($user, Response::HTTP_CREATED);
    }

    public function show(string $id)
    {
        return new UserResource(User::find($id));
    }

    public function update(Request $request, string $id)
    {
        $user = User::find($id);
        $user->update($request->only('first_name', 'last_name', 'email') +
            ['role_id' => 1, 'password' => Hash::make('password')]);

        return response($user, Response::HTTP_ACCEPTED);
    }

    public function destroy(string $id)
    {
        return User::destroy($id);
    }
}
