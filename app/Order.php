<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];
    
    public function order_items() {
        return $this->hasMany('App\OrderItem', 'order_id');
    }
    public function items() {
        return $this->belongsToMany(Item::class, 'order_items');
    }
    public function customer() {
        return $this->belongsTo('App\Customer', 'user_id');
    }
    public function coupon() {
        return $this->belongsTo('App\Coupon', 'coupon_id');
    }
    public function paymentWay() {
        return $this->belongsTo('App\PaymentWay', 'payment_way_id');
    }
}
