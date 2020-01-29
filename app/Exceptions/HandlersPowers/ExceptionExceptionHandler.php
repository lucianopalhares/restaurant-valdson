<?php 

namespace App\Exceptions\HandlersPowers;

use App\Exceptions\HandlersPowers\HandlerPower;
use Exception;

class ExceptionExceptionHandler extends HandlerPower{
  
  public function run($exception){
    if ($exception instanceof Exception) {
      return get_class($exception);
    }else{
      return parent::run($exception);
    }
  }
}