<?php

namespace App\Http\Controllers\Restaurant;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class RestaurantCategoryController extends Controller
{
    protected $model;
    protected $restaurant;
    protected $category;
    
    public function __construct(\App\RestaurantCategory $model){
      $this->model = $model;
      $this->restaurant = \App::make('App\Restaurant');
      $this->category = \App::make('App\Category');
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $restaurant = request()->session()->get('restaurant');//pegando o restaurante
        $items = $restaurant->categories;
        
        return view('restaurant.restaurant_category.index',compact('items','restaurant'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $restaurant = request()->session()->get('restaurant');//pegando o restaurante
        $categories = $this->category::all();
        
        if($restaurant->categories->count()==5){
          return back()->withError('Limite de ate 5 categorias por restaurante');
        }
        
        return view('restaurant.restaurant_category.form',compact('restaurant','categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store($restaurant,Request $request)
    {   
        $restaurant = request()->session()->get('restaurant');
        
        $update = false;
                                
        if(isset($request->id)){
          $update = true;
        }
        
        if($update){
          
          $rules = [
              //'restaurant_id' => 'required',
              'category_id' => 'required'
          ];            
          
        }else{
          
          $rules = [
              'category_id' => 'required'
          ];          
        }
        
        $this->validate($request, $rules);   

        if($update){

          $model = $this->model->findOrFail($request->id);
                
        }else{
          $count = $this->model->where('restaurant_id',$restaurant->id)->where('category_id',$request->category_id)->count();
          if($count){
            return back()->withError('Esta categoria já foi adicionada!');
          }
          $model = new $this->model;
        }
        
        $model->restaurant_id = $restaurant->id;
        $model->category_id = $request->category_id;
        $model->save();
            
        $response = 'Categoria Adicionada no Restaurante com Sucesso';
            
        if($update){
          //$response .= 'Atualizado(a) com Sucesso!';
        }else{
          //$response .= 'Cadastrado(a) com Sucesso!';
        }              
                   
            
        if (request()->wantsJson()) {
          return response()->json(['status'=>true,'msg'=>$response]);
        }else{
          return redirect('usuario/'.$restaurant->slug.'/restaurante_categoria')->with('successMsg',$response);
        }              
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\RestaurantCategory  $restaurantCategory
     * @return \Illuminate\Http\Response
     */
    public function show(RestaurantCategory $restaurantCategory)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\RestaurantCategory  $restaurantCategory
     * @return \Illuminate\Http\Response
     */
    public function edit($restaurant,$id)//not using
    {
        return back()->withError('Edite deletando uma categoria e adicionando outra!');
        
        $restaurant = request()->session()->get('restaurant');//pegando o restaurante
        $categories = $this->category::all();
        $item = $this->model::whereRestaurantId($restaurant->id)->whereId($id)->first();
        
        return view('restaurant.restaurant_category.form',compact('item','restaurant','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\RestaurantCategory  $restaurantCategory
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, RestaurantCategory $restaurantCategory)
    {
        //
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\RestaurantCategory  $restaurantCategory
     * @return \Illuminate\Http\Response
     */
    public function destroy($restaurant,$id)
    {
        try {
            $restaurant = request()->session()->get('restaurant');//pegando o restaurante
            $item = $this->model::whereRestaurantId($restaurant->id)->whereId($id)->first();
            $item->delete();          
        } catch (\Exception $e) {
            return back()->withError('Erro ao deletar:'.$e);
        }       

        return back()->with('successMsg','Categoria removida do Restaurante com Sucesso!');
    }
}
