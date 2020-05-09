<?php

namespace App\Models;

class ShopCategory extends Model
{
	protected $table = 'shop_categories';

	protected $keyType = 'string';

	public $incrementing = false;

	public function items()
	{
		return $this->hasMany(ShopItem::class, 'shop_category_id', 'id');
	}
}