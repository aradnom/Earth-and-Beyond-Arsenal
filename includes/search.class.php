<?php
class query {
// Initializing all the search variables

// This variable controls the max numbers of displayed results
public 	$MAX_RESULTS = 100; 
// Connection variable passed from SQL connection object
private $conn;
// Table to be searched
private $table = 'item_base';
// Variable that contains the query to be searched for
private $search_query;
// Item level
private $level;
// Item manufacturer
private $manufacturer;
// Probably demarcated
private $manufacturer_nums = array();
// Item type
private $type;
// Item effects variable
private $special;
private $step;
private $sorter;
private $count;
private $viewed = 0;
private $session_sql;
private $nav_sql;
private $results = array();
private $OK = false;

public function __construct($conn) {
	$this->conn = $conn;
	}
	
public function run_search($sorter, $step, $manufacturer, $level, $type, $special) {
	// Type processor function.  Necessary because components/ores/other are handled differently than other types
	$type_prefix = $this->process_type();
	// Beginning of SQL query.  First run-through is without limiter to get total # of results
	if($special != null){
	$sql = "SELECT * FROM item_base JOIN item_effects ON item_base.id = item_effects.ItemID WHERE item_effects.item_effect_base_id IN (SELECT EffectID FROM item_effect_base WHERE Description LIKE '%$special%') AND name LIKE '%$this->search_query%' AND manufacturer LIKE "."'".$manufacturer."'"." AND level LIKE "."'".$level."'"." AND ".$type_prefix." LIKE "."'".$type."'"." ORDER BY ".$sorter;
	} else {
	$sql = "SELECT * FROM $this->table WHERE name LIKE "."'%".$this->search_query."%'"." AND manufacturer LIKE "."'".$manufacturer."'"." AND level LIKE "."'".$level."'"." AND ".$type_prefix." LIKE "."'".$type."'"." ORDER BY ".$sorter;
	}
	$this->session_sql = $sql;
	$stmt = $this->conn->query($sql);	
	$this->results = $stmt->fetchAll();
	$this->count = count($this->results);
	
	// Now we add the limiter to deal with navigation.  Not using columnCount() because it's a buggy POS.
	$sql = $sql." LIMIT ".$this->viewed.", ".$step;
	$stmt = $this->conn->query($sql);	
	$this->results = $stmt->fetchAll();
	// Used to determine if the query was empty but successfully run
	$this->OK = true;
	
	return $this->results;
	}
	
public function nav_search($total, $step, $page){
	// Set new viewed variable for search
	$this->viewed = $page * $step;
	// Get SQL query from page as set when query was first processed
	$sql = $this->nav_sql;
	// Complete SQL query by adding on new viewed amount
	$sql = $sql." LIMIT ".$this->viewed.", ".$step;
	$stmt = $this->conn->query($sql);	
	$this->results = $stmt->fetchAll();
	// Used to determine if the query was empty but successfully run
	$this->OK = true;	
	return $this->results;
	}
	
public function set_query($search_query) {
	$this->search_query = $search_query;
	}	
	
public function get_total(){
	return $this->count;
	}
	
public function get_viewed(){
	return $this->viewed;
	}
	
public function get_OK(){
	return $this->OK;
	}
	
public function get_query(){
	return $this->session_sql;
	}
	
public function set_nav_sql($sql){
	$this->nav_sql = $sql;
	}
	
public function process_type(){
	if($this->type == 'lootother'){
		$this->type = -1;
		$type_prefix = 'sub_category';
		} else {
		$type_prefix = 'type';	
		}
	return $type_prefix;
	}
	
public function get_2d_asset($asset_id){
	$sql = "SELECT filename FROM assets WHERE base_id = $asset_id";
	$stmt = $this->conn->query($sql);	
	$image = $stmt->fetch();
	$image = $image['filename'];
	$image = str_ireplace('i_', '', $image);
	$image = str_ireplace('pu', '', $image);
	$image = str_ireplace('.tga', '', $image);
	$image = str_ireplace('.w3d', '', $image);
	$image = $image.'.jpg';
	return $image;
	}
}
?>