<?php 

namespace App\Exceptions\HandlersPowers;

use App\Exceptions\HandlersPowers\HandlerPower;
use Facade\Ignition\Exceptions\ViewException;

class ViewExceptionHandler extends HandlerPower{
  
  public function run($exception){
    if ($exception instanceof ViewException) {
      return $exception->getMessage();
    }else{
      return parent::run($exception);
    }
  }
}