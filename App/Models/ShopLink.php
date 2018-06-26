<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopLink extends Model
{

	protected $table = 'shop_links';

	protected $keyType = 'string';

	public $incrementing = false;

	public function items()
	{
		return $this->hasMany(ShopItem::class);
	}
}