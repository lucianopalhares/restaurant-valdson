<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Brian2694\Toastr\Facades\Toastr;
use App\Http\Controllers\Controller;

class ContactController extends Controller
{
    public $model;
    
    public function __construct(\App\Contact $model){
      $this->model = $model;
    }
    public function index()
    {
        $items = $this->model::all();
        return view('admin.contact.index',compact('items'));
    }
    public function show($id)
    {
        $item = $this->model::find($id);
        return view('admin.contact.show',compact('item'));
    }

    public function destroy($id)
    {
        $this->model::find($id)->delete();
        Toastr::success('Mensagem de Contato Deletada','Success',["positionClass" => "toast-top-right"]);
        return redirect()->back();
    }
}
