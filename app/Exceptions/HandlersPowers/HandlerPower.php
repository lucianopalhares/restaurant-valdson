<?php

namespace App\Exceptions\HandlersPowers;

abstract class HandlerPower
{
  public $sucessor;
  
  public function setSucessor($sucessor){
    $this->sucessor = $sucessor;
  }
  public function run($exception){
    return $this->sucessor?$this->sucessor->run($exception):true;
  }
}