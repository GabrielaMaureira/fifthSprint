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
        $average = User::avg('success_rate');
    
        return response()->json([
            'average_success_rate' => $average,
        ]);
    }

    /**
     * Player with highest success rate
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
    public function loser()
    {
        $user = User::orderBy('success_rate')->first();

        return response()->json([
            'player' => $user->name,
            'success_rate' => $user->success_rate
        ], 200);
    }
}