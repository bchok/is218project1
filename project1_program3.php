<?php

    
    interface StringOutputter{
        public function getStringValue();
    }
    //class to facilitate creation of strings
    class StringCreator implements StringOutputter{
        private $stringoutput;

        //echos that a new string is being created
        public function getStringValue(){
            echo "new string is being created";
        }
       //calls the strategy interface
       public function setOutput(StringOutputInterface $outputType){
            $this->stringoutput = $outputType;
        }
        //calls the function to load the output in the strategy interface
        public function loadOutput(){
            return $this->stringoutput->load();
        }
    }

    //factory that calls stringcreator to create new strings
    class StringFactory{
        public static function create(){
            return new StringCreator();
        }
    }

    $test = new StringFactory();//creates new string through the factory
    echo $test->getStringValue();//shows a string factory object proving it was created

    //strategy interface that will load differenent variations of the string
    interface StringOutputInterface{
        public function load();
    }

    //class that implements the interface to uppercase the entire string
    class UpperCasedString implements StringOutputInterface{
        public function load(){
            return strtoupper($somestring);
        }
    }
    //class that implements the interface to lowercase the entire string
    class LowerCasedString implements StringOutputInterface{
        public function load(){
            return strtolower($somestring);
        }
    }

    $test->setOutput(new UpperCasedString());
    echo $test->loadOutput();**/

    


?>