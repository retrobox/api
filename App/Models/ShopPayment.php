<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopPayment extends Model
{

	protected $table = 'shop_payments';

	protected $keyType = 'string';

	public $incrementing = false;

	public function items()
	{
		return $this->belongsToMany(ShopItem::class,
            'shop_payments_shop_items',
            'shop_item_id',
            'shop_payment_id',
            'id',
            'id');
	}

	public function user()
    {
        return $this->belongsTo(User::class);
    }
}