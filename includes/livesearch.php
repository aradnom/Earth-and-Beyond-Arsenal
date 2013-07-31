<?php
//include('../../cheddar/arsenal.net-7.org_local_auth.php'); // DB information auth info
include('../../cheddar/net7.enbarsenal.com_auth.php'); // Alternate DB info from enbarsenal's server, useful if net-7 explodes
include('../../includes/enba/conn.class.php');

$db_conn = new db_conn($dbHost, $dbUser, $dbPass, $db);
$conn = $db_conn->make_conn();

$table = "item_base";
$testpage = "localhost/dev.enbarsenal.com";
$livepage = "enbarsenal.com";
// Search limit goes here
$limit = 15;
// Array for results
$results = array();
// Gets query from javascript
$query = addslashes($_GET["q"]);
//$query = 'gaze';

$sql = "SELECT
	item_type.name AS type_name,
	item_base.id AS id,
	item_base.`type` AS `type`,
	item_base.name AS name
	FROM
	item_base
	Inner Join item_type ON item_base.`type` = item_type.id
	WHERE
	item_base.name LIKE '%$query%'
	ORDER BY
	name ASC
	LIMIT 0, $limit";
$stmt = $conn->query($sql);
$results = $stmt->fetchAll();
$total = count($results);
$hint = "";

if($total > 0){	
		foreach($results as $row){
			$hint = $hint.'<a href="http://'.$livepage.'/item/view_item.php?'.'id='.$row['id'].'&type='.$row['type'].'">'.$row['name'].'</a>'.' - '.$row['type_name'].'<br />';
			}
		}	

// Set output to "Nothing found" if no hint were found
// or to the correct values
if ($hint == "") {
  $response="Nothing found.";
  } else {
  $response=$hint;
  }

//output the response
echo $response;
?> 