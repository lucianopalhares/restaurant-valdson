<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentWay extends Model
{
    public function restaurants()
    {
        return $this->hasMany('App\Restaurant', 'payment_way_id');
    }
}
