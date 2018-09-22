<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Editor extends Model
{

	protected $table = 'editors';

	protected $keyType = 'string';

	public $incrementing = false;

	public function games()
	{
		return $this->hasMany(Game::class);
	}
}