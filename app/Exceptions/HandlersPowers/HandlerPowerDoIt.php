<?php

namespace App\Exceptions\HandlersPowers;

abstract class HandlerPowerDoIt
{
  private $exceptions = [];
  private $exceptionDefault = null;

  public function start($exception,$request){ } //start  (in child)
  
  public function config(){ } //declare exceptions classes (in child)
   
  public function setExceptionType($exception,$is_default = false){
    $this->exceptions[] = $exception;
    if($is_default){
      $this->exceptionDefault = $exception;
    }
  }
  public function startAll($e,$request=null){
    
    $response = $this->getExceptionType($e);
        
    if (!$request) {
      $arr['status'] = false;
      $arr['msg'] = $response;
      return response()->json($arr); 
    }else{
      if(isset($_GET['redirect'])&&strlen($_GET['redirect'])>0){            
        return redirect($_GET['redirect'])->withInput($request->toArray())->withErrors($response);
      }else{
            //return $response;
        if($request->path()!='/'){
          return back()->withInput($request->toArray())->withErrors($response);
        }        
      }
    } 
  }
  private function getExceptionType($e){
    if(count($this->exceptions)>0){
      if(!$this->exceptionDefault){
        return "Handler Alert: 'Configure the Default Class Exception that present general Error' => ".get_class();
      }
      $lastSetted = null;
      foreach ($this->exceptions as $exception) {
        if($lastSetted){
          $lastSetted->setSucessor($exception);
          $lastSetted = $exception;
        }else{
          $lastSetted = $exception;
        }
      }  
      $this->exceptionDefault->setSucessor($lastSetted);
       
      return $this->exceptions[0]->run($e);   
    }else{
      return get_class($e);
    }
  }

}