<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);
    class Settings {
        private $setting = array(); //allows no other class to access the array
        private static $instance; //allows no other class to utlize the instance variable

        private function __construct(){} //private constructor means no one can instantiate an object from the client

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
    echo 'This proves that my singleton object was created<br>';
    echo $set2->getSettings("color");

    //proxy class allows settings to be intialized from outside the class
    class SettingsProxy extends Settings{
        private $settings = NULL;

        public function __construct(){
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
    $set3->setSettings("resolution", "720");
    echo '<br><br> This proves that a singleton object was created through my proxy.. 1 means a boolean true<br>';
    echo $set3->isChosen();//returns true or in this case 1 if settings are set
    echo '<br><br> This proves that the singleton object created by the proxy can be called for output<br>';
    echo $set3->getSettings("color"); //returns the value from the key color to show its working with my singleton

    //adapter that extends settings proxy
    //it should adapt what SettingsProxy inherits to apply it to new settingsadapter objects
    class SettingsAdapter extends SettingsProxy{
        private $proxy;

        //this takes in my proxy object and sets it to the variable of the adapter class
        public function __construct(SettingsProxy $proxyIn){
            $this->proxy = $proxyIn;
        }
        //this retrieves the settings from the proxy object and sets it as the settings of the adapter object
        public function getSettings($key1, $key2){
            return "This color: " .$this->proxy->getSettings($key1). " with this resoltion: " .$this->proxy->getSettings($key2);
        }
    }

    //test values
    $settingAdapter = new SettingsAdapter($set3);//passes my proxy through the adapter
    echo '<br><br> This proves that my adapter pattern works after passing the proxy object through it<br>';
    echo $settingAdapter->getSettings("color", "resolution");
?>
