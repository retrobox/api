<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ShopOrder extends Model
{

    protected $table = 'shop_orders';

    protected $keyType = 'string';

    public $incrementing = false;

    public function items()
    {
        return $this->belongsToMany(ShopItem::class,
            'shop_orders_shop_items',
            'shop_item_id',
            'shop_order_id',
            'id',
            'id')
            ->withPivot('shop_item_custom_option_storage', 'shop_item_custom_option_color');
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}