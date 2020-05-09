<?php

namespace App\Models;

class User extends Model
{
    protected $table = 'users';
    protected $keyType = 'string';
    public $incrementing = false;
    protected $dates = ['last_login_at'];

    public function shopOrders()
    {
        return $this->hasMany(ShopOrder::class);
    }

    public function consoles()
    {
        return $this->hasMany(Console::class);
    }

    /**
     * Used to generate the 'shipping_address' JSON encoded field in 'shop_orders' table
     *
     * @return array
     */
    public function getAddressObject()
    {
        return [
            'first_name' => $this['first_name'],
            'last_name' => $this['last_name'],
            'first_line' => $this['address_first_line'],
            'second_line' => $this['address_second_line'],
            'postal_code' => $this['address_postal_code'],
            'city' => $this['address_city'],
            'country' => $this['address_country']
        ];
    }
}
