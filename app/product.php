<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class product extends Model
{
    protected $table = 'products';
    protected $guarded = ['id'];

    public  function brand()
    {
        return $this->belongsTo(brand::class,'brand_id');

    }
}
