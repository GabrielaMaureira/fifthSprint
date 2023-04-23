<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;


class RankingController extends Controller
{
     /**
     * Average success rate of all players
     */
    public function index()
    {
        
    }

    /**
     * Player with best success rate
     */
    public function winner()
    {
        $user = User::orderByDesc('success_rate')->first();
        
        return response()->json([
            'player' => $user->name,
            'success_rate' => $user->success_rate, 200
        ]);
    }

    /**
     * Player with worst success rate
     */
    public function loser(Request $request)
    {
        //
    }

   
}