<?php

namespace App\Models;

class GamePlatform extends Model
{

	protected $table = 'game_platforms';

	protected $keyType = 'string';

	public $incrementing = false;

	protected $dates = ['released_at'];

	public function games()
	{
		return $this->hasMany(Game::class, 'platform_id');
	}

    public function medias()
    {
        return $this->hasMany(GameMedia::class, 'platform_id', 'id');
    }
}