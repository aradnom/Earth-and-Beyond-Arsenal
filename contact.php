<?php
include('../cheddar/net7.enbarsenal.com_news_auth.php');
include('../includes/enba/conn.class.php');

// Table that feedback will empty into
$table = 'feedback';

// Database connection
$db_conn = new db_conn($dbHost, $dbUser, $dbPass, $db);
$conn = $db_conn->make_conn();

if(isset($_GET['cat'])){
	$cat = $_GET['cat'];
	$id = $_GET['id'];
	$name = addslashes($_GET['name']);	
	}
	
if(isset($_POST['send'])){
	date_default_timezone_set('US/Pacific-New');
	$created = date("l, F d, Y @ g:i:sa");
	$OK = true;
	$type = $_POST['type'];
	
	// check for alphanumeric
	$formname = $_POST['formname'];
	if(ereg('[^A-Za-z0-9._-]', $formname) == true || strlen($formname) > 30){
		$OK = false;
		$error = '<p class="error" align="center">Alphanumeric only, one word and under 30 characters please, just a simple name. <a href="index.php">Homepage</a></p>';
		}
	$email = $_POST['email'];
	if(ereg('[^A-Za-z0-9._@-]', $email) == true || strlen($email) > 50){
		$OK = false;
		$error = '<p class="error" align="center">Alphanumeric email only and under 50 characters please. <a href="index.php">Homepage</a></p>';
		}
		
	$message = $_POST['message'];
	if(strlen($message) > 1000 || $message == null || $message == ' Enter message.'){
		$OK = false;
		$error = '<p class="error" align="center">Please leave an actual message, and don\'t write the Great &lt;nationality&gt; Novel, I won\'t read it.  1000 characters or less. <a href="index.php">Homepage</a></p>';
		}	
	
	if($OK == true){
		$sql = "INSERT INTO $table (type, name, email, content, created) VALUES ('$type', '$formname', '$email', '$message', '$created')";
		if(isset($cat)){
			$sql = "INSERT INTO $table (type, name, email, content, itemid, itemname, itemcat, created) VALUES ('$type', '$formname', '$email', '$message', '$id', '$name', '$cat', '$created')";
			}
		$stmt = $conn->prepare($sql);
		$OK = $stmt->execute();
		}
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Leave Feedback</title>
<link rel="shortcut icon" href="assets/shortcut.ico" />
<link href="styles/home.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="styles/homeie7.css" /><![endif]-->
</head>

<body>
<table class="newsbox" align="center" cellspacing="0" style="margin-top:10px; margin-bottom:10px;">
	<?php if(isset($OK) && $OK == 1) { ?>
    <tr>
    	<td class="success" align="center">
        <p><strong>Feedback entered successfully.  Thanks. =) <a href="index.php">Homepage</a><strong></p><br />
        </td>
    </tr>
    <?php } elseif(isset($OK) && $OK == false) { ?>
    <tr>
    	<td class="success" align="center">
        <p><strong><?php echo $error; ?><strong></p><br />
        </td>
    </tr>
    <?php } ?>
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
        As might be evident, there's a few bits missing here and there.  If you happen to have a bit of useful info, send it over.  Or if you happen to know the correct icon for an item with a missing one, let me know ("&lt;item missing image&gt; has the same icon as &lt;item with image&gt;," something along those lines.<br /><br />

        And if something doesn't work <strong>please</strong> tell me what browser you're using.  Also please copy 'n paste any error messages you get and describe what you were doing when the problem occurred. This thing is tested to work in Internet Explorer 7, Firefox 3, Opera 9, Chrome (1?) and Safari 4.  So if you don't have one of those, please feel free to <a href="http://www.microsoft.com/windows/downloads/ie/getitnow.mspx">get</a> <a href="http://www.apple.com/safari/">a</a> <a href="http://www.google.com/chrome">better</a> <a href="http://www.opera.com/">damn</a> <a href="http://getfirefox.com">browser</a>, they're all free.<br />
<br />
		As always, I keep an open inbox policy, so feel free to drop suggestions by.<br /><br /><br />


      	</div>
        
        <div class="line" style="width:400px; margin-left:80px;"></div>
        
        <div class="contactform"> 
        <span style="font-size:12px; color:#2c5a89;">(Objects denoted with a * don't mean anything in particular)</span>       
        
        <form name="contact" id="contact" method="post" action="">
        <p>
		<label for="type">Type of Feedback:</label><br /><br />
		<input type="radio" id="type-suggestion" name="type" value="suggestion" checked />
		<label for="type-suggestion">Suggestion</label>
		<input type="radio" id="type-problem" name="type" value="problem" />
		<label for="type-problem">Problem</label>
        <input type="radio" id="type-info" name="type" value="info" />
		<label for="type-info">Info</label>
        <input type="radio" id="type-other" name="type" value="other" />
		<label for="type-other">Other</label>
		</p>
        <p>
        <label for="name">First/Game Name (optional):</label>
        <input type="text" name="formname" id="formname"  />
        </p>
        <p>
        <label for="email">Email (optional):&nbsp;</label>
        <input type="text" name="email" id="email"  />
        </p>
        <p>
        <label for="email">Message (not quite as optional):</label><br /><br />
        <textarea name="message" id="message" rows="5" cols="40"> Enter message.</textarea>
        </p>
        <p>
        <input type="submit" name="send" id="send" value="Send"  />
        </p>
        <input type="hidden" name="category" id="category" value="<?php echo $cat; ?>"  />
        <input type="hidden" name="name" id="name" value="<?php echo $name; ?>"  />
        <input type="hidden" name="id" id="id" value="<?php echo $id; ?>"  />
        </form>        
        </div></div>        
      </td>              
    </tr>
    <tr>
    	<td>
        <div class="newsboxlower"></div>
        </td>
    </tr>
</table>
</body>
</html>