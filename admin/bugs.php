<?php
session_start();

include('../../includes/enba/conn.class.php');
include('../../cheddar/net7.enbarsenal.com_news_auth.php');
include('../../includes/enba/sessionparams.inc.php');

// MySQL variables
$table = 'bugs';

// Database connection
$db_conn = new db_conn($dbHost, $dbUser, $dbPass, $db);
$conn = $db_conn->make_conn();

if (isset($_GET['update'])){
	$id = $_GET['bugid'];
	$content = $_GET['bugcontent'];
	$browser = $_GET['bugbrowser'];
	$status = $_GET['bugstatus'];
	}
	
if (isset($_GET['createnew'])){
	$conn = dbConnect($user, $method, $database);
	
	$content = $_GET['content'];
	$browser = $_GET['browser'];
	$status = $_GET['status'];
	
	if($_GET['updateid'] == 'new'){
		$sql = "INSERT INTO $table (bug, browser, status) VALUES ('$content', '$browser', '$status')";
		} else {
		$id = $_GET['updateid'];
		$sql = "UPDATE $table SET bug = '$content', browser = '$browser', status = '$status' WHERE id = '$id'";
		}
	$stmt = $conn->prepare($sql);
	$OK = $stmt->execute();
	$content = null;
	$browser = null;
	$status = null;
	$id = null;
	}

$sql = "SELECT * FROM $table";
$stmt = $conn->prepare($sql);
$OK = $stmt->execute();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Stuff that doesn't work</title>
<link href="../styles/home.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table class="newsbox" align="center" cellspacing="0" style="margin-top:50px; margin-bottom:30px;">
	<tr>
    	<td align="center">
        <a href="index.php"><img src="assets/logomini.png" border="0" style="margin-bottom:10px;"/></a>
        </td>
    </tr>
	<tr>     	   	
    	<td class="newsboxbg">
        <div>
        <div class="newsboxupper"></div>
        
        <div class="newsboxcontent">         
        This table lists known bugs and status of said bugs.  Will be updated as bugs are discovered/fixed.
        <div class="line" width="400px"></div>
        <?php foreach($conn->query($sql) as $row) { ?> 
        <br />
        <div class="bugsbg">       
        <div class="bugs">        
            <?php
			echo $row['bug'].'</div>';
			?>          
            <?php
			echo '<div class="bugdivider">'.$row['browser'].'</div>';
			?>           
            <?php
			echo '<div class="bugs" style="display:inline;">'.$row['status'];
			?>
            </div>            
            <form name="updatebug" id="updatebug" method="get" action="" style="display:inline; margin-left:10px;">
            <input type="submit" name="update" id="update" value="Update"  />
            <input type="submit" name="delete" id="delete" value="Delete"  />
            <input type="hidden" name="bugid" id="bugid" value="<?php echo $row['id']; ?>"  />
            <input type="hidden" name="bugcontent" id="bugcontent" value="<?php echo $row['bug']; ?>"  />
            <input type="hidden" name="bugbrowser" id="bugbrowser" value="<?php echo $row['browser']; ?>"  />
            <input type="hidden" name="bugstatus" id="bugstatus" value="<?php echo $row['status']; ?>"  />
            </form>             
            </div>
            
        <?php } ?>
        <form name="addnew" id="addnew" method="get" action="" style="margin-top:10px;">
            <input type="text" name="content" id="content" value="<?php if(isset($content)){echo $content; } ?>" />
            <input type="text" name="browser" id="browser" value="<?php if(isset($content)){echo $browser; } ?>"  />
            <input type="text" name="status" id="status" value="<?php if(isset($content)){echo $status; } ?>" />
            <input type="hidden" name="updateid" id="updateid"  value="<?php if(isset($id)){ echo $id; } else { echo 'new'; } ?>" />
            <input type="submit" name="createnew" id="createnew" value="Create New/Update"  />
            </form>
            <a href="../admin/index.php">Main Menu</a>
      	</div>
              
      	<div class="newsboxlower" align="center"></div>        
        </div>        
      </td>              
    </tr>
</table>
</body>
</html>
