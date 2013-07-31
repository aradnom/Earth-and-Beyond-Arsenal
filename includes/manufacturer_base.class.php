<?php
class manufacturer_list {
	private $manus = array();
	private $conn;
	private $table = 'item_manufacturer_base';
	
	public function __construct($conn){
		$sql = "SELECT * FROM $this->table ORDER BY name";
		$this->conn = $conn;
		$stmt = $this->conn->query($sql);		
		$this->manus = $stmt->fetchAll();
	}
		
	public function get_manus(){
		return $this->manus;	
	}
}
?>