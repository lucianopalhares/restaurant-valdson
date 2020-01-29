<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Validation\Rule;

class RoleController extends Controller
{
    protected $model;
    
    public function __construct(\App\Role $model){
      $this->model = $model;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model::where('slug','!=','admin')->get();
        return view('admin.role.index',compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.role.form');
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
              'name' =>  ['required','max:100',Rule::unique('roles')->ignore($request->id)],
          ];            
          
        }else{
          
          $rules = [
              'name' =>  'required|unique:roles|max:100',
          ];          
        }

        $this->validate($request, $rules);   

        if($update){

          $model = $this->model->findOrFail($request->id);
                
        }else{
          $model = new $this->model;
        }
        $slug = str_slug($request->name.time());
        
        $model->name = $request->name;
        $model->slug = $slug;
                      
        $model->save();
            
        $response = 'Cargo ';
            
        if($update){
          $response .= 'Atualizado(a) com Sucesso!';
        }else{
          $response .= 'Cadastrado(a) com Sucesso!';
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
        $item = $this->model::where('slug','!=','admin')->whereId($id)->first();
        return view('admin.role.form',compact('item'));
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
        $item = $this->model::where('slug','!=','admin')->whereId($id)->first();

        $item->delete();
        return back()->with('successMsg','Cargo Deletado com Sucesso!');
    }
}
