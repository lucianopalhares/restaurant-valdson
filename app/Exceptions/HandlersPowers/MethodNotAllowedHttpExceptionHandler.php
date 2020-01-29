<?php 

namespace App\Exceptions\HandlersPowers;

use App\Exceptions\HandlersPowers\HandlerPower;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;

class MethodNotAllowedHttpExceptionHandler extends HandlerPower{
  
  public function run($exception){
    if ($exception instanceof MethodNotAllowedHttpException) {
      return $exception->getMessage();
    }else{
      return parent::run($exception);
    }
  }
}