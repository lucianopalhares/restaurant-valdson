<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/errors',function(){
  return view('error');
});
Route::get('/',function(){
  return redirect('/login');
});
Route::get('/verify-role',function(){
  if(\Auth::user()->hasAnyRoles('Admin')){
    return redirect('admin/dashboard');
  }elseif(\Auth::user()->hasAnyRoles('Cliente')){
    return redirect('cliente/dashboard');
  }
});

//Route::get('/','HomeController@index')->name('welcome');
//Route::post('/reservation','ReservationController@reserve')->name('reservation.reserve');
//Route::post('/contact','ContactController@sendMessage')->name('contact.send');

Route::get('/cadastro-cliente',function(){
  return view('auth.register');
});
Route::post('salvar-cliente','HomeController@storeCustomer');

Auth::routes();

Route::group(['prefix'=>'cliente','middleware'=>['auth'],'namespace'=>'Customer','as'=>'Customer'], function (){

    Route::get('dashboard','DashboardController@index');
    Route::get('menu','DashboardController@items');
    Route::get('promocoes','DashboardController@promotions');
    Route::get('adicionar-carrinho/{item}','DashboardController@addCart');
    Route::get('esvaziar-carrinho','DashboardController@emptyCart');
    Route::get('carrinho','DashboardController@showCart');  
    Route::post('finalizar-compra','DashboardController@storeOrder');
    Route::get('compras','DashboardController@showOrders');
    Route::get('compra/{order}','DashboardController@showOrderItems');
    Route::get('cancelar-compra/{order}','DashboardController@orderCancel');
});

Route::group(['prefix'=>'admin','middleware'=>['auth','admin'],'namespace'=>'Admin','as'=>'Admin'], function (){

    Route::get('dashboard','DashboardController@index', array("as"=>"dashboard","name"=>"dashboard"));
    Route::resource('cargo','RoleController', array("as"=>"cargo","name"=>"cargo"));
    Route::resource('restaurante','RestaurantController', array("as"=>"restaurante","name"=>"restaurante"));  
    Route::resource('formaPagamento','PaymentWayController', array("as"=>"formaPagamento","name"=>"formaPagamento"));
    Route::resource('categoria','CategoryController', array("as"=>"categoria","name"=>"categoria"));
    
    Route::resource('cupom','CouponController', array("as"=>"cupom","name"=>"cupom"));
    Route::resource('cliente','CustomerController', array("as"=>"cliente","name"=>"cliente"));
    Route::resource('vendas','OrderController', array("as"=>"vendas","name"=>"vendas"));
    Route::get('status-venda/{venda}','OrderController@orderStatus', array("as"=>"tatus-venda","name"=>"tatus-venda"));
    Route::get('items-venda/{venda}','OrderController@showOrderItems', array("as"=>"items-venda","name"=>"items-venda"));
    
});
Route::group(['prefix'=>'restaurante','middleware'=>['auth','admin'],'namespace'=>'Restaurant','as'=>'Restaurant'], function (){
         
  Route::group([
        'prefix' => '{restaurantSlug}',
        'middleware' => 'restaurant'
    ], function () {
        Route::get('dashboard', [
            'as'   => 'dashboard',
            'uses' => 'DashboardController@index',
        ]);
         
        Route::resource('cardapio','ItemController', array("as"=>"cardapio","name"=>"cardapio"));
        Route::resource('restaurante_categoria','RestaurantCategoryController', array("as"=>"restaurante_categoria","name"=>"restaurante_categoria"));
        Route::resource('promocao','PromotionController', array("as"=>"promocao","name"=>"promocao"));
        Route::get('ativar-promocao/{promocao}','PromotionController@active', array("as"=>"ativar-promocao","name"=>"ativar-promocao"));
        
  });
});

      //Route::get('dashboard', 'DashboardController@index');
      //Route::resource('slider','SliderController');
      //Route::resource('category','CategoryController');
      //Route::resource('item','ItemController');
      //Route::get('reservation','ReservationController@index')->name('reservation.index');
      //Route::post('reservation/{id}','ReservationController@status')->name('reservation.status');
      //Route::delete('reservation/{id}','ReservationController@destory')->name('reservation.destory');

      //Route::get('contact','ContactController@index')->name('contact.index');
      //Route::get('contact/{id}','ContactController@show')->name('contact.show');
      //Route::delete('contact/{id}','ContactController@destroy')->name('contact.destroy');
      

      

    
