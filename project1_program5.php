<?php
  //interface for a factory pattern to create a new tax object
  interface CreateNewTax{
    public function createTax();
  }
  //the actually factory pattern that creates a tax object
  class TaxFactory{
      public static function create($type){
          if($type == "USD"){
              return new USD(0.07); //creates a new USD object with tax set at 0.07
          }
          if($type == "CAD"){
              return new CAD(0.05);//creates new CAD object with tax set at 0.05
          }
      }
  }


  //interface for the observer pattern
  interface Observer{
    public function addTax(Taxes $tax);
  }

  //concrete class that extends the observer interface
  class TaxCalculator implements Observer{
    private $taxes;

    //constructs an array and stores it in the variable taxes
    public function __construct(){
      $this->taxes = array();
    }

    //function that satisifies the interface of the observer
    //it takes in a Taxes object and pushes the variable tax into the array created above
    public function addTax(Taxes $tax){
      array_push($this->taxes, $tax);
    }

    //update functino for the observer
    //this will update the tax to a new value when it is called
    public function updateTax(){
      foreach($this->taxes as $tax){
        $tax->update();
      }
    }
  }

  //this is the taxes interface
  //this is passed through the observer interface and is used in the concrete class above that implements observer
  interface Taxes{
    public function update();
    public function getTax();
  }

  //concrete class that implements taxes and will eventually be passed through the observer
  class USD implements Taxes{
    private $tax;
    public $taxStatus;

    //constructs a new USD object with a tax value that is passed through
    public function __construct($tax){
      $this->tax = $tax;
      echo "The tax for the USA is ". $tax ." as of today.";
    }
    //this is the update function that satisfies both the Taxes and Observer interface
    //it will update the tax with a new random value between the set boundaries in the class
    public function update(){
      $this->tax = $this->getTax();
      echo "The new tax in the USA is: ". $this->tax ." as of today.";
    }
    //this will return a new random tax value between the set boundaries
    public function getTax(){
      return f_rand(0.07, 0.09);
    }
    //this is a dummy function really
    //it is there to satisfy the interface of the factory pattern
    public function createTax(){
        echo "Creating new USD tax!";
    }
    //this is here to satisfy the memento pattern below
    //this sets the tax to either being current or new based on the user input
    public function setTaxStatus($statusIn){
      $this->taxStatus = $statusIn;
    }
    //this simply returns the status set above
    public function getTaxStatus(){
      return $this->taxStatus;
    }
  }
  //concrete class that implements taxes and will eventually be passed through the observer
  class CAD implements Taxes{
    private $tax;

    //constructs a new CAD object with a tax value that is passed through
    public function __construct($tax){
      $this->tax = $tax;
      echo "The tax for Canada is ". $tax ." as of today.";
    }

    //this is the update function that satisfies both the Taxes and Observer interface
    //it will update the tax with a new random value between the set boundaries in the class
    public function update(){
      $this->tax = $this->getTax();
      echo "The new tax in Canada is: ". $this->tax ." as of today.";
    }

    //this will return a new random tax value between the set boundaries
    public function getTax(){
      return f_rand(0.05, 0.07);
    }
    //this is a dummy function really
    //it is there to satisfy the interface of the factory pattern
    public function createTax(){
        echo "Creating new CAD tax!";
    }
  }
  //this is a function to return a decimal value between two bounds when f_rand is called above
  function f_rand($min=0,$max=1,$mul=1000000){
    if ($min>$max){
      return false;
    }else{
      return mt_rand($min*$mul,$max*$mul)/$mul; //returns a random value between 0 and 1 it multiplies it by the multiply and divides it to ensure it is the proper decimal
    }
  }

  //test values to create the USD and CAD objects with the factory pattern
  echo '<br><br> This is value of the output from the observer after the factory object has already been passed through it<br><br>';
  $usd = TaxFactory::create("USD");
  echo '<br> <br>This just proves that the USD tax was created by the factory pattern<br>';
  $usd->createTax();
  $cad = TaxFactory::create("CAD");
  echo '<br><br>This just proves that the CAD tax object was created by the factory<br>';
  $cad->createTax();
  $taxCalculator = new TaxCalculator(); //creates a new taxcalculator for the observer pattern

  echo '<br><br> This is value of the output from the observer after the factory object has been updated by the observer<br>';
  $taxCalculator->addTax($usd);//passes the factory object through the observer pattern
  echo $taxCalculator->updateTax(); //call to update the tax from the observer
  $taxCalculator->addTax($cad); //passes factory CAD object through the observer pattern
  echo $taxCalculator->updateTax(); //call to update the tax on the object

  //memento class to store the status of the USD object
  class USDTaxValueMemento{
      public $taxStatus;

      //constructs an object using the USD object created above
      function __construct(USD $usd){
          $this->setTaxStatus($usd);
      }
      //lets the tax status for the new memento be set
      public function setTaxStatus(USD $usd){
          $this->taxStatus = $usd->getTaxStatus();
      }
      //allows the new tax status for the memento object to be retrieved
      public function getTaxValue(USD $usd){
          $usd->setTaxStatus($this->taxStatus);

      }
  }
  //test values to prove it works
  echo '<br><br>This is the creation of a new USD object for use by the memento<br>';
  $usd2 = new USD(0.07); //creates a new USD object
  $usd2->setTaxStatus("current");//sets the status of that object
  $taxMemento = new USDTaxValueMemento($usd2); //usd object is passed through the class and stored in the memento
  echo '<br><br> This is the call to the tax status from the memento to prove that it works<br>';
  echo $taxMemento->taxStatus; //outputs the value from the memento



?>
