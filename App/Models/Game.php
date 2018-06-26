<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Game extends Model
{

	protected $table = 'games';

	protected $keyType = 'string';

	public $incrementing = false;

	protected $dates = ['released_at'];

	public function platform()
	{
		return $this->belongsTo(Platform::class);
	}

	public function editor()
	{
		return $this->belongsTo(Editor::class);
	}

	/**
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
	 */
	public function genres()
	{
		return $this->belongsToMany(Genre::class);
	}
}