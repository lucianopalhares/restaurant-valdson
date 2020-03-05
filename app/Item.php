<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    protected $guarded = [];
    
    public function category()
    {
        return $this->belongsTo('App\Category','category_id');
    }
    public function restaurant()
    {
        return $this->belongsTo('App\Restaurant','restaurant_id');
    }
    public function carts(){
      return $this->hasMany('App\Cart','item_id');
    }
    public function promotion(){
      return $this->hasOne('App\Promotion','item_id')->where('promotions.active', '=', '1')->where('promotions.start', '<=', date('Y-m-d'))
      ->where('promotions.end', '>=', date('Y-m-d'));
    }
}
