<?php
  error_reporting(E_ALL);
  ini_set('display_errors', 1);

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

    public function __construct($tax){
      $this->tax = $tax;
      echo "The tax for the USA is ". $tax ." as of today.";
    }

    public function update(){
      $this->tax = $this->getTax();
      echo "The new tax in the USA is: ". $this->tax ."as of today.";
    }

    public function getTax(){
      return f_rand(0.07, 0.09);
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
      echo "The new tax in Canada is: ". $this->tax ."as of today.";
    }

    public function getTax(){
      return f_rand(0.05, 0.07);
    }
  }

  function f_rand($min=0,$max=1,$mul=1000000){
    if ($min>$max){
      return false;
    }else{
      return mt_rand($min*$mul,$max*$mul)/$mul;
    }
  }

  $taxCalculator = new TaxCalculator();

  $tax1 = new USD(0.07);
  $tax2 = new CAD(0.05);

  $taxCalculator->addTax($tax1);
  echo $taxCalculator->updateTax();
  $taxCalculator->addTax($tax2);
  echo $taxCalculator->updateTax();



?>
