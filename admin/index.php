<?php
session_start();
if(isset($_SESSION['auth'])){
header('Location:../admin/menu.php');
}
// process only if submitted
if(array_key_exists('login', $_POST)){	
	// nuke magic quotes
	include('../../includes/enba/corefuncs.php');
	nukeMagicQuotes();
	//read in users
	$file = '../../cheddar/cheddar.inc.php';
	$username = trim($_POST['username']);
	$pwd = sha1($username.trim($_POST['pwd']));
	if(file_exists($file) && is_readable($file)) {
		// read into users array
		$users = file($file);
		// process users array
		for($i = 0; $i < count($users); $i++){
			// separate each element and store in an array
			$tmp = explode(', ', $users[$i]);
			// assign each element of the tmp array a named key
			$users[$i] = array('name' => $tmp[0], 'pass' => rtrim($tmp[1]));
			// check for matching record
			if($users[$i]['name'] == $username && $users[$i]['pass'] == $pwd){
				// if match, set session variable
				$_SESSION['auth'] = 'Jethro Tull';
				break;
				}
			}
			// if the session variable has been set, redirect to page
			if(isset($_SESSION['auth'])){
				// get session start time
				$_SESSION['start'] = time();
				header('Location:../admin/menu.php');
				exit;
				} else {
				$error = 'Invalid username or password.';
				}
			// error if text file not readable	
			} else {
			$error = 'Login not available at the moment.  Make a note of it.  Or don\'t.';
			}
		}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Welcome to the Earth &amp; Beyond Arsenal</title>
<link rel="shortcut icon" href="../assets/shortcut.ico" />
<link href="../styles/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table class="content" align="center">
	<tr>
    	<td>
<?php
if(isset($error)){
	echo "<p>$error</p>";
	} elseif (isset($_GET['expired'])) { ?>
    <p>Your session has expired.  Please sign in again.</p>
    <?php } ?>
<form id="form1" name="form1" method="post" action="">
<p>
<label for="username">Username:</label>
<input type="text" name="username" id="username" />
</p>
<p>
<label for="textfield">Password:</label>
<input type="password" name="pwd" id="pwd" />
</p>
<p>
<input name="login" type="submit" id="login" value="Log in" />
</p>
</form>
		</td>
    </tr>
</table>
</body>
</html>
