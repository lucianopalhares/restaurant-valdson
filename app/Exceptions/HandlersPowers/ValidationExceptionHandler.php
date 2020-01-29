<?php 

namespace App\Exceptions\HandlersPowers;

use App\Exceptions\HandlersPowers\HandlerPower;
use Illuminate\Validation\ValidationException;

class ValidationExceptionHandler extends HandlerPower{
  
  public function run($exception){
    if ($exception instanceof ValidationException) {
      return $exception->errors();
    }else{
      return parent::run($exception);
    }
  }
}