<?php

namespace App\Http\Controllers;

use App\Category;
use App\Item;
use App\Slider;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Support\Facades\Hash;
use App\Customer;

class HomeController extends Controller
{
    protected $role_user;
    protected $customer;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
          $this->role_user = \App::make('App\RoleUser'); 
          $this->customer = \App::make('App\Customer'); 
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()//not using
    {
        $sliders = Slider::all();
        $categories = Category::all();
        $items = Item::all();
        
        $restaurant = \App\Restaurant::first();
        
        if(!$restaurant){
          return redirect('admin/restaurant/create')->withError('Cadastre um Restaurante!');
        }
        
        return view('welcome',compact('sliders','categories','items','restaurant'));
    }
    public function storeCustomer(Request $request)
    {       
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        } 
        

            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
                'password' => ['required', 'string', 'min:8', 'confirmed'],
                'mobile' => ['required'],
                'address' => ['required'],
                'district' => ['required'],
                'city' => ['required'],
                'state' => ['required'],
            ];
        
                
        $validator = Validator::make($request->all(), $rules);

        if ($validator->fails()) {
            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$validator->errors()]);
            }else{
              return redirect()->back()
                        ->withErrors($validator->errors())
                        ->withInput();
            }     
        } 
        

        
        try {
            $model = new $this->customer;
            
            $model->name = $request->name;
            $model->email = $request->email;
            $model->mobile = $request->mobile;    
            $model->address = $request->address;    
            $model->district = $request->district;  
            $model->city = $request->city;   
            $model->state = $request->state;   
            $model->password = Hash::make($request->password);     
            
            $save = $model->save();
            
            ///inserindo este usuario como cliente
            $cliente = new $this->role_user;
            $cliente->role_id = 2;
            $cliente->user_id = $model->id;
            $cliente->save();
            ///
                        
            $response = 'Cliente Cadastrado. Digite seus dados para entrar!';
            
            if ($is_api) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return redirect('/login')->with('successMsg', $response);
            }            
            
        } catch (\Exception $e) {//errors exceptions
          
            $response = null;
            
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              case ValidationException::class:$response = $e;
              default: $response = get_class($e);
            }    
            
            $response = method_exists($e,'getMessage')?$e->getMessage():get_class($e);           
            
            if ($is_api) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return back()->withInput($request->toArray())->withErrors($response);
            }  
          
        } 
    }
}
