<?php
class drop_info {
	private $conn;
	private $id;
	private $results = array();

public function __construct($conn, $id) {
	$this->conn = $conn;
	$this->id = substr($id, 1);
	}

public function get_mob_ids() {
	$mob_ids = $this->get_field("mob_id", "mob_items", "item_base_id", $this->id);	
	
	return $mob_ids;
}

public function get_mob_name($mob_id) {
	$name = $this->get_field("name", "mob_base", "mob_id", $mob_id);
	
	return $name[0]['name'];
}

public function get_mob_level($mob_id) {
	$level = $this->get_field("level", "mob_base", "mob_id", $mob_id);
	
	return $level[0]['level'];
}

public function get_drop_chance($mob_id) {
	$sql = "SELECT drop_chance FROM mob_items WHERE mob_id = $mob_id AND item_base_id = $this->id";
  	$stmt = $this->conn->query($sql);	
	$this->results = $stmt->fetchAll(PDO::FETCH_ASSOC);
	$this->count = count($this->results);
	
	return $this->results[0]['drop_chance'];
}

public function get_spawn_locations($mob_id) {
	$spawn_ids = $this->get_field("spawn_group_id", "mob_spawn_group", "mob_id", $mob_id);
	
	return $spawn_ids;
}

public function get_sector_ids($spawn_ids) {
	for($i = 0; $i < count($spawn_ids); $i++){
	$sector_ids[$i] = $this->get_field("sector_id", "sector_objects", "sector_object_id", $spawn_ids[$i]['spawn_group_id']);
	}
	
	return $sector_ids;
}

public function get_sector_names($sector_ids) {
	for($i = 0; $i < count($sector_ids); $i++){
	$sector_names[$i] = $this->get_field("name", "sectors", "sector_id", $sector_ids[$i][0]['sector_id']);
	}
	
	return $sector_names;	
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