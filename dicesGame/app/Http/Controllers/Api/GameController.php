<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;



class GameController extends Controller
{
    /**
     * Games list for a specific player
     */
    public function index($id)
    {
        return response()->json($this->getUserId($id)->games, 200);
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
     * A specific player throw the dice
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
        return User::findOrFail($id);
    }

    /**
     * A specific player delete all the games
     */
    public function destroy($id)
    {
        $this->getUserId($id)->games()->delete();
        
        return response()->json(['message' => 'Games have been deleted'], 200);
    }
}


