<?php
class AP_Exception extends Exception
{
  private $ErrorMessage = "";
  
  public function __construct($code)
  {
    parent::_construct($this->getErrorMessage(), $code);
  }
  
  protected function setErrorMessage($_msg)
  {
    $this->ErrorMessage = $_msg;
  }
  
  protected function getErrorMessage()
  {
    return $this->ErrorMessage();
  }
}
?>