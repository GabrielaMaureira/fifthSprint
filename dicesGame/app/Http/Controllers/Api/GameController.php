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
     *
     * @return array
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
        ]);
    }

    /**
     * Game is created
     */
    private function createGame($data, $user)
    {
        return $user->games()->create($data);
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

