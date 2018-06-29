<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopItem extends Model
{

	protected $table = 'shop_items';

	protected $keyType = 'string';

	public $incrementing = false;

//	public function link()
//	{
//		return $this->belongsTo(ShopLink::class);
//	}

	public function categoryWithItems()
	{
		return $this->belongsTo(ShopCategory::class, 'shop_category_id','id')->with('items');
	}

	public function category()
    {
        return $this->belongsTo(ShopCategory::class, 'shop_category_id','id');
    }

    public function images()
    {
        return $this->hasMany(ShopImage::class, 'shop_item_id', 'id');
    }
}