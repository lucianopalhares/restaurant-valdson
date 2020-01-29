<?php 

namespace App\Exceptions\HandlersPowers;

use App\Exceptions\HandlersPowers\HandlerPower;
use Illuminate\Database\QueryException;

class QueryExceptionHandler extends HandlerPower{
  
  public function run($exception){
    if ($exception instanceof QueryException) {
      return $exception->getMessage();
    }else{
      return parent::run($exception);
    }
  }
}