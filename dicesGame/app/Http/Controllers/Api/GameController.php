<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\User;



class GameController extends Controller
{
    

/**
 * @OA\Get(
 *   path="/players/{id}/games",
 *   tags={"Players"},
 *   summary="Games list for a specific player",
 *   description="This endpoint is used to retrieve the list of games for a specific player.",
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     description="Player ID",
 *     required=true,
 *     @OA\Schema(
 *       type="integer",
 *       example=1
 *     )
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Successful operation",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="player",
 *         type="string",
 *         description="Player name",
 *         example="John Doe"
 *       ),
 *       @OA\Property(
 *         property="games",
 *         type="array",
 *         description="List of games",
 *         @OA\Items(
 *           ref="#/components/schemas/Game"
 *         )
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response=404,
 *     description="Player not found",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="error",
 *         type="string",
 *         description="Error message",
 *         example="Player not found"
 *       )
 *     )
 *   )
 * )
 */

    public function index($id)
    {
        return response()->json(['player' => $this->getUserId($id)->name, 'games' => $this->getUserId($id)->games], 200);
    }

    /**
     * Simulate a game of dice and return the result.
     */
    private function gameLogic()
    {
        $dice1 = rand(1, 6);
        $dice2 = rand(1, 6);

        return [
            'dice_1' => $dice1,
            'dice_2' => $dice2,
            'is_win' => $dice1 + $dice2 === 7,
        ];
    }
   
/**
 * @OA\Post(
 *   path="/players/{id}/games",
 *   tags={"Players"},
 *   summary="A specific player throw the dice",
 *   description="This endpoint is used to simulate a player throwing the dice.",
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     description="Player ID",
 *     required=true,
 *     @OA\Schema(
 *       type="integer",
 *       example=1
 *     )
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Successful operation",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="result",
 *         type="string",
 *         description="Result of the dice throw (win/lose)",
 *         example="win"
 *       ),
 *       @OA\Property(
 *         property="dice_1",
 *         type="integer",
 *         description="Value of the first dice",
 *         example=4
 *       ),
 *       @OA\Property(
 *         property="dice_2",
 *         type="integer",
 *         description="Value of the second dice",
 *         example=3
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response=404,
 *     description="Player not found",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="error",
 *         type="string",
 *         description="Error message",
 *         example="Player not found"
 *       )
 *     )
 *   )
 * )
 */

    public function throwTheDice($id)
    {
        $game = $this->createGame($this->gameLogic(), $this->getUserId($id));

        return response()->json([
            'result' => $game->is_win ? 'win' : 'lose',
            'dice_1' => $game->dice_1,
            'dice_2' => $game->dice_2,
        ], 200);
    }

    /**
     * Game is created & success_rate value is updated
     */
    private function createGame($data, $user)
    {
        $game = $user->games()->create($data);
        $user->success_rate = $user->getSuccessRate();
        $user->save();

        return $game; 
    }

    
    /**
     * Get the user by id.
     */
    private function getUserId($id)
    {
        $user = User::find($id);
    
        if (!$user) {
            abort(404, 'User not found');
        }else if (Auth::user()->id != $user->id) {
            abort(401, 'Unauthorized');
        }
    
        return $user;
    }

/**
 * @OA\Delete(
 *   path="/players/{id}/games",
 *   tags={"Players"},
 *   summary="A specific player delete all the games",
 *   description="This endpoint is used to delete all the games of a specific player.",
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     description="Player ID",
 *     required=true,
 *     @OA\Schema(
 *       type="integer",
 *       example=1
 *     )
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Successful operation",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="message",
 *         type="string",
 *         description="Success message",
 *         example="Games have been deleted"
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response=404,
 *     description="Player not found",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="error",
 *         type="string",
 *         description="Error message",
 *         example="Player not found"
 *       )
 *     )
 *   )
 * )
 */

    public function destroy($id)
    {
        $this->getUserId($id)->games()->delete();
        
        return response()->json(['message' => 'Games have been deleted'], 200);
    }

    
}


