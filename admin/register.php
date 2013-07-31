<?php
session_start();
ob_start();
// if auth variable not set, redirect to login page
if(!isset($_SESSION['auth'])){
	header('Location:../admin/index.php');
	exit;
	}
// execute only if form has been submitted
if(array_key_exists('register', $_POST)){
	// remove backslashes
	include('../../includes/enba/corefuncs.php');
	nukeMagicQuotes();
	// check un/pw length
	$username = trim($_POST['username']);
	$pwd = trim($_POST['pwd']);
	if(strlen($username) < 5 || strlen($pwd) < 5){
		$result = 'Too short.  And you can\'t follow directions.  Good Lord.';
		} elseif($pwd != $_POST['conf_pwd']) {
		// check that passwords match
		$result = 'Your passwords don\'t match, which frankly makes your typing skills (or your memory) substandard.';
		} else {
		// continue if OK	
		// encrypt password, username as randomizer
		$pwd = sha1($username.$pwd);
		// define filename and open in read/append mode
		$filename = '../admin/cheddar.inc.php';
		$file = fopen($filename, 'a+');
		// if filesize zero, no name entered so just write un/pw to file
		if(filesize($filename) === 0){
			fwrite($file, "$username, $pwd");
			} else {
			// if filesize > 0, check username
			// move to beginning of file
			rewind($file);
			// loop through file one line at a time
			while(!feof($file)){
				$line = fgets($file);
				// split at comma, check first element against username
				$tmp = explode(', ', $line);
					if($tmp[0] == $username){
						$result = 'Taken already, try something that doesn\'t feature "Dark," "Naruto," or "Ninja" in it.';
						break;
						}
				}
				// if $result not set, enter new username
				if(!isset($result)){
					// insert line break followed by un, comma, pw
					fwrite($file, "\r\n$username, $pwd");
					$result = "$username registered.";
					}
				// close the file
				fclose($file);
			}
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
</head>

<body>
<h1>Register user</h1>
<?php
if(isset($result)){
	echo "<p>$result</p>";
	}
?>
<form id="form1" name="form1" method="post" action="">
    <p>
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" />
    </p>
    <p>
        <label for="pwd">Password:</label>
        <input type="password" name="pwd" id="pwd" />
    </p>
    <p>
        <label for="conf_pwd">Confirm password:</label>
        <input type="password" name="conf_pwd" id="conf_pwd" />
    </p>
    <p>
        <input name="register" type="submit" id="register" value="Register" />
    </p>
</form>
</body>
</html>
