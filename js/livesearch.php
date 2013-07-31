<?php
include('../../cheddar/net7.enbarsenal.com_auth.php');
include('conn.class.php');

$db_conn = new db_conn($dbHost, $dbUser, $dbPass, $db);
$conn = $db_conn->make_conn();

$table = "item_base";
$testpage = "localhost/dev.enbarsenal.com";
$livepage = "dev.enbarsenal.com";
// Search limit goes here
$limit = 15;
// Array for results
$results = array();
// Gets query from javascript
$query = $_GET["q"];
//$query = 'gaze';

$sql = "SELECT * FROM $table WHERE name LIKE '%$query%' ORDER BY name LIMIT 0, $limit";
$stmt = $conn->query($sql);
$results = $stmt->fetchAll();
$total = count($results);
$hint = "";

if($total > 0){	
		foreach($results as $row){
			$hint = $hint.'<a href="http://'.$livepage.'/item/view_item.php?'.'iid=i'.$row['id'].'&type='.$row['type'].'">'.$row['name'].'</a>'.'<br />';
			}
		}	

// Set output to "Nothing found" if no hint were found
// or to the correct values
if ($hint == "")
  {
  $response="Nothing found.";
  }
else
  {
  $response=$hint;
  }

//output the response
echo $response;
?> 