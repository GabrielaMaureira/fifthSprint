<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\UserController;
use App\Http\Controllers\Api\GameController;
use App\Http\Controllers\Api\RankingController;
use Spatie\Permission\Middlewares\RoleMiddleware;


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

    
    Route::middleware('auth:api')->group(function () {
    
        // Players list & success rate
        Route::get('/players', [UserController::class, 'index'])->name('players.index')->middleware('role:admin');

        // Name modified for a specific player
        Route::patch('/players/{id}', [UserController::class, 'update'])->name('players.update')->middleware('role:player');

        // Games list for a specific player
        Route::get('players/{id}/games', [GameController::class, 'index'])->name('games.index')->middleware('role:player');

        // A specific player throw the dice
        Route::post('/players/{id}/games', [GameController::class, 'throwTheDice'])->name('games.throwTheDice')->middleware('role:player');

        // A specific player delete all the games
        Route::delete('/players/{id}/games', [GameController::class, 'destroy'])->name('games.destroy')->middleware('role:player');
        
        // Average success rate of all players
        Route::get('/players/ranking', [RankingController::class, 'index'])->name('ranking.index')->middleware('role:admin|player');
            
        // Highest success rate
        Route::get('/players/ranking/winner', [RankingController::class, 'winner'])->name('ranking.winner')->middleware('role:admin');
    
        // Lowest success rate
        Route::get('/players/ranking/loser', [RankingController::class, 'loser'])->name('ranking.loser')->middleware('role:admin');

        // Logout
        Route::post('logout', [UserController::class, 'logout'])->name('players.logout')->middleware('role:admin|player');
    });