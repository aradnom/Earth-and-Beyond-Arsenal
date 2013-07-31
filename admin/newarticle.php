<?php
session_start();

include('../../includes/enba/conn.class.php');
include('../../cheddar/net7.enbarsenal.com_news_auth.php');
include('../../includes/enba/sessionparams.inc.php');

// MySQL variables
$table = 'news';

// Database connection
$db_conn = new db_conn($dbHost, $dbUser, $dbPass, $db);
$conn = $db_conn->make_conn();

// Default update value
$OK = true;

if(isset($_POST['send'])){
$title = $_POST['title'];
$title = addslashes($title);
if($title == null){
	$OK = false;
	$error = 'Enter a title!';
	}
	
$subtitle = $_POST['subtitle'];
	
$content = $_POST['content'];
$content = addslashes($content);
if($content == null || $content == 'New article content here.'){
	$OK = false;
	$error = 'Enter some content!';
	}
	
$frontpage = $_POST['frontpage'];

if($frontpage == 'Yes'){
	$status = 1;
	} elseif ($frontpage == 'No'){
	$status = 0;
	}

if($OK == true){
date_default_timezone_set('US/Pacific-New');
$created = date("l, F d, Y @ g:i:sa");	
$sql = "INSERT INTO $table (title, subtitle, content, status, created) VALUES ('$title', '$subtitle', '$content', '$status', '$created')"; 
$stmt = $conn->prepare($sql);
$OK = $stmt->execute();
if($OK == 1) {
	echo '<p class="success" align="center">'.'Successfully entered new article.'.'</p>';
	}	 
} else {
	echo '<p class="error" align="center">'.$error.'</p>';
	}
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Create new article</title>
<link rel="shortcut icon" href="../assets/shortcut.ico" />
<link href="../styles/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table class="content" border="0" cellpadding="5px" align="center">
	<tr>
    	<td valign="middle">
<form name="new" id="new" method="post" action="">
<p><label for="title">Title:</label>
<input type="text" name="title" id="title"  />
</p>
<p><label for="subtitle">Subtitle:</label>
<input type="text" name="subtitle" id="subtitle"  />
</p>
<p><label for="content" style="vertical-align:middle">Content:</label>
<textarea id="content" name="content" cols="40" rows="5">
New article content here.
</textarea>
</p>
<p>

<label for="frontpage">Frontpage:</label><br /><br />
<input type="radio" id="frontpage-yes" name="frontpage" value="Yes" checked >
<label for="frontpage-yes">Yes</label>
<input type="radio" id="frontpage-no" name="frontpage" value="No" >
<label for="frontpage-no">No</label>

</p>
<p>
<input type="submit" id="send" name="send" value="Send it"  />
<a href="../admin/menu.php">Back to Menu</a>
</p>
</form>
		</td>
    </tr>
</table>
</body>
</html>
