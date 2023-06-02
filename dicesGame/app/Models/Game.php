<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
