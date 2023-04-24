<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;


class UserController extends Controller
{
    /**
     * Players list with success_rate
     */
    public function index()
    {
        return response()->json([User::select('name', 'success_rate')->get()], 200);
    }

    /**
     * Login for authenticated user
     */
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
       ]);

       $data = [
            'email' => $request->email,
            'password' => $request->password,
       ];

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->accessToken;
            return response()->json(['message' => 'Login successfully', 'user' => $user->name, 'auth_token' => $token], 200);
    }

        return response()->json(['message' => 'Unauthenticated'], 401);
    }

    /**
     * Register
     */
    public function register(Request $request)
    {
       $request->validate([
            'name' => 'max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6'
       ]);

       $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
       ]);

       $token = $user->createToken('auth_token')->accessToken;

       return response()->json(['user' => $user->name, 'email' => $user->email, 'auth_token' => $token], 201);
    }

    
    /**
     * Name modified for a specific player
     */
    public function update(Request $request, $id)
    {
        
    }
}

