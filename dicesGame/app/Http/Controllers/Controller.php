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
 *          name="Authentication",
 *          description="Operations that a user can do wether is administrator or a player"
 *      ),
 *      
 *      @OA\Tag(
 *          name="Players",
 *          description="Operations that a player can do."
 *      ),
 * 
 *      @OA\Tag(
 *          name="Administrator",
 *          description="Operations that an administrator can do."
 *      ),
 *      
 * )
 * @OA\Server(url="http://127.0.0.1:8000")
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}
