<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bot extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'token',
        'user_id',
    ];

    /**
     * Get the user that owns the bot.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
