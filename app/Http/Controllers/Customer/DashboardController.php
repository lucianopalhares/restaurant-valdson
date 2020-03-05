<?php

namespace App\Http\Controllers\Customer;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Item;
use App\Order;

use Illuminate\Support\Facades\Validator;
use Illuminate\Database\QueryException;
use Illuminate\Validation\ValidationException;
use Exception;

class DashboardController extends Controller
{
    public $item;
    public $cart;
    public $paymentWay;
    public $coupon;
    public $order;
    public $order_item;
    
    public function __construct(){
      $this->item = \App::make('App\Item');    
      $this->cart = \App::make('App\Cart');   
      $this->paymentWay = \App::make('App\PaymentWay'); 
      $this->coupon = \App::make('App\Coupon');  
      $this->order = \App::make('App\Order'); 
      $this->order_item = \App::make('App\OrderItem'); 
    }
    public function index()
    {               
        return view('customer.dashboard');
    }
    public function items()
    {     
      
        $items = $this->item::with('promotion','restaurant')->get();  
                
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {  
            return response()->json(['data'=>$items]);
        } 
        
        return view('customer.items',compact('items'));
    }
    public function promotions()
    {     
        $items = $this->item::with('promotion','restaurant')->has('promotion')->get();
      
        /*items = $this->item::with('promotion','restaurant')->whereHas('promotion', function($promotion){
            $promotion->whereActive('1')
            ->where('start', '<=', date('Y-m-d'))
            ->Where('end', '>=', date('Y-m-d'));      
        })->get();  */
                
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {  
            return response()->json(['data'=>$items]);
        } 
        
        return view('customer.promotions',compact('items'));
    }
    public function addCart(Item $item)
    {     
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        } 
            
        try {
            $model = new $this->cart;
            
            $model->user_id = \Auth::user()->id;
            $model->item_id = $item->id;
            
            $save = $model->save();
            
            $response = '"'.$item->name.'"';
                              
            $response .= ' Adicionado no Carrinho';
            
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
              return back()->withErrors($response);
            }  
          
        } 
    }
    public function emptyCart(){

        try {
                      
            $this->cart::whereUserId(\Auth::user()->id)->delete();
            
            $response = 'Carrinho Vazio!';
                                                
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
              return back()->withErrors($response);
            }  
          
        }        
    }
    public function showCart(){

        try {
            
            $coupon = null;
            if(isset($_GET['coupon'])){
              $coupon = $this->coupon::whereCode($_GET['coupon'])->first();                            
            }
                              
            $items = $this->cart::whereUserId(\Auth::user()->id)->get();
            $paymentWays = $this->paymentWay::all();
            
            $totalOrder = 0;
            
            if($items->count()==0){
              if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
                return response()->json(['status'=>false,'msg'=>'Adicione Produtos no Carrinho']);
              }else{
                return redirect('cliente/menu')->withErrors('Adicione Produtos no Carrinho');
              }                
            }         
            
            foreach ($items as $item) {   
              if($item->item->promotion()->exists()){                                                
                $totalOrder += $item->item->promotion->price;                                              
              }else{ 
                $totalOrder += $item->item->price;
              }
            }
                                                            
            if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
              return response()->json(['data'=>$items]);
            }
            
            return view('customer.cart',compact('items','paymentWays','totalOrder','coupon'));  
            
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
              return back()->withErrors($response);
            }  
          
        }        
    }
    public function storeOrder(Request $request){

        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        } 
            
        try {
            //criar a ordem de compra
            $model = new $this->order;
            
            $model->user_id = \Auth::user()->id;
            $model->payment_way_id = $request->payment_way_id;
            $model->total = $request->total;
            $model->coupon_id = $request->coupon_id; 
            $model->status = 1;           
            
            $descount = 0;
            if($request->coupon_id>0){
              $coupon = $this->coupon::find($request->coupon_id);
              $descount = $coupon->value;
              
              $model->coupon_code = $coupon->code;
              $model->coupon_value = $coupon->value;
            }
            
            $model->total_final = $request->total - $descount;
            
            $save = $model->save();
            //pega os produtos do carrinho e adiciona na ordem de compra e depois esvazia o carrinho
            
            $incart = $this->cart::whereUserId(\Auth::user()->id)->get();
            
            foreach ($incart as $itemcart) {                      
              $order_irem = new $this->order_item;  
              $order_irem->order_id = $model->id;
              $order_irem->restaurant_id = $itemcart->item->restaurant->id;
              $order_irem->category_id = $itemcart->item->category->id;
              $order_irem->item_id = $itemcart->item->id;
              $order_irem->restaurant = $itemcart->item->restaurant->name;   
              $order_irem->category = $itemcart->item->category->name;    
              $order_irem->name = $itemcart->item->name;    
              $order_irem->type = $itemcart->item->type;    
              $order_irem->description = $itemcart->item->description;  
              $order_irem->price = $itemcart->item->price;  
              $order_irem->save();
            }
            
            $this->cart::whereUserId(\Auth::user()->id)->delete();
                            
            $response = 'Compra Finalizada com Sucesso';
            
            if ($is_api) {
              return response()->json(['status'=>true,'msg'=>$response]);
            }else{
              return redirect('cliente/menu')->with('successMsg', $response);
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
    public function showOrders(){
      
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        } 
            
        try {
    
            $items = $this->order::whereUserId(\Auth::user()->id)->get();
            
            if ($is_api) {
              return response()->json(['data'=>$items]);
            }else{
              return view('customer.orders',compact('items'));
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
    public function showOrderItems(Order $order){
      
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        } 
            
        try {
    
            $items = $order->items;
                        
            if ($is_api) {
              return response()->json(['data'=>$order]);
            }else{
              return view('customer.order_items',compact('items','order'));
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
    public function orderCancel(Order $order){
      
        $is_api = false;
        if (request()->wantsJson() or str_contains(url()->current(), 'api/')) {
            $is_api = true;
        } 
            
        try {
    
            $order->update(['status'=>2]);
            
            $response = 'Solicitação de Cancelamento de Compra Enviada';
                        
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
}
