<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\RankingController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});



// Players list
Route::get('/players', [UserController::class, 'index'])->name('players.index');



Route::controller(GameController::class)->group(function(){

    // Games list for a specific player
    Route::get('players/{id}/games', 'index')->name('games.index');

    // A specific player throw the dice
    Route::post('/players/{id}/games', 'throwTheDice')->name('games.throwTheDice');

    // A specific player delete all the games
    Route::delete('/players/{id}/games', 'destroy')->name('games.destroy');

});

Route::controller(RankingController::class)->group(function(){

    // Average success rate of all players
    //Route::get('/players/ranking', 'index')->name('ranking.index');
    
    // Highest success rate
    Route::get('/players/ranking/winner', 'winner')->name('ranking.winner');
});