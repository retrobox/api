<?php

namespace App\Models;

class GameEditor extends Model
{

	protected $table = 'game_editors';

	protected $keyType = 'string';

	public $incrementing = false;

	public function games()
	{
		return $this->hasMany(Game::class, 'editor_id');
	}
}