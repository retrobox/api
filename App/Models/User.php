<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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
}
