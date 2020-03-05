<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    protected $guarded = [];
    
    public function item()
    {
        return $this->belongsTo('App\Item','item_id');
    }
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant','restaurant_id');
    }
}
