<?php

namespace App\Models;

class GameTag extends Model
{
	protected $table = 'game_tags';

	protected $keyType = 'string';

	public $incrementing = false;

	public function games()
	{
		return $this->belongsToMany(Game::class, 'game_tags_games', 'game_id', 'tag_id');
	}
}