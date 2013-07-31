<?PHP
/***********************************/
/*@File: item_info.class.php
/*@Created: 6/3/09 by AChillingSight
/*@About: This class is to keep from having to replicate the grabing of item information.
/*        It's also to help keep some of the pages' code short.
/*        This COULD be used for grabbing avatar info also, but for now I'm just doing items.
/***********************************/

class item_info {
//first let's define some variables
 private $dbHost;
 private $dbUser;
 private $dbPass;
 private $db;
 private $port;
 private $conn;
 private $result;
 private $id;
 private $var2check;
 public $qid;

//Our first function is our constructor
//It's going to help us define which database to use(net7 or net7_user)
 function __construct($dbHost, $dbUser, $dbPass, $iid) {
  $this->dbHost = $dbHost;
  $this->dbUser = $dbUser;
  $this->dbPass = $dbPass;
  $this->id = $iid;
  //Just cause we're paranoid we'll make sure that the last characters are numbers
  if(!is_numeric(substr($this->id, 1))) {
   echo "Error: The last characters are not the correct format. Please click the link again or contact the administrator.";
  }
 
  //This checks to see which DB to use, for now we'll use this though if it we decide it isn't needed we can remove it
  //Should be an easy fix
  if(substr($this->id, 0, 1) == "a") {
   $this->db = "net7_user";
  }elseif(substr($this->id, 0, 1) == "i") {
   $this->db = "net7";
  }else{
   echo "Error: Argument submitted to the class is invalid, please contact the administrator.";
  }
 }
 
//This will be used to connect to the DB and execute the query
//Closing the query and freeing the results will be a seprate function
//Grabbing the results will be dealth with in the __get functions
 private function query($query) {
  if($this->dbHost == 'play.net-7.org' || $this->dbHost == 'net-7.org'){
		$this->port = '3307';	
		} else {
		$this->port = '3306';
		}
  $this->conn = mysql_connect($this->dbHost.":$this->port",$this->dbUser,$this->dbPass) or die( "Unable to connect");
  @mysql_select_db($this->db) or die( "Unable to select database");
  $this->result = mysql_query($query);
  //echo $query; //Keep for debugging
 }
 
//This if for freeing the results and closing the DB connection
 private function close_query() {
  mysql_free_result($this->result);
  mysql_close($this->conn);
 }
 
 public function set_id($iid) {
  $this->id = substr($iid, 1);
 }
 
//This is the format for the other __get functions also
//These will be used for grabbing specific items values from the item_* root tables.
//Tables that need/use forgeign keys will NOT work in this function, please use the fk function below for those
//***********************************************
//Usage: $attribute = Put the name of the column you want to get the info of(name, desc, price, ect)
//       $table = put which table you want to chose from, this will only work for the base tables for items(so like assets, ammo_type wont work!)
//       $display = do you want to display the result or are you going to use it in a if->then(which case you don't need it displayed)
//                  Not being displayed is default
 public function get_item_attribute($attribute, $table, $display = "0") {
  $this->query("SELECT `$attribute` FROM `item_". $table ."` WHERE `id` = '$this->id' LIMIT 1;");
  if(mysql_num_rows($this->result) > 0) {
   if($display == "1") {
    $results = mysql_result($this->result, 0);
	$results = str_ireplace('\n', ' ', $results);
	return $results;
   } else {
	$results = mysql_result($this->result, 0);
	$results = str_ireplace('\n', ' ', $results);
    return $results;
   }
  } else {
   $error = "Error: Unable to grab item info from DB.";
   return $error;
  }
  $this->close_query();
 }
 
  /* The point of this function is the same as the above, except you can send it a custom id aside from the main item ID 
  DOES NOT USE the item_ prefix of the function above because this is used with a variety of tables.  Note that this takes two IDs because the id for each table isn't necessarily 'id', so it must be send the ID you're looking for as well as the name of the id field to compare it to */
  public function get_secondary_attribute($attribute, $table, $table_id, $id, $display = "0") {
  $sql = "SELECT $attribute FROM ".$table." WHERE $table_id = $id";
  $this->query($sql);
  if(mysql_num_rows($this->result) > 0) {
   if($display == "1") {
	$results = mysql_result($this->result, 0);
    return $results;
   } else {
	$results = mysql_result($this->result, 0);
    return $results;
   }
  } else {
   $error = "Error: Unable to grab item info from DB.";
   return $error;
  }
  $this->close_query();
 }
 
 public function get_drop_info($id) {
 	$id = substr($id, 1);
	
 }
 
//These will be used for grabbing the image information from the assets table
//***********************************************
//Usage: All you need to do is call the function in the page, aslong as the url has the $iid var in it, it's all automated
 public function get_item_image($item_id) {
  $asset_2d = $this->get_item_attribute("2d_asset", "base");
  $this->query("SELECT `filename` FROM `assets` WHERE `base_id` = '$asset_2d' LIMIT 1;");
  if(mysql_num_rows($this->result) > 0) {
   $image_loc = mysql_result($this->result, 0);
   $image_loc = substr($image_loc, 0, -4);
   $image_loc = ($image_loc == "NULL") ? "NoImage" : $image_loc;
   return $image_loc;
  }else{
   $error = "Error: Unable to grab the image information.";
   return $error;
  }
  $this->close_query();
 }
  
 //Need to finish working on this, need to find out if the `id` column will be the same everwhere, if not we'll need to add another argument
 //We might want to remove the `item_". $table ."` from the functino above for simplicity, incase we can use it for other tables w/o items_ 
 //not sure if we need this or if we want to combine it with item_attribute
 public function get_item_attribute_fk($attribute, $table, $fk, $display = "0") {
  $this->query("SELECT `$attribute` FROM `$table` WHERE `$fk` = '$this->id' LIMIT 1;");
  if(mysql_num_rows($this->result) > 0) {
    if($display == "1") {
		//subcomponent breakdown
		$this->query("SELECT `$attribute` FROM `$table` WHERE `$fk` = '$this->id' LIMIT 1;");
		$results =  mysql_result($this->result, 0);
		return $results;
	}else{
		$results = mysql_result($this->result, 0);
		return $results; 
	}
  } else {
   $error = "Error: Unable to retrieve data.";
   return $error;
  }
  $this->close_query();
 }
}