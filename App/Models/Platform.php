<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Platform extends Model
{

	protected $table = 'platforms';

	protected $keyType = 'string';

	public $incrementing = false;

	public function games()
	{
		return $this->hasMany(Game::class);
	}
}