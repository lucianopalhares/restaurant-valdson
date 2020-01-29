<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class CategoryController extends Controller
{
    protected $model;
    
    public function __construct(\App\Category $model){
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
        return view('admin.category.index',compact('items'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.category.form');
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
              'name' =>  ['required','max:100',Rule::unique('categories')->ignore($request->id)],
              'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1500',
          ];            
          
        }else{
          
          $rules = [
              'name' =>  'required|unique:categories|max:100',
              'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:1500',
          ];          
        }

        $this->validate($request, $rules);   
        $slug = str_slug($request->name.time());

        if($update){

          $model = $this->model->findOrFail($request->id);
          $image_before_update = $model->imagem;
                
        }else{
          $model = new $this->model;
        }
                        
        $model->name = $request->name;
        $model->slug = $slug;             
        $model->description = $request->description;
        
        if(strlen($request->image)>0){
          if($update){
            $model->image = $request->image;
          }  
        }        
        $model->save();
            
        $response = 'Categoria ';
            
        if($update){
          $response .= 'Atualizado(a) com Sucesso!';
        }else{
          $response .= 'Cadastrado(a) com Sucesso!';
        }              
                    
        if($file   =   $request->file('image')) {
              
          $image_name      =   time().time().'.'.$file->getClientOriginalExtension();

          $target_path    =   public_path('uploads/category');
          $is_uploaded = $file->move($target_path, $image_name);
                    
          if ($is_uploaded) {
                        
              $update_model = $this->model->findOrFail($model->id);
              $update_model->image = $image_name;
              $update_model->save();
                        
              if($update){
                $storage = Storage::disk('public');
                if(\File::exists('uploads/category/'.$image_before_update)) {
                    \File::delete('uploads/category/'.$image_before_update);
                }  
              }
          } else {
              $response .= ' (a imagem não foi salva)';
          }
            

        }else{
          if($update){
            if(strlen($image_before_update)>0){
                  
              if(!\File::exists('uploads/category/'.$image_before_update)) {
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
        $item = $this->model::find($id);
        return view('admin.category.form',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)//not using
    {
        $this->validate($request,[
            'name'=>'required',
        ]);
        $image = $request->file('image');
        $slug = str_slug($request->name);
        $item = $this->model::find($id);
        if (isset($image))
        {
            $currentDate = Carbon::now()->toDateString();
            $imagename = $slug .'-'. $currentDate .'-'. uniqid() .'.'. $image->getClientOriginalExtension();
            if (!file_exists('uploads/category'))
            {
                mkdir('uploads/category', 0777 , true);
            }
            $image->move('uploads/category',$imagename);
        }else {
            $imagename = $item->image;
        }    
        
        $item->name = $request->name;
        $item->slug = $slug;
        $item->description = $request->description;
        $item->image = $imagename;
        $item->save();
        return redirect()->route('category.index')->with('successMsg','Categoria Editada com Sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = $this->model::find($id);
        if (file_exists('uploads/category/'.$item->image))
        {
            unlink('uploads/category/'.$item->image);
        }
        $item->delete();
        return back()->with('successMsg','Categoria Deletada com Sucesso!');
    }
}
