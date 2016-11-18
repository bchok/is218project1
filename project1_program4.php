<?php

  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  abstract class AbstractEmailBuilder{
    abstract function getEmail();
  }

  abstract class AbstractEmailDirector{

    abstract function __construct(AbstractEmailBuilder $builderIn);
    abstract function buildEmail();
    abstract function getEmail();
  }

  class EmailBody{
    private $bodyText = NULL;

    function __construct(){
    }

    function showBody(){
      return $this->bodyText;
    }

    function setBody($bodyText){
      $this->bodyText = $bodyText;
    }
  }

  class EmailBuilder extends AbstractEmailBuilder{
    private $bodyText = NULL;

    function __construct(){
      $this->bodyText = new EmailBody();
    }
    function setBody($body_in){
      $this->bodyText->setBody($body_in);
    }
    function getEmail(){
      return $this->bodyText;
    }
    function showBody(){
      return $this->bodyText;
    }
  }

  class EmailDirector extends AbstractEmailDirector{
    private $builder = NULL;

    public function __construct(AbstractEmailBuilder $buildIn){
      $this->builder = $buildIn;
    }
    public function buildEmail(){
      $this->builder->setBody("Testing an Email Body for my Builder Pattern");
    }
    public function getEmail(){
      return $this->builder->showBody();
    }
  }

  $emailBuilder = new emailBuilder();
  $emailDirector = new EmailDirector($emailBuilder);
  $emailDirector->buildEmail();
  $email = $emailDirector->getEmail();
  echo $email->showBody();

 ?>
