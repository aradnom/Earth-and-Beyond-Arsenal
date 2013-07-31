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

$articleid = $_GET['articleid'];
$title = $_SESSION['title'];
$subtitle = $_SESSION['subtitle'];
$content = $_SESSION['content'];
$status = $_SESSION['status'];

if(isset($_POST['send'])){
	$title = $_POST['title'];
	$subtitle = $_POST['subtitle'];
	$content = $_POST['content'];
	$frontpage = $_POST['frontpage'];
	$title = addslashes($title);
	$subtitle = addslashes($subtitle);
	$content = addslashes($content);

	if($frontpage == 'Yes'){
		$status = 1;
		} elseif ($frontpage == 'No'){
		$status = 0;
		}
	
	$sql = "UPDATE $table SET title = '$title', subtitle = '$subtitle', content = '$content', status = '$status' WHERE id = '$articleid'";
	$stmt = $conn->prepare($sql);
	$OK = $stmt->execute();
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Update Article</title>
<link rel="shortcut icon" href="../assets/shortcut.ico" />
<link href="../styles/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table class="content" align="center" border="0" cellpadding="5px">
	<tr>
    	<td>
<form name="update" id="update" method="post" action="">
<p><label for="title">Title:</label>
<input type="text" name="title" id="title" value="<?php echo $title; ?>"/>
</p>
<p><label for="subtitle">Subtitle:</label>
<input type="text" name="subtitle" id="subtitle" value="<?php echo $subtitle; ?>"/>
</p>
<p><label for="content" style="vertical-align:middle">Content:</label>
<textarea id="content" name="content" cols="40" rows="5">
<?php echo $content; ?>
</textarea>
</p>
<p>

<label for="frontpage">Frontpage:</label><br /><br />
<input type="radio" id="frontpage-yes" name="frontpage" value="Yes" <?php if($status == 1){echo 'checked';}?> >
<label for="frontpage-yes">Yes</label>
<input type="radio" id="frontpage-no" name="frontpage" value="No" <?php if($status == 0){echo 'checked';}?>>
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
