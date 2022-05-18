<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class favouriteproduct extends Model
{
    protected $fillable = [
        "product_id","user_id","is_favourite",
    ];
}
