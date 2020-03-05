<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    public function items()
    {
        return $this->hasMany('App\Item');
    }
    public function restaurants()
    {
        return $this->belongsToMany('App\Restaurant', 'restaurant_categories', 'category_id', 'restaurant_id')->withPivot('created_at','updated_at');
    }
}
