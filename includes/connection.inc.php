<?php
function dbConnect($type, $method, $database){
	$host = 'arsenaldb.enbarsenal.com';
	if($type == 'root') {
		$user = 'root';
		$pwd = 'df1234';
		$host = 'localhost';
		} elseif($type == 'enbadmin') {
		$user = 'enbadmin';
		$pwd = 'dF102938';
		} else {
		exit('Unrecognized connection type');
		}
		if($method == 'mysqli'){
			$conn = new mysqli("$host", $user, $pwd, "$database") or die('Cannot open database');
			return $conn;
			} elseif($method == 'pdo') {
		try{
			$conn = new PDO("mysql:host=$host;dbname=$database", $user, $pwd);
			return $conn;
			}
		catch(PDOException $e){
			echo 'Cannot connect to database';
			exit;
			}
		} elseif($method == 'mysql') {
			$conn = mysql_connect("$host", $user, $pwd) or die('Cannot connect to MySQL server');
			mysql_select_db("$database") or die('Cannot open database');
			return $conn;
			}
		}	
?>