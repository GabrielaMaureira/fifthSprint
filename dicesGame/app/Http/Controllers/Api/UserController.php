<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

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
     * Create new user
     */
    public function store(Request $request, $id)
    {
        
    }
    /**
     * Name modified for a specific player
     */
    public function update(Request $request, $id)
    {
        
    }
}

