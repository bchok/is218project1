<?php

    //interface that holds the function to create the actual stick object
    interface Stick {
        public function createStick();
    }

    //class for hockey stick that implements stick
    //it also extends stickLength which is an abstract class for my stickDecorator
    //this allows for the call to the public createStick function
    //while also allowing it to be customized based on the fact that it is a hockey stick
    class Hockey extends stickLength implements Stick{

        public $length = 0;
        public $productionState;


        function _construct($prodIn){
            $this->setProduction($prodIn);
        }
        public function setProduction($prodIn){
            $this->productionState = $prodIn;
        }
        public function getProduction(){
            return $this->productionState;
        }
        //returns the sticklength so it can be altered by my decorator class
        public function getStickLength(){
            return $this->length;
        }
        public function createStick(){
            echo "Creating a hockey stick!";
        }
    }

    //class for a lacrosse stick that implements stick
    //it also extends stickLength which is an abstract class for my stickDecorator
    //this allows for the call to the public createStick function
    //while also allowing it to be customized based on the fact that it is a lacrosse stick
    class Lacrosse extends stickLength implements Stick{

        public $length = 0;

        //returns the sticklength so it can be altered by my decorator class
        public function getStickLength(){
            return $this->length;
        }

        public function createStick(){
            echo "Creating a lacrosse stick!";
        }
    }

    //this is the actually factory class that creates the stick object
    //what it creates depends on the user input
    //if it is a hockey it will return a new hockey stick object, the same goes for lacrosse
    class StickFactory{
        public function create($type){
            if($type == "Hockey"){
                return new Hockey();
            }
            if($type == "Lacrosse"){
                return new Lacrosse();
            }
        }
    }

    //this creates a new object from the stick factory
    $factory = new StickFactory();

    //these take the stick object and create both a hockey and larosse stick from it and echo output to show its being created
    $hockeyStick = $factory->create("Hockey");
    echo 'This proves a new hockey object was created by my factory<br>';
    echo $hockeyStick->createStick();

    $lacrosseStick = $factory->create("Lacrosse");
    echo '<br><br> This proves that a new lacrosse object was created by my factory<br>';
    echo $lacrosseStick->createStick();


    //abstract class that holds the function getStickLength
    //it is abstract because it does not actually call the function
    abstract class stickLength{
        abstract function getStickLength();
    }

    //decorator class that extends stickLength so that it has access to getStickLength()
    //it is abstract because it does not actually call getSticklength() itself
    abstract class StickDecorator extends stickLength{
        protected $stickLength;
        function __construct(stickLength $stickLength){
            $this->stickLength = $stickLength;
        }
    }

    //decorator class for hockey stick that adds onto the stickLength and returns it
    //via getStickLength
    //number I picked is arbitrary at 155 to prove it works
    class hockeyStickDecorator extends StickDecorator{
        function getStickLength(){
            return $this->stickLength->getStickLength+155;
        }
    }

    //decorator class for lacrosse stick that adds onto the stickLength and returns it
    //via getStickLength
    //number I picked is arbitrary at 155 to prove it works
    class lacrosseStickDecorator extends StickDecorator{
        function getStickLength(){
            return $this->stickLength->getStickLength+60;
        }
    }

    //test objects to show that the decorator works
    //each object creates a new decorator object while
    //creating the original through the stickFactory
    $hStickTest = new hockeyStickDecorator(new Hockey());
    echo '<br><br> This proves that the sticklength of the hockey object was altered by my decorator<br>';
    echo $hStickTest->getStickLength();
    $lStickTest = new lacrosseStickDecorator(new Lacrosse());
    echo '<br><br> This proves that the sticklength of the lacrosse object was altered by my decorator<br>';
    echo $lStickTest->getStickLength();


    //it is my understanding that the memento class will save the current production state that
    //i set in my hockey class
    //it is similar to the undo button on the computer...it stores the state of the object at that point in time
    class hockeyProdMemento{
        public $productionState;

        function __construct(Hockey $hockey){
            $this->setProduction($hockey);
        }
        public function setProduction(Hockey $hockey){
            $this->productionState = $hockey->getProduction();
        }
        public function getProduction(Hockey $hockey){
            $hockey->setProduction($this->productionState);

        }
    }

    $h2 = new Hockey();
    $h2->setProduction("shipped1");



    //these are test objects to create the memento
    //it should store the productionstate of h2 into the memnto
    $hMemento = new hockeyProdMemento($h2); //stores the production state in the memento
    echo '<br><br> This proves that a memento object was created by passing a hockey object through it<br>';
    print_r($hMemento);//proves that the memento object was created and contains the production state of the hockey object above h2
    echo '<br><br> This just shows output from that hockey object by calling the memento<br>';
    echo $hMemento->productionState; //echos the production state that is stored in the memento to prove that it works












?>
