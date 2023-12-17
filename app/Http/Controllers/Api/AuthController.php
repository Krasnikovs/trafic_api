<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\UserRequest;
use App\Http\Resources\UserResource;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;


class AuthController extends Controller
{
    public function register(UserRequest $request)
    {
        $validated = $request->validated();
        $validated['password'] = Hash::make($validated['password']);

        $user = User::create($validated);
        return new UserResource($user);
    }

    public function login(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);
        $user = User::where('email', $validated['email'])->first();
        if (!Auth::attempt($validated))
        {
            return response()->json([
               'data' => 'Incorrect data.'
            ], 403);
        }

        return response()->json([
            'user' => new UserResource($user),
            'access_token' => $user->createToken('login')->plainTextToken,
        ]);
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();

        return response()->json([
           'message' => [
               'type' => 'success',
               'data' => 'Success log out.'
           ]
        ]);
    }

    public function me()
    {
        return new UserResource(auth()->user());
    }
}
