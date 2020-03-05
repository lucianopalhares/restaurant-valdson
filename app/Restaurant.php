<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Restaurant extends Model
{
    protected $guarded = [];
    
    public function items(){
      return $this->hasMany('App\Item','restaurant_id');
    }
    public function categories()
    {
        return $this->belongsToMany('App\Category', 'restaurant_categories', 'restaurant_id', 'category_id')->withPivot('created_at','updated_at');
    }
    public function payment_way()
    {
        return $this->belongsTo('App\PaymentWay', 'payment_way_id');
    }
}
