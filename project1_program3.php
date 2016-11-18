<?php

  //this is the concrete class that the factory utlizes to create some random strings
  //it implements my string decorater to append a string to the end of the user string
  class StringCreator extends stringAlterer{
    private $someString;

    //constructs the string based on user input
    public function __construct($someString){
      $this->someString = $someString;
    }
    //returns the string
    public function getString(){
      return $this->someString;
    }
    //needed to satisfy the requirements of the abstract function in my strategy pattern
    public function getNewString(){
      return $this->someString;
    }
  }

  //this is the actual factory class that calls the concrete string creator
  class StringFactory{
    public static function create($someString){
      return new StringCreator($someString);
    }
  }

  //test values to the factory pattern
  $test = StringFactory::create("hello world");
  $test2 = StringFactory::create("TEST UPPER STRING");
  echo 'This shows that a string was created with my factory<br>';
  echo $test->getString(); //outputs the string for test
  echo '<br><br>This shows that a second string was created by my factory pattern<br>';
  echo $test2->getString(); //outputs the string for test2

  //this was another part of the program I tried to create to allow me to choose a strategy
  //solely based on user input rather than calling the strategy
  //it was not required for the strategy pattern and i could not get it to work right so
  //i commented it out
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

  //strategy interface
  interface StrategyInterface{
    public function showString($someString); //function that the strategy utilizes
  }

  //class that takes a string and uppercases it all
  //it implements my strategy interface
  class StrategyUpper implements StrategyInterface{
    public function showString($someString){
      $stratString = $someString->getString();//takes the user string from the factory
      return strtoupper($stratString);//uppercases the string
    }

  }

  //class that takes a string and lowercases it all
  //it implements my strategy interface
  class StrategyLower implements StrategyInterface{
    public function showString($someString){
      $stratString = $someString->getString(); //takes user string from factory
      return strtolower($stratString); //lowercases it
    }
  }

  //test values for the strategy
  $stratU = new StrategyUpper(); //creates new strategy
  echo '<br><br>This shows that a new string is created with my factory object based on the strategy it is passed through<br>';
  echo $stratU->showString($test); //takes factory object and alters it based on the strategy
  $stratL = new StrategyLower(); //crates new strategy
  echo '<br><br> This shows that another new string is created based on the strategy that the factory object is passed through<br>';
  echo $stratL->showString($test2); //takes factory object and alters it based on the strategy


  //abstract class that my decorator uses
  abstract class stringAlterer{
    abstract function getNewString(); //returns the new string decorated
  }

  //the actual decorator class that constructs a new string for the decorator based on the object passed in
  //my string creator extends this allowing the object to be passed in
  abstract class stringDecorator extends stringAlterer{
    protected $stringAlterer;
    function __construct(stringAlterer $stringAlterer){
      $this->stringAlterer = $stringAlterer;
    }
  }

  //decorator class that appends a string to the end of the uppercased string
  class upperStringDecorator extends stringDecorator{
    function getNewString(){
      return $this->stringAlterer->getNewString(). " :This upper cased string has been decorated";
    }
  }

  //decorator class taht appends a string to the end of the lowercased string
  class lowerStringDecorator extends stringDecorator{
    function getNewString(){
      return $this->stringAlterer->getNewString(). " : This lower cased string has been decorated";
    }
  }

  //test values for the decorator passing a string object through
  $sDecTest = new lowerStringDecorator($test); //takes string object and passes it through the decorator
  echo '<br><br>This shows that the string that is created by the factory can be decorated and altered<br>';
  echo $sDecTest->getNewString(); //outputs the decorated string









?>
