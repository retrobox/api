<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Media extends Model
{

	protected $table = 'medias';

	protected $keyType = 'string';

	public $incrementing = false;

	public function parent()
	{
		return $this->morphTo('parent');
	}
}