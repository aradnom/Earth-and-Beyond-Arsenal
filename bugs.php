<?php
include('includes/connection.inc.php');

// MySQL variables
$database = 'enbarsenal';
$user = 'enbadmin';
$method = 'pdo';
$table = 'bugs';

$conn = dbConnect($user, $method, $database);
$sql = "SELECT * FROM bugs";
$stmt = $conn->prepare($sql);
$OK = $stmt->execute();


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>NOT THE BEES</title>
<link href="styles/home.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table class="newsbox" align="center" cellspacing="0" style="margin-top:10px; margin-bottom:30px;">
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
			echo '<div class="bugs">'.$row['status'];
			?>
            </div> 
            </div>
        <?php } ?>
      	</div>
              
      	<div class="newsboxlower" align="center"></div>        
        </div>        
      </td>              
    </tr>
</table>

</body>
</html>