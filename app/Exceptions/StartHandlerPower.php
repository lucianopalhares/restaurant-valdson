<?php

namespace App\Exceptions;

use App\Exceptions\HandlersPowers\ModelNotFoundExceptionHandler;
use App\Exceptions\HandlersPowers\QueryExceptionHandler;
use App\Exceptions\HandlersPowers\ValidationExceptionHandler;
use App\Exceptions\HandlersPowers\NotFoundHttpExceptionHandler;
use App\Exceptions\HandlersPowers\MethodNotAllowedHttpExceptionHandler;
use App\Exceptions\HandlersPowers\ViewExceptionHandler;
use App\Exceptions\HandlersPowers\FatalThrowableErrorHandler;
use App\Exceptions\HandlersPowers\RelationNotFoundExceptionHandler;
use App\Exceptions\HandlersPowers\ExceptionExceptionHandler;
use App\Exceptions\HandlersPowers\DefaultExceptionHandler;
use App\Exceptions\HandlersPowers\FileExceptionHandler;

use App\Exceptions\HandlersPowers\HandlerPowerDoIt;

class StartHandlerPower extends HandlerPowerDoIt
{
  // @start
  // dont remove nothing here
  public function start($exception,$request = null){
    $this->config();//run the setted classes
    if(request()->wantsJson()){
      $request = null;
    }
    return parent::startAll($exception,$request);//start here   
  }
  // @config
  // add here the exceptions classes
  // put true in the default exception class with the general error
  public function config(){
    //classes already declared - start
    parent::setExceptionType(new ModelNotFoundExceptionHandler());
    parent::setExceptionType(new QueryExceptionHandler());
    parent::setExceptionType(new ValidationExceptionHandler());
    parent::setExceptionType(new NotFoundHttpExceptionHandler());
    parent::setExceptionType(new MethodNotAllowedHttpExceptionHandler());
    parent::setExceptionType(new ViewExceptionHandler());
    parent::setExceptionType(new FatalThrowableErrorHandler());
    parent::setExceptionType(new RelationNotFoundExceptionHandler());
    parent::setExceptionType(new FileExceptionHandler()); 
    //classes already declared - end    
    parent::setExceptionType(new ExceptionExceptionHandler());   
    parent::setExceptionType(new DefaultExceptionHandler(),true);//true = the default class error
  }
}