<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopImage extends Model
{
    protected $fillable = ['id', 'url', 'is_main'];

	protected $table = 'shop_images';

	protected $keyType = 'string';

	public $incrementing = false;
}