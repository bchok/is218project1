<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

  class StringCreator{
    private $someString;

    public function __construct($someString){
      $this->someString = $someString;
    }
    public function getString(){
      return $this->someString;
    }
  }

  class StringFactory{
    public static function create($someString){
      return new StringCreator($someString);
    }
  }

  $test = StringFactory::create("hello world");
  $test2 = StringFactory::create("TEST UPPER STRING");
  //print_r($test->getString());
  echo $test->getString();
  echo $test2->getString();

  /**class StrategyContext{
    private $strategy = NULL;

    public function __construct($strategy_id){
      switch($strategy_id){
        case "U":
          $this->strategy = new StrategyUpper();
          break;
        case "L":
          $this->strategy = new StrategyLower();
          break;
        default:
          echo 'Invalid Input';
          break;
      }
    }
    public function showString($someString){
      $this->strategy->showString($someString);
    }
  }**/

  interface StrategyInterface{
    public function showString($someString);
  }

  class StrategyUpper implements StrategyInterface{
    public function showString($someString){
      $stratString = $someString->getString();
      return strtoupper($stratString);
    }
  }

  class StrategyLower implements StrategyInterface{
    public function showString($someString){
      $stratString = $someString->getString();
      return strtolower($stratString);
    }
  }

  $stratU = new StrategyUpper();
  echo $stratU->showString($test);

  $stratL = new StrategyLower();
  echo $stratL->showString($test2);

  echo 'Done';








?>
