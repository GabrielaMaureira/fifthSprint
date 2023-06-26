<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 *     title="Game",
 *     description="Game model",
 *     @OA\Property(
 *         property="id",
 *         type="integer",
 *         description="ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="user_id",
 *         type="integer",
 *         description="User ID",
 *         example=1
 *     ),
 *     @OA\Property(
 *         property="dice_1",
 *         type="integer",
 *         description="Value of dice 1",
 *         example=4
 *     ),
 *     @OA\Property(
 *         property="dice_2",
 *         type="integer",
 *         description="Value of dice 2",
 *         example=2
 *     ),
 *     @OA\Property(
 *         property="is_win",
 *         type="boolean",
 *         description="Indicates if the game is a win or not",
 *         example=true
 *     ),
 *     @OA\Property(
 *         property="created_at",
 *         type="string",
 *         format="date-time",
 *         description="Creation timestamp",
 *         example="2023-06-19T12:00:00+00:00"
 *     ),
 *     @OA\Property(
 *         property="updated_at",
 *         type="string",
 *         format="date-time",
 *         description="Last update timestamp",
 *         example="2023-06-19T13:30:00+00:00"
 *     )
 * )
 */
class Game extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'user_id',
        'dice_1',
        'dice_2',
        'is_win',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
