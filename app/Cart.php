<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];
  
    public function user(){
      return $this->belongsTo('App\Customer','user_id');
    }
    public function item(){
      return $this->belongsTo('App\Item','item_id');
    }
}
