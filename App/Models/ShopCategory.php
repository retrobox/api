<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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