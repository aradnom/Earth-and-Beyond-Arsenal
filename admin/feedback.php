<?php
session_start();

include('../../includes/enba/conn.class.php');
include('../../cheddar/net7.enbarsenal.com_news_auth.php');
include('../../includes/enba/sessionparams.inc.php');

// MySQL variables
$table = 'feedback';

// Database connection
$db_conn = new db_conn($dbHost, $dbUser, $dbPass, $db);
$conn = $db_conn->make_conn();

if(isset($_GET['delete'])){
	$id = $_GET['feedbackid'];
	$sql = "DELETE FROM $table WHERE id = '$id'";
	$stmt = $conn->prepare($sql);
	$OK = $stmt->execute();
	}

$sql = "SELECT * FROM $table";
$stmt = $conn->prepare($sql);
$OK = $stmt->execute();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Tis the feedback</title>
<link href="../styles/home.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table class="newsbox" align="center" cellspacing="0" style="margin-top:50px; margin-bottom:30px;">
	<tr>
    	<td align="center">
        <a href="index.php"><img src="../assets/logomini.png" border="0" style="margin-bottom:10px;"/></a>
        </td>
    </tr>
	<tr>     	   	
    	<td class="newsboxbg">
        <div>
        <div class="newsboxupper"></div>
        
        <div class="newsboxcontent">         
        'Tis the feedback.
        <div class="line" width="400px"></div>
        <?php foreach($conn->query($sql) as $row) { ?> 
        <br /> 
        	<div class="bugsbg"> 
            <span style="color:#af8f1f;">             
            <?php
			echo $row['type'];
			?>   
            </span>       
            <?php
			echo $row['name'];
			?>   
            <span style="color:#af8f1f;">       
            <?php
			echo $row['email'];
			?>
            </span>
            <?php
			echo $row['content'];
			?> 
            <span style="color:#af8f1f;">
            <?php
			echo $row['itemname'];
			?>
            </span>
            <?php
			echo $row['itemcat'];
			?> 
            <span style="color:#af8f1f;">
            <?php
			echo $row['created'];
			?> 
            </span>
            <form name="deletefeedback" id="deletefeedback" method="get" action="" style="display:inline;">
            <input type="submit" name="delete" id="delete" value="Delete"  />
            <input type="hidden" name="feedbackid" id="feedbackid" value="<?php echo $row['id']; ?>"  />
            </form>
            </div>       
        <?php } ?>
        	<p>
            <a href="../admin/index.php">Main Menu</a>      	
            </p>
            </div>              
      	<div class="newsboxlower" align="center"></div>        
        </div>        
      </td>              
    </tr>
</table>
</body>
</html>
