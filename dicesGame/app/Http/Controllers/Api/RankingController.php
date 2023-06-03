<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;


class RankingController extends Controller
{
    

     /**
     * Player's list with better puntuation first
     */
    public function index()
    {
        $players = User::orderBy('success_rate', 'desc')->select('name', 'success_rate')->get();
    
        return response()->json(['players_list' => $players], 200);
    }

    /**
     * Player with highest success rate
     */
    public function winner()
    {
        $user = User::orderByDesc('success_rate')->first();
        
        return response()->json([
            'player' => $user->name,
            'success_rate' => $user->success_rate], 200);
    }

    /**
     * Player with worst success rate
     */
    public function loser()
    {
        $user = User::where('name', '!=', 'Administrator')->orderBy('success_rate')->first();

        return response()->json([
            'player' => $user->name,
            'success_rate' => $user->success_rate], 200);
    }
}