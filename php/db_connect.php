<?php
class MySqlDb{
    protected $host;
    protected $username;
    protected $password;
    protected $db;
    protected $conn;
    function __construct(){
      $this->host = "localhost";
      $this->username = "root" ;
      $this->password = "" ;
      $this->db = "flight_tracker" ;      
      $this->connect();      
    }
    protected function connect(){
      $conn = new mysqli($this->host, $this->username, $this->password, $this->db);
      if ($conn->connect_error) {
          die("Connection failed: " . $this->conn->connect_error);
      }
      return $conn;
    }
}