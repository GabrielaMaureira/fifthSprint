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

       return response()->json(['user' => $user, 'auth_token' => $token], 201);
    }

    
    /**
     * Name modified for a specific player
     */
    public function update(Request $request, $id)
    {
        
    }
}

