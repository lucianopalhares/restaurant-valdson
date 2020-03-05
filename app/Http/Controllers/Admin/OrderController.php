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
use App\Order;
use Auth;

class OrderController extends Controller
{
    protected $name;
    protected $link;
    protected $pathView;
    protected $model;
    protected $order_item;
    
    public function __construct(Order $model){
      $this->name = 'Venda';
      $this->link = null;
      $this->pathView = 'admin.order.';
      $this->model = $model;  
      $this->order_item = \App::make('App\OrderItem');    
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $items = $this->model::all();     
        
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
      
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {       

    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Customer  $model
     * @return \Illuminate\Http\Response
     */
    public function show(Order $venda)
    {
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        } 
        
        try {
                      
            $item = $venda;
                                    
            if($is_api){
              return response()->json(['data'=>$item]);
            }
            
            $show = true;
                                    
            return view($this->pathView.'show',compact('item','show'));  
            
        } catch (\Exception $e) {//errors exceptions
          
            $response = null;
            
            switch (get_class($e)) {
              case QueryException::class:$response = $e->getMessage();
              case Exception::class:$response = $e->getMessage();
              default: $response = get_class($e);
            }              
            
            if($is_api){
              return response()->json(['status'=>false,'msg'=>$response]);
            }else{
              return redirect($this->link)->withErrors($response);
            }  
          
        }    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Order  $model
     * @return \Illuminate\Http\Response
     */
    public function edit(Order $venda)
    {
  
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Order  $model
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Order $venda)
    {

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Order  $model
     * @return \Illuminate\Http\Response
     */
    public function destroy(Order $venda)
    {
        try {
                      
            $$venda->delete();
            
            $this->order_item::whereOrderId($venda->id)->delete();
            
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
    public function orderStatus(Order $venda){
      
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        } 
            
        try {
          
          $response = null;
          
            if($venda->status=='0'){
              $venda->update(['status'=>1]);
              
              $response = 'Venda Ativada com Sucesso';              
            }elseif($venda->status=='1'){
              $venda->update(['status'=>0]);
              
              $response = 'Venda Cancelada com Sucesso';              
            }elseif($venda->status=='2'){
              $venda->update(['status'=>0]);
              
              $response = 'Venda Cancelada com Sucesso';              
            }  
                        
            if ($is_api) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return back()->withErrors($response);
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
              return back()->withErrors($response);
            }  
          
        }       
    }
    public function showOrderItems(Order $venda){
      
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        } 
            
        try {
    
            return view($this->pathView.'items',compact('venda'));
                      
            
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


