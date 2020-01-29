<?php 

namespace App\Exceptions\HandlersPowers;

use App\Exceptions\HandlersPowers\HandlerPower;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class NotFoundHttpExceptionHandler extends HandlerPower{
  
  public function run($exception){
    if ($exception instanceof NotFoundHttpException) {
      return 'Link =  '.\Request::url().' - '.trans('app.not_found');
    }else{
      return parent::run($exception);
    }
  }
}