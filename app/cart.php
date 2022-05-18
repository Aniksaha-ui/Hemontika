<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class cart extends Model
{
    protected $fillable = [
        "user_id","product_id","cart_quantity","isOrdered",
    ];
}
