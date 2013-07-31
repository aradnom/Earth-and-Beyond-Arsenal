<?php
class effects_info {
	private $conn;
	private $id;
	private $results = array();

public function __construct($conn, $id) {
	$this->conn = $conn;
	$this->id = substr($id, 1);
	}
	
public function get_item_effects() {
	$effect_ids = $this->get_field("*", "item_effects", "ItemID", $this->id);	
	
	return $effect_ids;
}

public function get_description($base_id) {
	$effect_ids = $this->get_field("Description, Tooltip", "item_effect_base", "EffectID", $base_id);	
	
	return $effect_ids;
}
	
public function get_field($attribute, $table, $table_id, $id) {
  	$sql = "SELECT $attribute FROM ".$table." WHERE $table_id = $id";
  	$stmt = $this->conn->query($sql);	
	$this->results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$this->count = count($this->results);
	
	return $this->results;
 	}
}
?>