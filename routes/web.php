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

Auth::routes();

Route::group(['prefix'=>'admin','middleware'=>'auth','namespace'=>'Admin','as'=>'Admin'], function (){

    Route::get('dashboard','DashboardController@index', array("as"=>"dashboard","name"=>"dashboard"));
    Route::resource('cargo','RoleController', array("as"=>"cargo","name"=>"cargo"));
    Route::resource('restaurante','RestaurantController', array("as"=>"restaurante","name"=>"restaurante"));  
    Route::resource('formaPagamento','PaymentWayController', array("as"=>"formaPagamento","name"=>"formaPagamento"));
    Route::resource('categoria','CategoryController', array("as"=>"categoria","name"=>"categoria"));
});
Route::group(['prefix'=>'usuario','middleware'=>'auth','namespace'=>'User','as'=>'User'], function (){
         
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
  });
});
      

    
