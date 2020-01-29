<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class SliderController extends Controller
{
    protected $model;
    
    public function __construct(\App\Slider $model){
      $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model::all();
        return view('admin.slider.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.slider.form');
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
            'title' => 'required',
            'sub_title' => 'required',
            'image' => 'mimes:jpeg,jpg,bmp,png',
          ];            
          
        }else{
          
          $rules = [
            'title' => 'required',
            'sub_title' => 'required',
            'image' => 'required|mimes:jpeg,jpg,bmp,png',
          ];          
        }

        $this->validate($request, $rules);   

        if($update){

          $model = $this->model->findOrFail($request->id);
          $image_before_update = $model->image;
                
        }else{
          $model = new $this->model;
        }

        $model->title = $request->title;
        $model->sub_title = $request->sub_title;
                
        if(strlen($request->image)>0){
          
          $model->image = $request->image;
           
        }      
        $model->save();
            
        $response = 'Slider ';
            
        if($update){
          $response .= 'Atualizado(a) com Sucesso!';
        }else{
          $response .= 'Cadastrado(a) com Sucesso!';
        }              
                    
        if($file   =   $request->file('image')) {
              
          $image_name      =   time().time().'.'.$file->getClientOriginalExtension();

          $target_path    =   public_path('uploads/slider');
          $is_uploaded = $file->move($target_path, $image_name);
                    
          if ($is_uploaded) {
                        
              $update_model = $this->model->findOrFail($model->id);
              $update_model->image = $image_name;
              $update_model->save();
                        
              if($update){
                $storage = Storage::disk('public');
                if(\File::exists('uploads/slider/'.$image_before_update)) {
                    \File::delete('uploads/slider/'.$image_before_update);
                }  
              }
          } else {
              $response .= ' (a imagem não foi salva)';
          }
            

        }else{
          if($update){
            if(strlen($image_before_update)>0){
                  
              if(!\File::exists('uploads/slider/'.$image_before_update)) {
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
          return redirect('admin/slider')->with('successMsg',$response);
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
        return view('admin.slider.form',compact('item'));
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
        if (file_exists('uploads/slider/'.$item->image))
        {
            unlink('uploads/slider/'.$item->image);
        }
        $item->delete();
        return back()->with('successMsg','Slider Deletado com Sucesso!');
    }
}
