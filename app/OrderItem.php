<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $guarded = [];
    
    public function item(){
      return $this->belongsTo('App\Item','item_id');
    }
    public function order(){
      return $this->belongsTo('App\Order','order_id');
    }
}
