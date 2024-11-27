<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Bot extends Model
{
    protected $table = 'bots';
    protected $fillable = ['user_id', 'name', 'token'];

    /**
     * Get the user that owns the bot.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
