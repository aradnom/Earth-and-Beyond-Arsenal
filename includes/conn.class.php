<?php
class db_conn {
	private $dbHost;
	private $dbUser;
	private $dbPass;
	private $db;
	private $conn;
	private $port;
	
	public function __construct($dbHost, $dbUser, $dbPass, $db){
		$this->dbHost = $dbHost;
		$this->dbUser = $dbUser;
		$this->dbPass = $dbPass;
		$this->db = $db;				
	}
	
	public function make_conn(){
		try{
		if($this->dbHost == 'play.net-7.org' || $this->dbHost == 'net-7.org'){
		$this->port = '3307';	
		} else {
		$this->port = '3306';
		}
		$this->conn = new PDO("mysql:host=$this->dbHost;port=$this->port;dbname=$this->db", $this->dbUser, $this->dbPass);
		return $this->conn;
		}
	catch(PDOException $e){
		echo 'Cannot connect to database';
		exit;
		}
	}
}
?>