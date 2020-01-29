<?php 

namespace App\Exceptions\HandlersPowers;

use App\Exceptions\HandlersPowers\HandlerPower;
use Illuminate\Database\Eloquent\ModelNotFoundException;

class ModelNotFoundExceptionHandler extends HandlerPower{
  
  public function run($exception){
    if ($exception instanceof ModelNotFoundException) {
      return trans('app.not_found'); 
    }else{
      return parent::run($exception);
    }
  }
}