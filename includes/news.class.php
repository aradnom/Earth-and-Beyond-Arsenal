<?php
class news {
	private $results = array();
	
public function __construct($conn) {
	$this->conn = $conn;
	}
	
public function get_articles() {
	$sql = "SELECT * FROM news WHERE status = 1 ORDER BY id DESC";
	$stmt = $this->conn->query($sql);	
	$this->results = $stmt->fetchAll();
	
	return $this->results;
	}
}
?>