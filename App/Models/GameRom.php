<?php

namespace App\Models;

class GameRom extends Model
{
	protected $table = 'game_roms';

	protected $keyType = 'string';

	public $incrementing = false;

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}