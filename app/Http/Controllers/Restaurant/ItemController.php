<?php

namespace App\Http\Controllers\Restaurant;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Item;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;

class ItemController extends Controller
{
    protected $model;
    protected $category;
    protected $name;
    protected $link;
    protected $image_path;
    protected $pathView;
    
    public function __construct(Item $model){
      $this->name = 'Cardápio';
      $this->link = '/restaurante';
      $this->image_path = 'uploads/item';
      $this->pathView = 'restaurant.item.';
      $this->model = $model;
      $this->category = \App::make('App\Category');
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
        $categories = $this->category::all();
        $restaurant = request()->session()->get('restaurant');//pegando o restaurante
        return view($this->pathView.'form',compact('categories','restaurant'));
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
              'category_id' => 'required',
              'name' => 'required',
              'description' => 'required',
              'type' => 'required',
              'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
              'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1500',
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
            
            $model->category_id = $request->category_id;
            $model->restaurant_id = request()->session()->get('restaurant')->id;//pegando o restaurante
            $model->name = $request->name;
            $model->type = $request->type;
            $model->description = $request->description;
            $model->price = $request->price;
            $model->image_path = 'public/'.$this->image_path;
                    
            if(strlen($request->image)>0){
              
              $model->image = $request->image;
               
            }  
            
            $save = $model->save();
            
            $response = $this->name;
            
            $response .= ' Cadastrado(a) com Sucesso!';
            
            if($file   =   $request->file('image')) {
                  
              $image_name      =   time().time().'.'.$file->getClientOriginalExtension();

              $target_path    =   public_path($this->image_path);
              $is_uploaded = $file->move($target_path, $image_name);
                        
              if ($is_uploaded) {
                        
                  $update_model = $this->model->findOrFail($model->id);
                  $update_model->image = $image_name;
                  $update_model->save();

              } else {
                  $response .= ' (a imagem não foi salva)';
              }
                

            }else{
              $response .= ' (a imagem não foi salva)';
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
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($restaurant,$id)
    {
        $restaurant = request()->session()->get('restaurant');//pegando o restaurante
        $item = $this->model::whereRestaurantId($restaurant->id)->whereId($id)->first();
        $categories = $this->category::all();
        
        return view($this->pathView.'form',compact('item','categories','restaurant'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $restaurantSlug, Item $cardapio)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }
                        
          $rules = [
              'category_id' => 'required',
              'name' => 'required',
              'description' => 'required',
              'type' => 'required',
              'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
              'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1500',
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
            $model = $cardapio;
            
            $image_before_update = $model->imagem;
            
            $model->category_id = $request->category_id;
            $model->restaurant_id = request()->session()->get('restaurant')->id;//pegando o restaurante
            $model->name = $request->name;
            $model->type = $request->type;
            $model->description = $request->description;
            $model->price = $request->price;
            $model->image_path = 'public/'.$this->image_path;
                    
            if(strlen($request->image)>0){
              
              $model->image = $request->image;
               
            }  
            
            $save = $model->save();
            
            $response = $this->name;
            
            $response .= ' Atualizado(a) com Sucesso!';
            
            if($file   =   $request->file('image')) {
                  
              $image_name      =   time().time().'.'.$file->getClientOriginalExtension();

              $target_path    =   public_path($this->image_path);
              $is_uploaded = $file->move($target_path, $image_name);
                        
              if ($is_uploaded) {
                        
                  $update_model = $this->model->findOrFail($model->id);
                  $update_model->image = $image_name;
                  $update_model->save();

                  $storage = Storage::disk('public');
                  if(\File::exists($this->image_path.'/'.$image_before_update)) {
                      \File::delete($this->image_path.'/'.$image_before_update);
                  }  
                  
              } else {
                  $response .= ' (a imagem não foi salva)';
              }
                

            }else{
              if(strlen($image_before_update)>0){
                    
                if(!\File::exists($this->image_path.'/'.$image_before_update)) {
                    $response .= ' (a imagem não foi salva)';
                }                  
              }else{
                $response .= ' (a imagem não foi salva)';
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
    public function destroy($restaurantSlug,Item $cardapio)
    {       
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }
        
        try {
          
            $item = $cardapio; 
                      
            $item->delete();

            if (file_exists($this->image_path.'/'.$item->image))
            {
                unlink($this->image_path.'/'.$item->image);
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
}
