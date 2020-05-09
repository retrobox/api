<?php

namespace App\Models;

class Post extends Model
{
	protected $table = 'posts';

	protected $keyType = 'string';

	public $incrementing = false;
}