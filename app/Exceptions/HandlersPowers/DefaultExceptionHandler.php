<?php 

namespace App\Exceptions\HandlersPowers;

use App\Exceptions\HandlersPowers\HandlerPower;

class DefaultExceptionHandler extends HandlerPower{
  
  public function run($exception){
    return get_class($exception);
  }
}