<?php 

namespace App\Exceptions\HandlersPowers;

use App\Exceptions\HandlersPowers\HandlerPower;
use Illuminate\Database\Eloquent\RelationNotFoundException;

class RelationNotFoundExceptionHandler extends HandlerPower{
  
  public function run($exception){
    if ($exception instanceof RelationNotFoundException) {
      return $exception->getMessage();
    }else{
      return parent::run($exception);
    }
  }
}