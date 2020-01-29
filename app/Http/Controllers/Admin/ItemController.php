<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class ItemController extends Controller
{
    protected $model;
    protected $category;
    
    public function __construct(\App\Item $model){
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
        $items = $this->model::all();
        return view('admin.item.index',compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = $this->category::all();
        return view('admin.item.form',compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {   
        $update = false;
                                
        if(isset($request->id)){
          $update = true;
        }
        
        if($update){
          
          $rules = [
              'category_id' => 'required',
              'name' => 'required',
              'description' => 'required',
              'type' => 'required',
              'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
              'image' => 'image|mimes:jpeg,png,jpg,gif,svg|max:1500',
          ];            
          
        }else{
          
          $rules = [
              'category_id' => 'required',
              'name' => 'required',
              'description' => 'required',
              'type' => 'required',
              'price' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
              'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:1500',
          ];          
        }

        $this->validate($request, $rules);   

        if($update){

          $model = $this->model->findOrFail($request->id);
          $image_before_update = $model->imagem;
                
        }else{
          $model = new $this->model;
        }

        $model->category_id = $request->category_id;
        $model->name = $request->name;
        $model->type = $request->type;
        $model->description = $request->description;
        $model->price = $request->price;
                
        if(strlen($request->image)>0){
          
          $model->image = $request->image;
           
        }        
        $model->save();
            
        $response = 'Cardápio ';
            
        if($update){
          $response .= 'Atualizado(a) com Sucesso!';
        }else{
          $response .= 'Cadastrado(a) com Sucesso!';
        }              
                    
        if($file   =   $request->file('image')) {
              
          $image_name      =   time().time().'.'.$file->getClientOriginalExtension();

          $target_path    =   public_path('uploads/item');
          $is_uploaded = $file->move($target_path, $image_name);
                    
          if ($is_uploaded) {
                        
              $update_model = $this->model->findOrFail($model->id);
              $update_model->image = $image_name;
              $update_model->save();
                        
              if($update){
                $storage = Storage::disk('public');
                if(\File::exists('uploads/item/'.$image_before_update)) {
                    \File::delete('uploads/item/'.$image_before_update);
                }  
              }
          } else {
              $response .= ' (a imagem não foi salva)';
          }
            

        }else{
          if($update){
            if(strlen($image_before_update)>0){
                  
              if(!\File::exists('uploads/item/'.$image_before_update)) {
                  $response .= ' (a imagem não foi salva)';
              }                  
            }else{
              $response .= ' (a imagem não foi salva)';
            }
          }else{
            $response .= ' (a imagem não foi salva)';
          }
        }    
            
        if (request()->wantsJson()) {
          return response()->json(['status'=>true,'msg'=>$response]);
        }else{
          return back()->with('successMsg',$response);
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
    public function edit($id)
    {
        $item = $this->model::findOrFail($id);
        $categories = $this->category::all();
        return view('admin.item.form',compact('item','categories'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = $this->model::findOrFail($id);
        if (file_exists('uploads/item/'.$item->image))
        {
            unlink('uploads/item/'.$item->image);
        }
        $item->delete();
        return back()->with('successMsg','Cardápio Deletada com Sucesso!');
    }
}
