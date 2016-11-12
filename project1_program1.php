<?php

    //interface that holds the function to create the actual stick object
    interface Stick {
        public function createStick();
    }

    //class for hockey stick that implements stick 
    //this allows for the call to the public createStick function 
    //while also allowing it to be customized based on the fact that it is a hockey stick
    class Hockey implements Stick{

        private $curve;

        public function _construct($cur){
            $this->curve = $cur;
        }

        public function createStick(){
            echo "Creating a hockey stick!";
        }
    }

    //class for a lacrosse stick that implements stick 
    //this allows for the call to the public createStick function 
    //while also allowing it to be customized based on the fact that it is a lacrosse stick
    class Lacrosse implements Stick{

        private $length;

        public function _construct($len){
            $this->length = $len;
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
    echo $hockeyStick->createStick();

    $lacrosseStick = $factory->create("Lacrosse");
    echo $lacrosseStick->createStick();

?>