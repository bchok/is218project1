<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  interface CreateNewTax{
    public function createTax();
  }
  class TaxFactory{
      public static function create($type){
          if($type == "USD"){
              return new USD(0.07);
          }
          if($type == "CAD"){
              return new CAD(0.05);
          }
      }
  }



  interface Observer{
    public function addTax(Taxes $tax);
  }

  class TaxCalculator implements Observer{
    private $taxes;

    public function __construct(){
      $this->taxes = array();
    }

    public function addTax(Taxes $tax){
      array_push($this->taxes, $tax);
    }

    public function updateTax(){
      foreach($this->taxes as $tax){
        $tax->update();
      }
    }
  }

  interface Taxes{
    public function update();
    public function getTax();
  }

  class USD implements Taxes{
    private $tax;
    public $taxStatus;

    public function __construct($tax){
      $this->tax = $tax;
      echo "The tax for the USA is ". $tax ." as of today.";
    }

    public function update(){
      $this->tax = $this->getTax();
      echo "The new tax in the USA is: ". $this->tax ." as of today.";
    }

    public function getTax(){
      return f_rand(0.07, 0.09);
    }
    public function createTax(){
        echo "Creating new USD tax!";
    }
    public function setTaxStatus($statusIn){
      $this->taxStatus = $statusIn;
    }
    public function getTaxStatus(){
      return $this->taxStatus;
    }
  }

  class CAD implements Taxes{
    private $tax;

    public function __construct($tax){
      $this->tax = $tax;
      echo "The tax for Canada is ". $tax ." as of today.";
    }

    public function update(){
      $this->tax = $this->getTax();
      echo "The new tax in Canada is: ". $this->tax ." as of today.";
    }

    public function getTax(){
      return f_rand(0.05, 0.07);
    }
    public function createTax(){
        echo "Creating new CAD tax!";
    }
  }

  function f_rand($min=0,$max=1,$mul=1000000){
    if ($min>$max){
      return false;
    }else{
      return mt_rand($min*$mul,$max*$mul)/$mul;
    }
  }

  $usd = TaxFactory::create("USD");
  $cad = TaxFactory::create("CAD");
  $taxCalculator = new TaxCalculator();

  $taxCalculator->addTax($usd);
  echo $taxCalculator->updateTax();
  $taxCalculator->addTax($cad);
  echo $taxCalculator->updateTax();

  class USDTaxValueMemento{
      public $taxStatus;

      function __construct(USD $usd){
          $this->setTaxStatus($usd);
      }

      public function setTaxStatus(USD $usd){
          $this->taxStatus = $usd->getTaxStatus();
      }

      public function getTaxValue(USD $usd){
          $usd->setTaxStatus($this->taxStatus);

      }
  }

  $usd2 = new USD(0.07);
  $usd2->setTaxStatus("current");
  $taxMemento = new USDTaxValueMemento($usd2);
  echo $taxMemento->taxStatus;



?>
