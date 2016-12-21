<?php
//Singleton
class dbconn 
{
  
  private static $instance = null;
  private $conn;
  
  private $host = 'sql1.njit.edu';
  private $user = 'kn96';
  private $pass = 'm6m5PRHab';
  private $db = 'kn96';
  
  
  private function __construct()
  {
    $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->db);
    if ($this->conn->connect_error){
      die("NOT CONNECTED " . $this->conn->connect_error);
      }
  }
  public static function getInstance(){
    if(!self::$instance){
	      self::$instance = new dbconn();
      }
   return self::$instance;
    }
  
  public function getConnection() {
    return $this->conn;
  }
}
//Factory
class Customer
{
  private $custName = "";
  private $contFirst = "";
  private $contLast = "";
  private $addressLine1 = "";
  private $Phone = 0;
  function __construct() {}
  function setName($name) {$this->custName = $name; }
  function setFirst($first) {$this->custFirst = $first; }
  function setLast($last) {$this->custLast = $last; }
  function setAdress($address) {$this->addressLine1 = $address; }
  function setPhone ($phone) {$this->phone = $phone;}

}
class Factory //creates customers given the content
{
  public static function makeCustomer($customerName, $contactFName, $contactLName, $addressLine1, $phone)
  {
    $cust = new Customer();
    $cust->setName($customerName);
    $cust->setFirst($contactFName);
    $cust->setLast($contactLName);
    $cust->setAdress($addressLine1);
    $cust->setPhone($phone);
   
    return $cust;
  }
}
class CustomerList 
{
  private $customers = array();
  private $custCount = 0;
  
  public function __construct() {}
  
  public function getCustCount() {return $this->custCount;}
  private function setCustCount($newCount) 
  {$this->custCount = $newCount;}
  public function getCust($numToGet) 
  {
    if ( (is_numeric($numToGet)) && ($numToGet <= $this->getCustCount() ) ) 
      {
	return $this->customers[$numToGet];
      } 
    else { return NULL; }
  }
  public function addCustomer(Customer $cust_in) 
  {
    $this->setCustCount($this->getCustCount() + 1);
    $this->customers[$this->getCustCount()] = $cust_in;
    return $this->getCustCount();
  }
}
