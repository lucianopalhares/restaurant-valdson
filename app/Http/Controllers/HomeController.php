<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\Slider;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class HomeController extends Controller
{

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $sliders = Slider::all();
        $categories = Category::all();
        $items = Item::all();
        
        $restaurant = \App\Restaurant::first();
        
                
        if(!$restaurant){
          if(\Auth::user()){
            //return redirect('admin/restaurant/create')->withError('Cadastre um Restaurante!');
          }else{
            //return redirect('/login')->withError('Cadastre um Restaurante');
          }
        }
        
        //return view('welcome',compact('sliders','categories','items','restaurant'));
    }
}
