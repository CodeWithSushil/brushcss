<?php

class Files {

  public static function createFile(){
    $file = [];
    if(!file_exists('tuli.min.css')){
      touch('tuli.min.css');
    }
    self::readFiles();
  }

  public static function readFiles(){
    fopen('tuli.min.css','r+');
  }
}

Files::createFile();
