<?php
// Opening PHP
include('../includes/connection.inc.php');
// MySQL variables
$database = 'enbarsenal';
$user = 'enbadmin';
$method = 'pdo';

if(isset($_GET['itemid'])){
$item = $_GET['itemid'];
$table = $_GET['cat'];
$conn = dbConnect($user, $method, $database);
$sql = "SELECT * FROM $table WHERE id = '$item'";
$stmt = $conn->prepare($sql);
$OK = $stmt->execute();
// Get name variable for title
$result = $conn->query($sql);
$row = $result->fetch(PDO::FETCH_ASSOC);
$opener = ' - The Earth & Beyond Arsenal';
if(isset($row['name'])){
	$name = $row['name'];
	$title = $name.$opener;
	} else {
	$title = $opener;
	}
}

// Begin search handler
if (isset($_GET['send'])){
$level = $_GET['level'];
$cat = $_GET['cat'];
$manufacturer = $_GET['manufacturer'];
$search = $_GET['search'];
$special = $_GET['special'];
$sort = $_GET['sort'];
$step = $_GET['step'];
header("Location:../index.php?search=$search&level=$level&cat=$cat&manufacturer=$manufacturer&special=$special&sort=$sort&step=$step");
}
?>