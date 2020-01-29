<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Collection;

class RestaurantController extends Controller
{
    protected $model;
    
    public function __construct(\App\Restaurant $model){
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
        return view('admin.restaurant.index',compact('items'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function states()
    {        
        $ufs_array = array();
        $ufs_array[] = array('code' => 'AC','name' => 'Acre');
        $ufs_array[] = array('code' => 'AL','name' => 'Alagoas');
        $ufs_array[] = array('code' => 'AP','name' => 'Amapá');
        $ufs_array[] = array('code' => 'AM','name' => 'Amazonas');
        $ufs_array[] = array('code' => 'BA','name' => 'Bahia');
        $ufs_array[] = array('code' => 'CE','name' => 'Ceara');
        $ufs_array[] = array('code' => 'DF','name' => 'Distrito Federal');
        $ufs_array[] = array('code' => 'ES','name' => 'Espirito Santo');
        $ufs_array[] = array('code' => 'GO','name' => 'Goiás');
        $ufs_array[] = array('code' => 'MA','name' => 'Maranhão');
        $ufs_array[] = array('code' => 'MT','name' => 'Mato Grosso');
        $ufs_array[] = array('code' => 'MS','name' => 'Mato Grosso do Sul');
        $ufs_array[] = array('code' => 'MG','name' => 'Minas Gerais');
        $ufs_array[] = array('code' => 'PA','name' => 'Pará');
        $ufs_array[] = array('code' => 'PB','name' => 'Paraíba');
        $ufs_array[] = array('code' => 'PR','name' => 'Paraná');
        $ufs_array[] = array('code' => 'PE','name' => 'Pernambuco');
        $ufs_array[] = array('code' => 'PI','name' => 'Piauí');
        $ufs_array[] = array('code' => 'RJ','name' => 'Rio de Janeiro');
        $ufs_array[] = array('code' => 'RN','name' => 'Rio Grande do Norte');
        $ufs_array[] = array('code' => 'RS','name' => 'Rio Grande do Sul');
        $ufs_array[] = array('code' => 'RO','name' => 'Rondônia');
        $ufs_array[] = array('code' => 'RR','name' => 'Roraima');
        $ufs_array[] = array('code' => 'SC','name' => 'Santa Catarina');
        $ufs_array[] = array('code' => 'SP','name' => 'São Paulo');
        $ufs_array[] = array('code' => 'SE','name' => 'Sergipe');
        $ufs_array[] = array('code' => 'TO','name' => 'Tocantins');
        return collect($ufs_array);
    }
    public function create()
    {  
        $ufs = $this->states();
        return view('admin.restaurant.form',compact('ufs'));
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
              'name' => 'required',
              'address' => 'required',
              'number' => 'nullable',
              'district' => 'required',
              'state' => 'required',
              'city' => 'required',
              'opening_hours_start' => 'required',
              'opening_hours_end' => 'required',
              'phone' => 'nullable',
              'mobile' => 'required',
              'whatsapp' => 'nullable',
              'logo' => 'image|mimes:png|max:1500',
              'cnpj' => 'required',
              'insc_est' => 'required',
              'about_us' => 'nullable'
          ];            
          
        }else{
          
          $rules = [
              'name' => 'required',
              'address' => 'required',
              'number' => 'nullable',
              'district' => 'required',
              'state' => 'required',
              'city' => 'required',
              'opening_hours_start' => 'required',
              'opening_hours_end' => 'required',
              'phone' => 'nullable',
              'mobile' => 'required',
              'whatsapp' => 'nullable',
              'logo' => 'required|image|mimes:png|max:1500',
              'cnpj' => 'required',
              'insc_est' => 'required',
              'about_us' => 'nullable'
          ];          
        }

        $this->validate($request, $rules);   

        if($update){

          $model = $this->model->findOrFail($request->id);
          $image_before_update = $model->logo;
                
        }else{
          $model = new $this->model;
        }

        $model->name = $request->name;
        $model->address = $request->address;
        $model->number = $request->number;
        $model->district = $request->district;
        $model->state = $request->state;
        $model->city = $request->city;
        $model->opening_hours_start = $request->opening_hours_start;
        $model->opening_hours_end = $request->opening_hours_end;
        $model->phone = $request->phone;
        $model->mobile = $request->mobile;
        $model->whatsapp = $request->whatsapp;
        $model->cnpj = $request->cnpj;
        $model->insc_est = $request->insc_est;
        $model->about_us = $request->about_us;
                
        if(strlen($request->logo)>0){
          
          $model->logo = $request->logo;
           
        }        
        $model->save();
            
        $response = 'Restaurante ';
            
        if($update){
          $response .= 'Atualizado(a) com Sucesso!';
        }else{
          $response .= 'Cadastrado(a) com Sucesso!';
        }              
                    
        if($file   =   $request->file('logo')) {
              
          $image_name      =   'Logo_stick.'.$file->getClientOriginalExtension();

          $target_path    =   public_path('frontend/images');
          $is_uploaded = $file->move($target_path, $image_name);
                    
          if ($is_uploaded) {
                        
              $update_model = $this->model->findOrFail($model->id);
              $update_model->logo = $image_name;
              $update_model->save();
                        
              if($update){
                $storage = Storage::disk('public');
                if(\File::exists('frontend/images/'.$image_before_update)) {
                    \File::delete('frontend/images/'.$image_before_update);
                }  
              }
          } else {
              $response .= ' (o logo não foi salvo)';
          }
            

        }else{
          if($update){
            if(strlen($image_before_update)>0){
                  
              if(!\File::exists('frontend/images/'.$image_before_update)) {
                  $response .= ' (o logo não foi salvo)';
              }                  
            }else{
              $response .= ' (o logo não foi salvo)';
            }
          }else{
            $response .= ' (o logo não foi salvo)';
          }
        }    
            
        if (request()->wantsJson()) {
          return response()->json(['status'=>true,'msg'=>$response]);
        }else{
          return redirect('admin/restaurant/'.$model->id)->with('successMsg',$response);
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
        $item = $this->model::findOrFail($id);
        $ufs = $this->states();
        $show = true;
        return view('admin.restaurant.form',compact('item','ufs','show'));
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
        $ufs = $this->states();
        return view('admin.restaurant.form',compact('item','ufs'));
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
        if (file_exists('frontend/images/'.$item->logo))
        {
            unlink('frontend/images/'.$item->logo);
        }
        $item->delete();
        return back()->with('successMsg','Restaurante Deletado com Sucesso!');
    }
}
