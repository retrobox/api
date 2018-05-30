<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Genre extends Model
{

	protected $table = 'genres';

	protected $keyType = 'string';

	public $incrementing = false;

}