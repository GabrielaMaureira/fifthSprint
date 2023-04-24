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

    // Login
    Route::post('login', [UserController::class, 'login'])->name('user.login');
    
    // Register
    Route::post('players', [UserController::class, 'register'])->name('user.register');

    

    // Players list & success rate
    Route::get('/players', [UserController::class, 'index'])->name('players.index');

    // Name modified for a specific player
    Route::patch('/players/{id}', [UserController::class, 'update'])->name('players.update');


Route::middleware('auth:api')->group(function(){

    Route::post('logout', [UserController::class, 'logout'])->name('user.logout');

    // Games list for a specific player
    Route::get('players/{id}/games', [GameController::class, 'index'])->name('games.index');

    // A specific player throw the dice
    Route::post('/players/{id}/games', [GameController::class, 'throwTheDice'])->name('games.throwTheDice');

    // A specific player delete all the games
    Route::delete('/players/{id}/games', [GameController::class, 'destroy'])->name('games.destroy');

    // Name modified for a specific player
    Route::patch('/players/{id}', [UserController::class, 'update'])->name('players.update');
});

    // Average success rate of all players
    Route::get('/players/ranking', [RankingController::class, 'index'])->name('ranking.index');
    
    // Highest success rate
    Route::get('/players/ranking/winner', [RankingController::class, 'winner'])->name('ranking.winner');

    // Lowest success rate
    Route::get('/players/ranking/loser', [RankingController::class, 'loser'])->name('ranking.loser');
