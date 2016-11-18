<?php

  error_reporting(E_ALL);
  ini_set('display_errors', 1);

  //abstract builder class to build emails
  //this is required for the builder pattern
  abstract class AbstractEmailBuilder{
    abstract function getEmail();//function that is required by the builder
  }

  //abstract class for the director portion of the builder pattern
  //this instructs the email builder on what to build
  abstract class AbstractEmailDirector{

    abstract function __construct(AbstractEmailBuilder $builderIn);
    abstract function buildEmail();
    abstract function getEmail();
  }

  //email body class that simply creates the body of an email
  class EmailBody extends EmailBodyChanger{
    private $bodyText = NULL;
    public $emailStatus;

    function __construct(){
    }

    function showBody(){
      return $this->bodyText; //returns Body
    }

    function setBody($bodyText){
      $this->bodyText = $bodyText;//sets the body text
    }
    function alterEmailBody(){
      return $this->bodyText; //required for the decorator class to alter the email body
    }
    function setEmailStatus($statusIn){
      $this->emailStatus = $statusIn; //required for the memento to capture the set email status, the user must be able to set emails status
    }
    function getEmailStatus(){
      return $this->emailStatus; //required for the memento to get the email status
    }
  }

  //concrete builder class for my builder pattern
  class EmailBuilder extends AbstractEmailBuilder{
    private $bodyText = NULL;

    //constructs a new email body object using the body text that is set by default
    function __construct(){
      $this->bodyText = new EmailBody();
    }
    //sets the body text to what the user inputs
    function setBody($body_in){
      $this->bodyText->setBody($body_in);
    }
    //required to satisfy the abstract email builder
    //it returns the email body
    function getEmail(){
      return $this->bodyText;
    }
    //required for the memento
    //it also returns the email body
    function showBody(){
      return $this->bodyText;
    }
  }

  //concrete director class for my director pattern
  class EmailDirector extends AbstractEmailDirector{
    private $builder = NULL;

    //constructs an abstract email builder
    //sets that to the builder variable
    public function __construct(AbstractEmailBuilder $buildIn){
      $this->builder = $buildIn;
    }
    //builds the email using the concrete class defined above for the email builder
    public function buildEmail(){
      $this->builder->setBody("Testing an Email Body for my Builder Pattern");
    }
    //required to satisfy the abstract class
    //returns the body of the email
    public function getEmail(){
      return $this->builder->showBody();
    }
  }
  //test values to prove that the builder pattern works
  $emailBuilder = new emailBuilder();
  $emailDirector = new EmailDirector($emailBuilder);
  $emailDirector->buildEmail();
  $email = $emailDirector->getEmail();
  echo $email->showBody();

  //abstract class for the decorator pattern
  abstract class EmailBodyChanger{
    abstract function alterEmailBody();
  }

  //this is the actual decorator class
  //it extends the emailbodychanger forcing my custom decortor to call it
  //it also constructs a new decorator object from that abstract class
  abstract class EmailBodyDecorator extends EmailBodyChanger{
    protected $emailBodyChanger;
    function __construct(EmailBodyChanger $emailBodyChanger){
      $this->emailBodyChanger = $emailBodyChanger;
    }
  }
  //welcome email decorator that extends my decorator class
  //it takes in the email body that was constructed above
  //since it has the properties of my email body class from the builder it can utilize show body
  //it then appends welcome to the mailing list at the end
  class WelcomeEmailDecorator extends EmailBodyDecorator{
    function alterEmailBody(){
      return $this->emailBodyChanger->showBody(). "<br><br> Welcome to the Mailing List!<br>";
    }
  }

  //test values to prove the decorator works
  $emailDecTest = new WelcomeEmailDecorator($email);
  echo $emailDecTest->alterEmailBody();

  //memento that saves the state of the email
  //ie. whether it has been sent or not
  class EmailStatusMemento{
      public $emailStatus;

      //takes in the email body and constructs an object with it
      function __construct(EmailBody $emailBody){
          $this->setEmailStatus($emailBody);
      }
      //sets the email status of the new memento object to that of the email body object it passed in
      public function setEmailStatus(EmailBody $emailBody){
          $this->emailStatus = $emailBody->getEmailStatus();
      }
      //allows the user to retrieve the email status through the memento of the email body object
      public function getEmailStatus(EmailBody $emailBody){
          $emailBody->setEmailStatus($this->emailStatus);

      }
  }

  //test values to prove the memento works
  $email2 = new EmailBody();
  $email2->setEmailStatus("sent to address");

  $emailMemento = new EmailStatusMemento($email2);
  echo $emailMemento->emailStatus;

 ?>
