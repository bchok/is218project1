<?php

    class Settings {
        private $setting = array(); //allows no other class to access the array
        private static $instance; //allows no other class to utlize the instance variable

        private function _construct(){} //private constructor means no one can instantiate an object from the client

        //creates an instance of the object if one does not already exist
        public static function getInstance(){
            if(empty(self::$instance)){
                self::$instance = new Settings();
            }
            return self::$instance; //returns that instance
        }
        //function is public to allow a new instance of the variable to set the settings
        public function setSettings($key, $val){
            $this->setting[$key] = $val;
        }
        //function is public so that the settings can be accessed by looking at the instance
        public function getSettings($key){
            return $this->setting[$key];
        }
    }

    //creating the initial instance and setting the color setting to red
    $set = Settings::getInstance();
    $set->setSettings("color", "red");
    unset($set); //removes the reference of $set to the instance

    //shows that the setting stays in tact after remove the reference above and referencing the already created instance from another variable
    $set2 = Settings::getInstance();
    echo $set2->getSettings("color");

    //proxy class allows settings to be intialized from outside the class
    class SettingsProxy extends Settings{
        private $isChosen = false; //this indicates if settings have been chosen
        private $isInitialized = false; //this indicates if the object has been intialized

        //this accesses the parent constructor of the class it extends 
        //in this case settings
        public function _construct(array $setting){
            parent::_construct($setting);
            
             if (count($setting) > 0){
                $this->isInitialized = true; //if something is in the array it will return true
                $this->isChosen = true; //if something is already in the array it will return true
            }
        }
        //allows you to set settings from the proxy using the same parent function
        public function setSettings($key, $val){
            $this->isChosen = true;
            parent::setSettings($key, $val);
        }
        //returns true if a setting is chosen
        public function isChosen(){
            return $this->isChosen;
        }
    }

    $set3 = new SettingsProxy(); //creates a new proxy
    $set3->setSettings("color", "blue"); //sets the settings 
    echo $set3->isChosen();//returns true or in this case 1 if settings are set
    echo $set3->getSettings("color"); //returns the value from the key color to show its working with my singleton 

    //adapter that extends settings proxy 
    //it should adapt what SettingsProxy inherits to apply it to new settingsadapter objects
    class SettingsAdapter extends SettingsProxy{
        private $setting;

        //this pulls applies the setting in a similar way to the proxy
        public function _construct(array $setting){
            $this->setting = $setting;
            parent::_construct($setting); //calls the parent class through the inheritance tree to construct the object
        }
        //allows access to settings the same way as the proxy
        public function getSettings($key){
            return $this->setting[$key];
        }
        //allows access to set settings the same way as the proxy
        public function setSettings($key, $val){
            parent::setSettings($key, $val);
        }
    }
    
    //test values
    $set4 = new SettingsAdapter();
    $set4->setSettings("color", "green");
    echo $set4->getSettings("color");
?>