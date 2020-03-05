<?php

namespace App\Http\Controllers\Restaurant;

use App\Category;
use App\Contact;
use App\Item;
use App\Reservation;
use App\Slider;
use App\Restaurant;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {     
        $restaurant = request()->session()->get('restaurant');//pegando o restaurante
                                
        return view('restaurant.dashboard',compact('restaurant'));
    }
}
