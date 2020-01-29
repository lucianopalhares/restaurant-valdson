<?php 

namespace App\Exceptions\HandlersPowers;

use App\Exceptions\HandlersPowers\HandlerPower;
use Symfony\Component\Debug\Exception\FatalThrowableError;

class FatalThrowableErrorHandler extends HandlerPower{
  
  public function run($exception){
    if ($exception instanceof FatalThrowableError) {
      return $exception->getMessage();
    }else{
      return parent::run($exception);
    }
  }
}