<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

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