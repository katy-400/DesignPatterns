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