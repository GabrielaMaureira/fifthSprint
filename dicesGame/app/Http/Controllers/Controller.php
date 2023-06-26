<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

/**
 * @OA\Info(
 *    title="Swagger Dice Game - OpenAPI 3.0",
 *    description="API Rest about a game that consists of 2 dice. If the result is 7, you win the game; otherwise, you lose it.",
 *    version="1.0.0",
 *    termsOfService="http://swagger.io/terms/",
 *    contact={
 *      "email": "gmaureirapalma@gmail.com"
 *    }, 
 * )
 * @OA\Tags(
 *     @OA\Tag(
 *          name="User",
 *          description="Operations that a user can do."
 *      ),
 *      @OA\Tag(
 *          name="Games",
 *          description="Operations that the user with a player role only can do."
 *      ),
 *      @OA\Tag(
 *          name="Ranking",
 *          description="Operations that admin user can do. And also a player, but only one."
 *      ),
 *      
 * )
 * @OA\Server(url="http://127.0.0.1:8000")
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
