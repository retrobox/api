<?php

namespace App\Models;

use App\GraphQL\Type\Platform;

class GameMedia extends Model
{
	protected $table = 'game_medias';

	protected $keyType = 'string';

	public $incrementing = false;

	public function platform()
    {
        return $this->belongsTo(Platform::class,'id', 'platform_id');
    }

    public function game()
    {
        return $this->belongsTo(Game::class);
    }
}