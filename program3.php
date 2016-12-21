<h1> KATY CO. ARCHIVE </h1>
<?php
echo "<pre>";
//SIngleton
class dbConn{
 
 protected static $db;
  
  private function __construct() {
   
   try {
   self::$db = new PDO( 'mysql:host=sql1.njit.edu;dbname=kn96', 'kn96', 'm6m5PRHab' );
   self::$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
   }
   catch (PDOException $e) {
   echo "Connection Error: " . $e->getMessage();
   }
    }
     public static function getConnection() {
      
      if (!self::$db) {
        new dbConn();
        }
        return self::$db;
         }
}

$db = dbConn::getConnection();
print_r($db);

$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
$statement = $db->prepare('SELECT * FROM customers LIMIT 100');
$statement->execute();
while($result = $statement->fetch(PDO::FETCH_OBJ)) {
    $results[] = $result;
}
print_r($results);


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
/*class Archive
{
  private $custArch;
  function __construct(CustomerList $custList)
  {
    $this->setArch($custList);
  }
  
  function getArch() { return $this->custArch; }
  function setArch(CustomerList $custList) { $this->custArch = $custList; }
}

class Active
{
  private $custAct;
  function __construct(Archive  $arch)
  {
    $this->setAct($arch);
  }
  
  function getAct() { return $this->custAct; }
  function setAct(Archive $arch) { $this->custAct = $arch->getArch(); }
}
//----------------------
  $instance = ConnectDb::getInstance();
  $conn = $instance->getConnection();
  $q = "select customerName, contactFirstName, contactLastName, creditLimit from customers limit 10";
  $customers = new CustomerList();
  foreach($conn->query($q) as $row) {
    $temp = CustomerFactory::makeCustomer($row['customerName'], $row['contactFirstName'], $row['contactLastName'], $row['creditLimit'] );
    $customers->addCustomer($temp);
  }
  $archive = new Archive($customers);
  $active = new ACtive($archive);
  print_r($archive);
  echo "<br>";
  print_r($active);
  $q = "select customerName, contactFirstName, contactLastName, creditLimit from customers limit 100"; //more customers
  $customers1 = new CustomerList();
  foreach($conn->query($q) as $row)
  {
    $temp = CustomerFactory::makeCustomer($row['customerName'], $row['contactFirstName'], $row['contactLastName'], $row['creditLimit'] );
    $customers1->addCustomer($temp);
  }
  $archive = new Archive($customers1);
  echo "<hr>";
  print_r($archive);
  $conn->close();
*/

?>

