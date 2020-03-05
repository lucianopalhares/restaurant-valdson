<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;
use App\Restaurant;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;

class RestaurantController extends Controller
{
    protected $model;
    protected $payment_way;
    
    public function __construct(\App\Restaurant $model){
      $this->model = $model;
      $this->payment_way = \App::make('App\PaymentWay');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            return response()->json(['data'=>$this->model::all()]);
        } 
        $items = $this->model::paginate(10);
        return view('admin.restaurant.index',compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {  
        $payment_ways = $this->payment_way::all();
        return view('admin.restaurant.form',compact('payment_ways'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
          
            $is_api = true;
        }    
                            
          $rules = [
              'name' => 'required',
              'address' => 'required',
              'number' => 'nullable',
              'district' => 'required',
              'state' => 'required',
              'city' => 'required',
              'opening_hours_start' => 'required',
              'opening_hours_end' => 'required',
              'phone' => 'nullable',
              'mobile' => 'required',
              'whatsapp' => 'nullable',
              'logo' => 'image|mimes:png|max:1500',
              'cnpj' => 'required',
              'insc_est' => 'required',
              'about_us' => 'nullable'
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
            $model = new $this->model;
                        
        $slug = str_slug($request->name);
        if($this->model::whereSlug($slug)->count()>0){
          $slug = str_slug($request->name.time());
        }

        $model->name = $request->name;
        $model->slug = $slug;
        $model->address = $request->address;
        $model->number = $request->number;
        $model->district = $request->district;
        $model->state = $request->state;
        $model->city = $request->city;
        $model->opening_hours_start = $request->opening_hours_start;
        $model->opening_hours_end = $request->opening_hours_end;
        $model->phone = $request->phone;
        $model->mobile = $request->mobile;
        $model->whatsapp = $request->whatsapp;
        $model->cnpj = $request->cnpj;
        $model->insc_est = $request->insc_est;
        $model->about_us = $request->about_us;
        $model->logo_path = 'public/frontend/images/restaurants';
        $model->tax = $request->tax;
        $model->delivery_time = $request->delivery_time;
        $model->payment_way_id = $request->payment_way_id;
        $model->value_min = $request->value_min;
        $model->info = $request->info;
                
        if(strlen($request->logo)>0){
          
          $model->logo = $request->logo;
           
        }  
            
        $save = $model->save();
            
            $response = 'Restaurante';
            
            $response .= ' Cadastrado(a) com Sucesso!';  
            
        if($file   =   $request->file('logo')) {
              
          $image_name      =   $slug.'-logo.'.$file->getClientOriginalExtension();

          $target_path    =   public_path('frontend/images/restaurants');
          $is_uploaded = $file->move($target_path, $image_name);
                    
          if ($is_uploaded) {
                                    
              $update_model = $this->model->findOrFail($model->id);
              $update_model->logo = $image_name;
              $update_model->save();                        
            
          } else {
              $response .= ' (o logo não foi salvo)';
          }            

        }else{
          $response .= ' (o logo não foi salvo)';
        }   
            
            if ($is_api) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->with('successMsg', $response);
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
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        } 
            
        try {
    
            $item = $this->model::findOrFail($id);
            $payment_ways = $this->payment_way::all();
            
                        
            if ($is_api) {
              return response()->json(['data'=>$item]);
            }
            $show = true;
            return view('admin.restaurant.form',compact('item','payment_ways','show'));                     
            
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
              return back()->withErrors($response);
            }  
          
        }  
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        } 
            
        try {
    
            $item = $this->model::findOrFail($id);
            $payment_ways = $this->payment_way::all();
            
                        
            if ($is_api) {
              return response()->json(['data'=>$item]);
            }
            
            return view('admin.restaurant.form',compact('item','payment_ways'));                     
            
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
              return back()->withErrors($response);
            }  
          
        }     

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Restaurant $restaurante)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
          
            $is_api = true;
        }    
                            
          $rules = [
              'name' => 'required',
              'address' => 'required',
              'number' => 'nullable',
              'district' => 'required',
              'state' => 'required',
              'city' => 'required',
              'opening_hours_start' => 'required',
              'opening_hours_end' => 'required',
              'phone' => 'nullable',
              'mobile' => 'required',
              'whatsapp' => 'nullable',
              'logo' => 'image|mimes:png|max:1500',
              'cnpj' => 'required',
              'insc_est' => 'required',
              'about_us' => 'nullable'
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
            $model = $restaurante;
            
            $image_before_update = $restaurante->logo;
                        
        $slug = str_slug($request->name);
        if($this->model::whereSlug($slug)->count()>0){
          $slug = str_slug($request->name.time());
        }

        $model->name = $request->name;
        $model->slug = $slug;
        $model->address = $request->address;
        $model->number = $request->number;
        $model->district = $request->district;
        $model->state = $request->state;
        $model->city = $request->city;
        $model->opening_hours_start = $request->opening_hours_start;
        $model->opening_hours_end = $request->opening_hours_end;
        $model->phone = $request->phone;
        $model->mobile = $request->mobile;
        $model->whatsapp = $request->whatsapp;
        $model->cnpj = $request->cnpj;
        $model->insc_est = $request->insc_est;
        $model->about_us = $request->about_us;
        $model->logo_path = 'public/frontend/images/restaurants';
        $model->tax = $request->tax;
        $model->delivery_time = $request->delivery_time;
        $model->payment_way_id = $request->payment_way_id;
        $model->value_min = $request->value_min;
        $model->info = $request->info;
                
        if(strlen($request->logo)>0){
          
          $model->logo = $request->logo;
           
        }  
            
        $save = $model->save();
            
            $response = 'Restaurante';
            
            $response .= ' Cadastrado(a) com Sucesso!';  
            
        if($file   =   $request->file('logo')) {
              
          $image_name      =   $slug.'-logo.'.$file->getClientOriginalExtension();

          $target_path    =   public_path('frontend/images/restaurants');
          $is_uploaded = $file->move($target_path, $image_name);
                    
          if ($is_uploaded) {
            
              $update_model = $this->model->findOrFail($model->id);
              $update_model->logo = $image_name;
              $update_model->save();
                        
                $storage = Storage::disk('public');
                if(\File::exists('frontend/images/restaurants/'.$image_before_update)) {
                    \File::delete('frontend/images/restaurants/'.$image_before_update);
                }  
              
          } else {
              $response .= ' (o logo não foi salvo)';
          }
            

        }else{
      
            if(strlen($image_before_update)>0){
                  
              if(!\File::exists('frontend/images/restaurants/'.$image_before_update)) {
                  $response .= ' (o logo não foi salvo)';
              }                  
            }else{
              $response .= ' (o logo não foi salvo)';
            }
    
        }    
            
            if ($is_api) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->with('successMsg', $response);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        } 
            
        try {
    
            $item = $this->model::findOrFail($id);
            if (file_exists('frontend/images/restaurants/'.$item->logo))
            {
                unlink('frontend/images/restaurants/'.$item->logo);
            }
            $item->delete(); 
                        
            if ($is_api) {
              return response()->json(['status'=>true,'msg'=>'Restaurante Deletado com Sucesso!']);
            }
            
            return back()->with('successMsg','Restaurante Deletado com Sucesso!');                    
            
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
              return back()->withErrors($response);
            }  
          
        }   
    }
}
