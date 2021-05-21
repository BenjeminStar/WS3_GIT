<?php
  class console{
    function __construct(){}

    public static function assert($expression, $message){
      console::log($expression);
      if($expression == true)
        $expression = "true";
      else if($expression == false)
        $expression = "false";
      echo  '<script>';
      echo    'console.assert('.$expression.', "'.$message.'");';
      echo  '</script>';
    }

    public static function clear(){
      echo  '<script>';
      echo    'console.clear();';
      echo  '</script>';
    }

    public static function count($var=null){
      echo  '<script>';
      echo    'console.count('.$var.');';
      echo  '</script>';
    }

    public static function countReset($var=null){
      echo  '<script>';
      echo    'console.countReset('.$var.');';
      echo  '</script>';
    }

    public static function debug($datas){
      echo  '<script>';
      if(is_array($datas))
        echo 'console.error('.json_encode($datas).');';
      else if(is_string($datas))
        echo 'console.error("'.$datas.'");';
      else
        echo 'console.error('.$datas.');';
      echo  '</script>';
    }

    public static function dir($datas){
      echo  '<script>';
      echo    'console.dir('.$datas.');';
      echo  '</script>';
    }

    public static function dirxml($datas){
      echo  '<script>';
      echo    'console.dirxml('.$datas.');';
      echo  '</script>';
    }


    public static function error($datas){
      echo  '<script>';
      if(is_array($datas))
        echo 'console.error('.json_encode($datas).');';
      else if(is_string($datas))
        echo 'console.error("'.$datas.'");';
      else
        echo 'console.error('.$datas.');';
      echo  '</script>';
    }

    public static function group($label="Group without label name"){
      echo  '<script>';
      echo    'console.group("'.$label.'");';
      echo  '</script>';
    }

    public static function groupCollapsed($datas){
      echo  '<script>';
      echo    'console.groupCollapsed("'.$datas.'");';
      echo  '</script>';
    }

    public static function groupEnd(){
      echo  '<script>';
      echo    'console.groupEnd();';
      echo  '</script>';
    }

    public static function info($datas){
      echo  '<script>';
      if(is_array($datas))
        echo 'console.info('.json_encode($datas).');';
      else if(is_string($datas))
        echo 'console.info("'.$datas.'");';
      else
        echo 'console.info('.$datas.');';
      echo  '</script>';
    }

    public static function log($datas){
      echo  '<script>';
      echo    'console.log('.json_encode($datas).');';
      echo  '</script>';
    }

    public static function table($datas){
      echo  '<script>';
      echo    'console.table('.json_encode($datas).');';
      echo  '</script>';
    }

    public static function time($label=null){
      echo  '<script>';
      echo    'console.time("'.$label.'");';
      echo  '</script>';
    }

    public static function timeEnd($label=null){
      echo  '<script>';
      echo    'console.timeEnd("'.$label.'");';
      echo  '</script>';
    }

    public static function trace($label=null){
      echo  '<script>';
      echo    'console.trace("'.$label.'");';
      echo  '</script>';
    }

    public static function warn($datas){
      echo  '<script>';
      if(is_array($datas))
        echo 'console.warn('.json_encode($datas).');';
      else if(is_string($datas))
        echo 'console.warn("'.$datas.'");';
      else
        echo 'console.warn('.$datas.');';
      echo  '</script>';
    }
  }

//How to use it?
/*
  first way:
  <?php
    include("console.php");
    console::log("...");
    console::warn("...");
    console::error("...");
    console::clear("...");
  ?>

  second way:
  <?php
    include("console.php");
    $console = new console();
    $console->log("...");
    $console->warn("...");
    $console->error("...");
    $console->clear("...");
*/
?>
