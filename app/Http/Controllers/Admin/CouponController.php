<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Coupon;
use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;
use Illuminate\Validation\Rule;

class CouponController extends Controller
{
    protected $model;
    protected $name;
    protected $link;
    protected $image_path;
    protected $pathView;
    
    public function __construct(Coupon $model){
      $this->name = 'Cupom';
      $this->link = null;
      $this->image_path = null;
      $this->pathView = 'admin.coupon.';
      $this->model = $model;
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
              //'code' => 'required',
              'value' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
              'start' => 'required|date_format:d/m/Y',
              'end' => 'required|date_format:d/m/Y',
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
                        
            $model->code = substr(md5(time()), 0, 8);
            $model->value = $request->value;
            $model->start = \Carbon\Carbon::createFromFormat('d/m/Y', $request->start)->format('Y-m-d');
            $model->end = \Carbon\Carbon::createFromFormat('d/m/Y', $request->end)->format('Y-m-d');
                  
            $save = $model->save();
            
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
    public function show(Coupon $cupom)
    {
        $item = $cupom;
        
        $show = true;
        
        return view($this->pathView.'form',compact('item','show'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Coupon $cupom)
    {
        $item = $cupom;
        
        return view($this->pathView.'form',compact('item'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Coupon $cupom)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }
                        
        $rules = [
              //'code' => 'required',
              'value' => 'required|regex:/^[0-9]+(\.[0-9][0-9]?)?$/',
              'start' => 'required|date_format:d/m/Y',
              'end' => 'required|date_format:d/m/Y',
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
            $model = $cupom;
            
            $model->code = substr(md5(time()), 0, 8);
            $model->value = $request->value;
            $model->start = \Carbon\Carbon::createFromFormat('d/m/Y', $request->start)->format('Y-m-d');
            $model->end = \Carbon\Carbon::createFromFormat('d/m/Y', $request->end)->format('Y-m-d');
                    
            $save = $model->save();
            
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
    public function destroy(Coupon $cupom)
    {       
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        }
        
        try {
          
            $model = $cupom; 
                      
            $model->delete();

                    
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
