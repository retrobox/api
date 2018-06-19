<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Post extends Model
{

	protected $table = 'posts';

	protected $keyType = 'string';

	public $incrementing = false;
}