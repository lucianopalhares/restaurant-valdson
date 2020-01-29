<?php 

namespace App\Exceptions\HandlersPowers;

use App\Exceptions\HandlersPowers\HandlerPower;
use Symfony\Component\HttpFoundation\File\Exception\FileException;

class FileExceptionHandler extends HandlerPower{
  
  public function run($exception){
    if ($exception instanceof FileException) {
      return $exception->getMessage();
    }else{
      return parent::run($exception);
    }
  }
}