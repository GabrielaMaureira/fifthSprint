<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules\Password;


class UserController extends Controller
{
    
/**
 * @OA\Get(
 *   path="/players",
 *   tags={"Administrator"},
 *   summary="Get players list with success rate",
 *   description="This endpoint retrieves the list of players along with their success rate.",
 *   @OA\Response(
 *     response=200,
 *     description="Successful operation",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="data",
 *         type="array",
 *         @OA\Items(
 *           @OA\Property(
 *             property="name",
 *             type="string",
 *             description="Player name",
 *             example="John Doe"
 *           ),
 *           @OA\Property(
 *             property="success_rate",
 *             type="float",
 *             description="Player success rate",
 *             example="0.75"
 *           )
 *         )
 *       )
 *     )
 *   )
 * )
 */

    public function index()
    {
        return response()->json([User::select('name', 'success_rate')->get()], 200);
    }

/**
 * @OA\Post(
 *   path="/login",
 *   tags={"Authentication"},
 *   summary="Login",
 *   description="This endpoint is used to authenticate the admin or player and generate an access token.",
 *   @OA\RequestBody(
 *     required=true,
 *     description="Credentials",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="email",
 *         type="string",
 *         description="User email",
 *         example="johndoe@example.com"
 *       ),
 *       @OA\Property(
 *         property="password",
 *         type="string",
 *         description="User password",
 *         example="********"
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response=200,
 *     description="Successful login",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="message",
 *         type="string",
 *         description="Success message",
 *         example="Successfully logged in"
 *       ),
 *       @OA\Property(
 *         property="user",
 *         type="string",
 *         description="User name",
 *         example="John Doe"
 *       ),
 *       @OA\Property(
 *         property="auth_token",
 *         type="string",
 *         description="Access token",
 *         example="eyJhbGciOi...5O7tmS7Xw"
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response=401,
 *     description="Invalid credentials",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="message",
 *         type="string",
 *         description="Error message",
 *         example="Invalid credentials"
 *       )
 *     )
 *   )
 * )
 */

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'password' => 'required'
       ]);

       $data = [
            'email' => $request->email,
            'password' => $request->password,
       ];

        if (Auth::attempt($data)) {
            $user = Auth::user();
            $token = $user->createToken('auth_token')->accessToken;
            return response()->json(['message' => 'Successfully logged in', 'user' => $user->name, 'auth_token' => $token], 200);
    }

        return response()->json(['message' => 'Invalid credentials'], 401);
    }

/**
 * @OA\Post(
 *   path="/players",
 *   tags={"Authentication"},
 *   summary="Players registration",
 *   description="This endpoint is used to register a new player in the game.",
 *   @OA\RequestBody(
 *     @OA\MediaType(
 *       mediaType="application/json",
 *       @OA\Schema(
 *         @OA\Property(
 *           property="name",
 *           type="string",
 *           description="Name of the player",
 *           example="John Doe"
 *         ),
 *         @OA\Property(
 *           property="email",
 *           type="string",
 *           description="Email of the player",
 *           example="johndoe@example.com"
 *         ),
 *         @OA\Property(
 *           property="password",
 *           type="string",
 *           description="Password of the player",
 *           example="********"
 *         ),
 *         @OA\Property(
 *           property="password_confirmation",
 *           type="string",
 *           description="Confirmation of the password",
 *           example="********"
 *         )
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response=201,
 *     description="Player successfully registered",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="user",
 *         type="string",
 *         description="Name of the registered user",
 *         example="John Doe"
 *       ),
 *       @OA\Property(
 *         property="email",
 *         type="string",
 *         description="Email of the registered user",
 *         example="johndoe@example.com"
 *       ),
 *       @OA\Property(
 *         property="auth_token",
 *         type="string",
 *         description="Access token for authentication",
 *         example="eyJ0en0..."
 *       )
 *     )
 *   )
 * )
 */
    public function register(Request $request)
    {
       $request->validate([
            'name' => 'nullable|max:255|unique:users',
            'email' => 'required|email|unique:users',
            'password' => ['required', 'confirmed', Password::min(8)->mixedCase()],
       ]);

       $user = User::create([
            'name' => $request->name ?: 'Anonymous',
            'email' => $request->email,
            'password' => Hash::make($request->password),
       ])->assignRole('player');

       $token = $user->createToken('auth_token')->accessToken;
       return response()->json(['user' => $user->name, 'email' => $user->email, 'auth_token' => $token], 201);
    }

    /**
     * Get the user by id.
     */
    private function getUserId($id)
    {
        return User::findOrFail($id);
    }

/**
 * @OA\Put(
 *   path="/players/{id}",
 *   tags={"Players"},
 *   summary="Update player name",
 *   description="This endpoint is used to update the name of a specific player.",
 *   @OA\Parameter(
 *     name="id",
 *     in="path",
 *     description="Player ID",
 *     required=true,
 *     @OA\Schema(
 *       type="integer",
 *       format="int64",
 *       example=1
 *     )
 *   ),
 *   @OA\RequestBody(
 *     required=true,
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="name",
 *         type="string",
 *         description="New name for the player",
 *         example="John Doe"
 *       )
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
 *         example="Name updated successfully"
 *       )
 *     )
 *   ),
 *   @OA\Response(
 *     response=422,
 *     description="Unprocessable Entity",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="error",
 *         type="string",
 *         description="Error message",
 *         example="The name field is required."
 *       )
 *     )
 *   )
 * )
 */

    public function update(Request $request, $id)
    {
        $user = $this->getUserId($id);
        $name = $request->input('name');

        if (empty($name)) {
            return response()->json(['error' => 'The name field is required.'], 422);
        }

        else if ($name !== $user->name) {
            $request->validate([
                'name' => 'required|max:255|unique:users',
            ]);

            $user->name = $name;
            $user->save();
        }        

        return response()->json(['message' => 'Name updated successfully'], 200);
    }


/**
 * @OA\Post(
 *   path="/logout",
 *   tags={"Authentication"},
 *   summary="Logout",
 *   description="This endpoint is used to log out the authenticated user.",
 *   @OA\Response(
 *     response=200,
 *     description="Successful operation",
 *     @OA\JsonContent(
 *       @OA\Property(
 *         property="message",
 *         type="string",
 *         description="Success message",
 *         example="Successfully logged out"
 *       )
 *     )
 *   )
 * )
 */

    public function logout()
    {
        $token = Auth::user()->token();
        $token->revoke();
        return response()->json([ 'message' => 'Successfully logged out'], 200);
    }
    
   
}

