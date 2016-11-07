<?php
    class Stick{
        private $sticktype;
        private $stickbrand;
        private $curve;

        //this is a constructor that creates a stick of an arbitrary type and brand
        public function _construct($type, $brand, $curve){
            $this->sticktype = $type;
            $this->stickbrand = $brand;
            $this->curve = $curve;
        }
        //this function will return the brand based on input
        public function getBrand(){
            return $this->stickbrand;
        }
        //this function will return the type based on input
        public function getType(){
            return $this->sticktype;
        }
        public function getCurve(){
            return $this->curve;
        }
        public function broken(){
            $this->setState("broken");
        }
        public function newStick(){
            $this->setState("new");
        }
           
    }
    //factory class to create a stick of a given type and brand and has a subject attached to it to detect changes in state
    class StickFactory extends stickSubject{
        public static function create($type, $brand, $curve){
            return new Stick($type, $brand, $curve);
        }
    }

    //creation of a stick object that is assigned to a variable
    $vapor40 = StickFactory::create('Hockey Stick', 'Bauer', 'right');

    echo 'This is the variable output from my stick factory class<br>';
    print_r($vapor40->getType());

   
    //decorator class that will take in a stick and show the curve and has an observer class attached to it to be notified of changes
    class StickDecorator extends stickObserver{
        protected $stick;
        protected $curve;

        //takes in a stick object and makes sure the curve is set to that of the current stick object
        public function _construct(Stick $stick_in){
            $this->stick = $stick_in;
            $this->resetCurve();
        }
        //makes sure the curve is that of the current stick
        function resetCurve(){
            $this->curve = $this->stick->getCurve();
        }
        //returns the current curve of the stick
        function showCurve(){
            return $this->curve;
        }

    }

    $stickDec = new StickDecorator($vapor40);
    echo '<br>This shows the output from my stick decorator class<br>';
    echo $stickDec->showCurve();

    //abstract class to create an observer object for the stick
    abstract class stickObserver{
        //checks if stick is an object and if it is an instance of the subject
        public function _construct($stick = null){
            if(is_object($stick) && $stick instanceof stickSubject){
                $stick->attach($this);
            }
        }
        //if the update method exits it updates teh state of the stick in an array
        public function update($stick){
            if (method_exists($this, $stick->getState())){
                call_user_func_array(array($this, $stick->getState()), array($stick));
            }
        }
    }

    //abstact class that creates a subject on the stick for the observer
    abstract class stickSubject{
        protected $observerobj;
        protected $state;

        //constructs the initial observer array and sets the state to null
        public function _construct(){
            $this->observerobj = array();
            $this->state = null;
        }
        //function to allow the stick observer to attach to an object
        public function attach(stickObserver $observer){
            $i = array_search($observer, $this->observerobj);
            if($i == false){
                $this->observer[] = $observer;
            }
        }
        //function that allows the observer to detach from the object if it exists in the array
        public function detach(stickObserver $observer){
            if(!empty($this->observerobj)){
                $i = array_search($observer, $this->observerobj);
                if($i !== false){
                    unset($this->observerobj[$i]);
                }
            }
        }
        //function that returns the state of the object
        public function getState(){
            return $this->state;
        }
        //function that sets the state of the object
        public function setState($state){
            $this->state = $state;
            $this->notify();
        }
        //function that notifies if there is an update in the state of the object
        public function notify(){
            if(!empty($this->observerobj)){
                foreach($this->observerobj as $observer){
                    $observer->update($this);
                }
            }
        }
        //function that returns all observers
        public function getObservers(){
            return $this->observerobj;
        }
    }

$vapor60 = StickFactory::create('Hockey Stick', 'Bauer', 'right');
$vapor60->attach(new StickDecorator());

echo '<br>This is the output from a new stick instance after an observer is attached<br>';
print_r($vapor60);
    


?>