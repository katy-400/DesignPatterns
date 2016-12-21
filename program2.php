<h1>KATY CO. CUSTOMER LIST</h1>
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
  function profile()
  {
    echo "<h3>Business: $this->custName</h3>
         <b>Person to Contact: </b>  $this->custFirst $this->custLast <br>
         <b>Address:  </b>  $this->addressLine1 <br>
         <b>Phone: </b> $this->phone <br><br><br><br>";
  }
}
class CustomerFactory //creates customers given the content
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
//iterator
class CustomerIterator 
{
  protected $customers;
  protected $currCust = 0;
  public function __construct( CustomerList $custList_in) 
  {
    $this->customers = $custList_in;
  }
  public function getCurrentCust() 
  {
    if (($this->currCust > 0) && ($this->customers->getCustCount() >= $this->currCust)) 
      {
	return $this->customers->getCust($this->currCust);
      }
  }
  public function getNextCust() 
  {
    if ($this->hasNextCust()) 
      {
	return $this->customers->getCust(++$this->currCust);
      } 
    else 
      {
	return NULL;
      }
  }
  public function hasNextCust() 
  {
    if ($this->customers->getCustCount() > $this->currCust) 
      {
	return TRUE;
      } 
    else 
      {
	return FALSE;
      }
  }
}
$instance = dbconn::getInstance();
$conn = $instance->getConnection();
$q = "select customerName, contactFirstName, contactLastName, addressLine1, phone from customers limit 25";
$customers = new CustomerList();
foreach($conn->query($q) as $row) 
{
  $temp = CustomerFactory::makeCustomer($row['customerName'], $row['contactFirstName'], $row['contactLastName'], $row['addressLine1'], $row['phone'] );
  $customers->addCustomer($temp);
}
$custIter = new CustomerIterator($customers);
while($custIter->hasNextCust())
  {
    $cust = $custIter->getNextCust();
    echo $cust->profile();
  }
$conn->close();
?>