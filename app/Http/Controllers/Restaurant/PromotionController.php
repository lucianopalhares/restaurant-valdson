<?php

namespace App\Http\Controllers\Restaurant;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Promotion;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;

class PromotionController extends Controller
{
    protected $model;
    protected $item;
    protected $name;
    protected $link;
    protected $image_path;
    protected $pathView;
    
    public function __construct(Promotion $model){
      $this->name = 'Promoção';
      $this->link = '/restaurante';
      $this->image_path = null;
      $this->pathView = 'restaurant.promotion.';
      $this->model = $model;
      $this->item = \App::make('App\Item');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
          $items = $this->model::all();
          return response()->json(['data'=>$items]);
        }else{              
          $items = $this->model::paginate(10);
          $restaurant = request()->session()->get('restaurant');//pegando o restaurante
          return view($this->pathView.'index',compact('items','restaurant'));
        }     
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $menus = $this->item::all();
        $restaurant = request()->session()->get('restaurant');//pegando o restaurante
        return view($this->pathView.'form',compact('menus','restaurant'));
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
              'item_id' => 'required',
              'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
              'start' => 'required|date_format:d/m/Y',
              'end' => 'required|date_format:d/m/Y|after_or_equal:'.date('d/m/Y'),
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
                        
            $model->item_id = $request->item_id;
            $model->restaurant_id = request()->session()->get('restaurant')->id;//pegando o restaurante
            $model->active = $request->active;
            $model->price = $request->price;
            $model->start = \Carbon\Carbon::createFromFormat('d/m/Y', $request->start)->format('Y-m-d');
            $model->end = \Carbon\Carbon::createFromFormat('d/m/Y', $request->end)->format('Y-m-d');
                  
            $save = $model->save();
            
            if($request->active=='1'){
              $this->model::where('item_id',$request->item_id)->where('id','!=',$model->id)->update(['active' =>'0']);
              $this->item::find($request->item_id)->update(['promotion_id' => $model->id]);
            }            
            
            $response = $this->name;
            
            $response .= ' Cadastrado(a) com Sucesso!';  
            
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
    public function show($restaurantSlug,Promotion $promocao)
    {
        $item = $promocao;
        
        $show = true;
        
        $menus = $this->item::all();
        $restaurant = request()->session()->get('restaurant');//pegando o restaurante
        return view($this->pathView.'form',compact('menus','restaurant','item','show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($restaurantSlug,Promotion $promocao)
    {
        $item = $promocao;
        
        $menus = $this->item::all();
        $restaurant = request()->session()->get('restaurant');//pegando o restaurante
        return view($this->pathView.'form',compact('menus','restaurant','item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $restaurantSlug, Promotion $promocao)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }
                        
        $rules = [
              'item_id' => 'required',
              'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
              'start' => 'required|date_format:d/m/Y',
              'end' => 'required|date_format:d/m/Y|after_or_equal:'.date('d/m/Y'),
              
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
            $model = $promocao;
            
            $model->item_id = $request->item_id;
            $model->restaurant_id = request()->session()->get('restaurant')->id;//pegando o restaurante
            $model->active = $request->active;
            $model->price = $request->price;
            $model->start = \Carbon\Carbon::createFromFormat('d/m/Y', $request->start)->format('Y-m-d');
            $model->end = \Carbon\Carbon::createFromFormat('d/m/Y', $request->end)->format('Y-m-d');
                        
            $save = $model->save();

            if($request->active=='1'){
              $this->model::where('item_id',$request->item_id)->where('id','!=',$model->id)->update(['active' =>'0']);
              $this->item::find($request->item_id)->update(['promotion_id' => $model->id]);
            }   
                        
            $response = $this->name;
            
            $response .= ' Atualizado(a) com Sucesso!';
                          
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
    public function destroy($restaurantSlug,Promotion $promocao)
    {       
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }
        
        try {
          
            $Promotion = $promocao; 
                      
            $Promotion->delete();

            if (file_exists($this->image_path.'/'.$Promotion->image))
            {
                unlink($this->image_path.'/'.$Promotion->image);
            }
                    
            $response = $this->name;
            
            $response .= ' Deletado(a) com Sucesso!';
                                                
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
    public function active($restaurantSlug,Promotion $promocao)
    {       
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }
        
        try {
          
          $response = null;
                    
          if($promocao->active=='0'){
          
            $this->model::whereItemId($promocao->item_id)->update(['active' => '0']);
                      
            $promocao->active = 1;
            $promocao->save();
            
            $this->item::find($promocao->item_id)->update(['promotion_id' => $promocao->id]);
            
            $response = 'Promoção Ativada!';
          }else{
            $promocao->active = 0;
            $promocao->save();    
            
            $this->item::find($promocao->item_id)->update(['promotion_id' => null]);
            
            $response = 'Promoção Desativada!';        
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
