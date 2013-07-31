<?php
class effects_query {
	private $conn;
	private $id;
	private $results = array();
	
public function __contruct($conn){
	$this->conn = $conn;
	}
	
public function get_ids($query) {
  	$sql = "SELECT * FROM item_effect_base WHERE Description LIKE '%$query%'";
  	$stmt = $this->conn->query($sql);	
	$this->results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$this->count = count($this->results);
	
	return $this->results;
 	}
}
?>