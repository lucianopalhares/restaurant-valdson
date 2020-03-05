<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $table = 'users';
    
    protected $guarded = [];
    
    public function cliente(){
      return $this->hasOne('App\RoleUser','user_id')->where('role_users.role_id', '=', '2');
    }
    public function carts(){
      return $this->hasMany('App\Cart','user_id');
    }
    public function orders() {
        return $this->belongsToMany(Order::class, 'orders');
    }
}
