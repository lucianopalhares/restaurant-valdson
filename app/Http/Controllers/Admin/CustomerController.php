<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Hash;
use App\Customer;
use Auth;

class CustomerController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $role_user;
    
    public function __construct(Customer $model){
      $this->name = 'Cliente';
      $this->link = null;
      $this->pathView = 'admin.customer.';
      $this->model = $model;  
      $this->role_user = \App::make('App\RoleUser');    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model::has('cliente')->get();       
        
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
          return response()->json(['data'=>$items]);
        }else{
          return view($this->pathView.'index',compact('items'));
        }  
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {          
        return view($this->pathView.'form');
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
            $model = new $this->model;
            
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
     * @param  \App\Customer  $model
     * @return \Illuminate\Http\Response
     */
    public function show(Customer $cliente)
    {
        try {
                      
            $item = $cliente;
            
            $show = true;
                                    
            return view($this->pathView.'form',compact('item','show'));  
            
        } catch (\Exception $e) {//errors exceptions
          
            $response = null;
            
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              default: $response = get_class($e);
            }              
            
            if (request()->wantsJson()) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return redirect($this->link)->withErrors($response);
            }  
          
        }    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Customer  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $cliente)
    {
        try {
                      
            $item = $cliente;
                                    
            return view($this->pathView.'form',compact('item'));  
            
        } catch (\Exception $e) {//errors exceptions
          
            $response = null;
            
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              default: $response = get_class($e);
            }              
            
            if (request()->wantsJson()) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return redirect($this->link)->withErrors($response);
            }  
          
        }  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Customer  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Customer $cliente)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        } 
        

            $rules = [
                'name' => ['required', 'string', 'max:255'],
                'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($request->id)],
                //'password' => ['required', 'string', 'min:8', 'confirmed'],
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
            $model = $cliente;
            
            $model->name = $request->name;
            $model->email = $request->email;
            $model->mobile = $request->mobile;    
            $model->address = $request->address;    
            $model->district = $request->district;  
            $model->city = $request->city;   
            $model->state = $request->state;   
            
            if(strlen($model->password)>0){
              $model->password = Hash::make($request->password);     
            }
            
            $save = $model->save();
            
            $response = $this->name;
            
            $response .= ' Atualizado(a) com Sucesso!';
            
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
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
     * @param  \App\Customer  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(Customer $cliente)
    {
        try {
                      
            $cliente->delete();
            
            $response = $this->name;
            
            $response .= ' Deletado(a) com Sucesso!';
                                                
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
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
            
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return redirect($this->link)->withErrors($response);
            }  
          
        }  
    }

}


