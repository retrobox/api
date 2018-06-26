<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{

	protected $table = 'shop_items';

	protected $keyType = 'string';

	public $incrementing = false;

	public function link()
	{
		return $this->belongsTo(ShopLink::class);
	}

	public function category()
	{
		return $this->belongsTo(ShopCategory::class);
	}
}