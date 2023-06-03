<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


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
            return response()->json(['message' => 'Successfully logged in', 'user' => $user->name, 'auth_token' => $token], 200);
    }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

    /**
     * Register
     */
    public function register(Request $request)
    {
       $request->validate([
            'name' => 'nullable|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()],
       ]);

       $user = User::create([
            'name' => $request->name ?: 'Anonymous',
            'email' => $request->email,
            'password' => Hash::make($request->password),
       ])->assignRole('player');

       $token = $user->createToken('auth_token')->accessToken;
       return response()->json(['user' => $user->name, 'email' => $user->email, 'auth_token' => $token], 201);
    }

    /**
     * Get the user by id.
     */
    private function getUserId($id)
    {
        return User::findOrFail($id);
    }

    /**
     * Name modified for a specific player
     */
    public function update(Request $request, $id)
    {
        $user = $this->getUserId($id);
        $name = $request->input('name');

        if (empty($name)) {
            return response()->json(['error' => 'The name field is required.'], 422);
        }
        
        if ($name !== $user->name) {
            $request->validate([
                'name' => 'required|max:255|unique:users',
            ]);

            $user->name = $name;
            $user->save();
        }        

        return response()->json(['message' => 'Name updated successfully'], 200);
    }


     /**
     * Logout.
     */
    public function logout()
    {
        $token = Auth::user()->token();
        $token->revoke();
        return response()->json([ 'message' => 'Successfully logged out'], 200);
    }
    
   
}

