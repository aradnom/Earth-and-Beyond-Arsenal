<?php
session_start();
ob_start();

include('../../includes/enba/conn.class.php');
include('../../cheddar/net7.enbarsenal.com_news_auth.php');
include('../../includes/enba/sessionparams.inc.php');

// MySQL variables
$table = 'news';	
$db_conn = new db_conn($dbHost, $dbUser, $dbPass, $db);
$conn = $db_conn->make_conn();
$sql = "SELECT * FROM news";
$stmt = $conn->prepare($sql);
$OK = $stmt->execute(); 

if(isset($_POST['delete'])){
	$id = $_POST['articleid'];
	$sql2 = "DELETE FROM $table WHERE id = '$id'";
	$stmt = $conn->prepare($sql2);
	$OK = $stmt->execute();
	}
	
if(isset($_POST['sendupdate'])){
	$id = $_POST['articleid'];
	$sql = "SELECT * FROM news WHERE id = '$id'";
	$stmt = $conn->prepare($sql);
	$OK = $stmt->execute();
	
	foreach($conn->query($sql) as $row){
		$articleid = $row['id'];
		$_SESSION['id'] = $row['id'];
		$_SESSION['title'] = $row['title'];
		$_SESSION['subtitle'] = $row['subtitle'];
		$_SESSION['content'] = $row['content'];
		$_SESSION['status'] = $row['status'];
		
		header("Location: ../admin/update.php?articleid=$articleid");		
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>It's the admin menu!</title>
<link rel="shortcut icon" href="../assets/shortcut.ico" />
<link href="../styles/admin.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table class="content" align="center" cellpadding="5px">
	<?php 
	foreach($conn->query($sql) as $row) { ?>    
    <tr>
    	<td class="cell">
		<?php
		echo $row['id'];
		?>
        </td>
        <td class="cell">
		<?php
		echo $row['title'];
		?>
        </td>
        <td class="cell">
		<?php
		$extract = substr($row['content'], 0, 100);
		$lastspace = strrpos($extract, ' ');
		echo substr($extract, '0', $lastspace).' ...';
		?>
        </td>
        <td class="cell">
		<?php
		if($row['status'] == 0){
		$frontpage = 'No';
		} elseif ($row['status'] == 1){
		$frontpage = 'Yes';
		}
		echo $frontpage;
		?>
        </td>
        <td class="cell">
        <form name="update" id="update" method="post" action="">
        <input type="submit" name="sendupdate" id="sendupdate" value="Update"/>
        <input type="hidden" name="articleid" id="articleid" value="<?php echo $row['id']; ?>"  />
        </form>
        </td>
        <td class="cell">
        <form name="remove" id="remove" method="post" action="">
        <input type="submit" name="delete" id="delete" value="Remove (PERMANENT)"/>
        <input type="hidden" name="articleid" id="articleid" value="<?php echo $row['id']; ?>"  />
        </form>
        </td>
    </tr>
    <?php } ?>
	<tr>
    	<td>
		<?php include('../includes/logout.inc.php'); ?>
		</td>
        <td>
        <a href="<?php echo '../admin/newarticle.php'; ?>">Create New</a>       
        </td>
        <td>
        <a href="<?php echo '../admin/bugs.php'; ?>">View Bugs</a>
        </td>
        <td>
        <a href="<?php echo '../admin/feedback.php'; ?>">View Feedback</a>
        </td>
        <td>
        <a href="../index.php">Home</a>       
        </td>
    </tr>
</table>
</body>
</html>
