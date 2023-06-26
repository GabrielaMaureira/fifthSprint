<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;

class RankingController extends Controller
{
/**
 * @OA\Get(
 *   path="/players/ranking",
 *   tags={"Players, Administrator"},
 *   summary="Player's list with better puntuation first",
 *   description="This endpoint is used to retrieve the list of players, ordered by better puntuation first.",
 *   @OA\Response(
 *     response=200,
 *     description="Successful operation",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="players_list",
 *         type="array",
 *         description="List of players",
 *         @OA\Items(
 *           @OA\Property(
 *             property="name",
 *             type="string",
 *             description="Player's name"
 *           ),
 *           @OA\Property(
 *             property="success_rate",
 *             type="float",
 *             description="Player's success rate"
 *           )
 *         )
 *       )
 *     )
 *   )
 * )
 */

    public function index()
    {
        $players = User::orderBy('success_rate', 'desc')->select('name', 'success_rate')->get();
    
        return response()->json(['players_list' => $players], 200);
    }

/**
 * @OA\Get(
 *     path="/players/ranking/winner",
 *     tags={"Administrator"},
 *     summary="Get player with highest success rate",
 *     description="This endpoint retrieves the player with the highest success rate.",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                  property="player", 
 *                  type="string", 
 *                  description="Name of the player"
 *              ),
 *             @OA\Property(
 *                  property="success_rate", 
 *                  type="number", 
 *                  description="Success rate of the player"
 *              )
 *         )
 *     )
 * )
 */
    public function winner()
    {
        $user = User::orderByDesc('success_rate')->first();
        
        return response()->json([
            'player' => $user->name,
            'success_rate' => $user->success_rate], 200);
    }

/**
 * @OA\Get(
 *     path="/players/ranking/loser",
 *     tags={"Administrator"},
 *     summary="Get player with worst success rate",
 *     description="This endpoint retrieves the player with the worst success rate.",
 *     @OA\Response(
 *         response=200,
 *         description="Successful operation",
 *         @OA\JsonContent(
 *             @OA\Property(
 *                  property="player", 
 *                  type="string", 
 *                  description="Name of the player"
 *              ),
 *             @OA\Property(
 *                  property="success_rate", 
 *                  type="number", 
 *                  description="Success rate of the player"
 *              )
 *         )
 *     )
 * )
 */
    public function loser()
    {
        $user = User::where('name', '!=', 'Administrator')->orderBy('success_rate')->first();

        return response()->json([
            'player' => $user->name,
            'success_rate' => $user->success_rate], 200);
    }
}