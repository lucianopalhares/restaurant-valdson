<?php

namespace App\Http\Controllers\Admin;

use App\Restaurant;
use App\Role;
use App\PaymentWay;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;

class DashboardController extends Controller
{
    public function index()
    {               
        $restaurant = Restaurant::all();
        $role = Role::all();
        $paymentWay = PaymentWay::all();
        return view('admin.dashboard',compact('restaurant','role','paymentWay'));
    }
}
