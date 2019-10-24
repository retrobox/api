<?php

namespace App\Models;

class Console extends Model
{
    protected $table = 'consoles';

    protected $keyType = 'string';

    public $incrementing = false;

    public function order()
    {
        return $this->belongsTo(ShopOrder::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}