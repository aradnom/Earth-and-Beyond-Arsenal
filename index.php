<?php
// Initiate session, set output buffering
session_start();
ob_start();

//include('../cheddar/arsenal.net-7.org_local_auth.php'); // Auth info variables, contains user, pwd, host and DB name
include('../cheddar/net7.enbarsenal.com_auth.php'); // Alternate DB info from enbarsenal's server, useful if net-7 explodes
include('../includes/enba/conn.class.php'); // Class for building PDO mysql connection object, passed to other classes
include('../includes/enba/search.class.php'); // Main search class
include('../includes/enba/item_info.class.php'); // Processes item info
include('../includes/enba/manufacturer_base.class.php'); // Used to list manufacturers below... not really necessary though, shouldn't change much
include('../includes/enba/news.class.php'); // Used for the News box below, fetches articles created from the website

// Initialize arrays for searching and news
$articles = array(); // Array for news articles
$results = array(); // Main array for search results

// Initalize universal connection object for use below
$db_conn = new db_conn($dbHost, $dbUser, $dbPass, $db);
$conn = $db_conn->make_conn();

// Setting page and viewed to 0 since no query has been run yet
$OK = 0;
$page = 0; 
$viewed = 0;
	
// Initting new query object
$query = new query($conn);
	
// Beginning of main form processing, need the send_x var so IE will process the POST form
if(isset($_POST['send']) || isset($_POST['send_x'])) {	
	// Initialize recall variables so search boxes will remember queries
	$_SESSION['type'] = $_POST['type'];
	$_SESSION['race'] = $_POST['race'];
	$_SESSION['class'] = $_POST['class'];
	$_SESSION['search'] = $_POST['search'];
	$_SESSION['level'] = $_POST['level'];
	$_SESSION['manufacturer'] = $_POST['manufacturer'];
	$_SESSION['sort'] = $_POST['sort'];
	$_SESSION['step'] = $_POST['step'];
	$_SESSION['special'] = $_POST['special'];
	if(isset($_POST['searchtype'])){
		$_SESSION['searchtype'] = $_POST['searchtype'];
		}
	
	// Grabbing the trash that modifies the query
	$search = addslashes($_POST['search']);
	if(isset($_POST['searchtype'])){
		$searchtype = $_POST['searchtype'];
		} else {
		$searchtype = 'item';
		$_SESSION['searchtype'] = 'item';
		}
	$special = addslashes($_POST['special']);
	$level = $_POST['level'];
	$manufacturer = $_POST['manufacturer'];
	$type = $_POST['type'];	
	$race = $_POST['race'];
	$class = $_POST['class'];
	$sorter = $_POST['sort'];
	$step = $_POST['step'];		
	
	// Passing query keywork to search object
	$query->set_query($search);
	
	// Returned results array from call to query object
	$results = $query->run_search($sorter, $step, $manufacturer, $level, $type, $race, $class, $special, $searchtype);
	
	// Get SQL query for navigation purposes
	$_SESSION['sql'] = $query->get_query();
	
	// Check if search was successful
	$OK = $query->get_OK();
	
	// Get the number of results and send to SESSION var for nav
	$total = $query->get_total();
	
	// Set vars for navigation purposes
	$_SESSION['total'] = $total;
	$_SESSION['step'] = $step;

	// Keep these around for testing, tells you if the search was successful and if it returned anything
	//echo $total.' '.$OK;
	//print_r($results);
}

// Navigation processing
if(isset($_POST['prev']) || isset($_POST['next']) || isset($_POST['prev_x']) || isset($_POST['next_x'])){	
	// Initialize navigation variables from session
	$page = $_POST['page'];
	$total = $_SESSION['total'];
	$step = $_SESSION['step'];
	$searchtype = $_SESSION['searchtype'];
	
	// Get the stored nav variable and set it inside the object
	$query->set_nav_sql($_SESSION['sql']);	
	
	// Send cached query along with variables necessary for nav
	$results = $query->nav_search($total, $step, $page);
	
	// Check if search was successful
	$OK = $query->get_OK();
	
	// Get the viewed variable for the next iteration
	$viewed = $query->get_viewed();
}

// Reset the page upon user request, flush output buffer, redirect to homepage
if(isset($_GET['resetscripts']) && $_GET['resetscripts'] == '1'){
header('Location:index.php');	
	if (isset($_COOKIE[session_name()])) {
	setcookie(session_name(), '', time()-86400, '/');
	}
	ob_end_flush();
session_unset();
session_destroy();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="description" content="The Earth & Beyond Arsenal is a digital database for the Massively-Multiplayer game Earth & Beyond featuring a comprehensive listing of all item types contained within the game." />
<meta name="keywords" content="earth & beyond and EnB E&B database data base arsenal space game mmo EA westwood" />
<title>Welcome to the Earth &amp; Beyond Arsenal</title>
<script type="text/javascript" src="js/livesearch.js"></script>
<script type="text/javascript" src="tooltip/jquery-1.2.2.pack.js"></script>
<script type="text/javascript" src="tooltip/ajaxtooltip.js">

/***********************************************
* Ajax Tooltip script - by JavaScript Kit (www.javascriptkit.com)
* This notice must stay intact for usage
* Visit JavaScript Kit at http://www.javascriptkit.com/ for this script and 100s more
***********************************************/

</script>
<link href="styles/home.css" rel="stylesheet" type="text/css" />
<link href="styles/homeie6.css" rel="stylesheet" type="text/css" />
<link href="styles/tooltip.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="styles/homeie7.css" /><![endif]-->
<link rel="shortcut icon" href="assets/shortcut.ico" />

<!-- Analytics -->

<script type="text/javascript">

  var _gaq = _gaq || [];
  _gaq.push(['_setAccount', 'UA-25035705-2']);
  _gaq.push(['_trackPageview']);

  (function() {
    var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
    ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
    var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
  })();

</script>

</head>
<body>

<!-- Container div to make sure footer stays at the bottom -->

<div class="container">
	<div class="containerin">
<table class="searchbox" align="center" cellspacing="0" cellpadding="0">
<form name="searchtest" id="searchtest" method="post" action="">
	<tr>
    	<td height="470">
        <div>
        <img src="assets/mainboxlivebeta.png" border="0" usemap="#resetbutton" />
<input type="hidden" name="inc" id="inc" value="1" style="float:left"/>
<div id="levelpos">
<select name="level" id="level">
<option value="%" <?php if(isset($_SESSION['level']) && $_SESSION['level'] == '%'){echo 'selected="true"';}?>>Any</option>
<option value="1" <?php if(isset($_SESSION['level']) && $_SESSION['level'] == '1'){echo 'selected="true"';}?>>1</option>
<option value="2" <?php if(isset($_SESSION['level']) && $_SESSION['level'] == '2'){echo 'selected="true"';}?>>2</option>
<option value="3" <?php if(isset($_SESSION['level']) && $_SESSION['level'] == '3'){echo 'selected="true"';}?>>3</option>
<option value="4" <?php if(isset($_SESSION['level']) && $_SESSION['level'] == '4'){echo 'selected="true"';}?>>4</option>
<option value="5" <?php if(isset($_SESSION['level']) && $_SESSION['level'] == '5'){echo 'selected="true"';}?>>5</option>
<option value="6" <?php if(isset($_SESSION['level']) && $_SESSION['level'] == '6'){echo 'selected="true"';}?>>6</option>
<option value="7" <?php if(isset($_SESSION['level']) && $_SESSION['level'] == '7'){echo 'selected="true"';}?>>7</option>
<option value="8" <?php if(isset($_SESSION['level']) && $_SESSION['level'] == '8'){echo 'selected="true"';}?>>8</option>
<option value="9" <?php if(isset($_SESSION['level']) && $_SESSION['level'] == '9'){echo 'selected="true"';}?>>9</option>
</select></div>

<div id="catpos">
<select name="type" id="type">
<option value='%'>All</option>
<option value='14' <?php if(isset($_SESSION['type']) && $_SESSION['type'] == '14'){echo 'selected="true"';}?>>Beams</option>
<option value='15' <?php if(isset($_SESSION['type']) && $_SESSION['type'] == '15'){echo 'selected="true"';}?>>Missile Launchers</option>
<option value='16' <?php if(isset($_SESSION['type']) && $_SESSION['type'] == '16'){echo 'selected="true"';}?>>Projectile Launchers</option>
<option value='10' <?php if(isset($_SESSION['type']) && $_SESSION['type'] == '10'){echo 'selected="true"';}?>>Ammo</option>
<option value='2' <?php if(isset($_SESSION['type']) && $_SESSION['type'] == '2'){echo 'selected="true"';}?>>Shields</option>
<option value='7' <?php if(isset($_SESSION['type']) && $_SESSION['type'] == '7'){echo 'selected="true"';}?>>Reactors</option>
<option value='6' <?php if(isset($_SESSION['type']) && $_SESSION['type'] == '6'){echo 'selected="true"';}?>>Engines</option>
<option value='11' <?php if(isset($_SESSION['type']) && $_SESSION['type'] == '11'){echo 'selected="true"';}?>>Devices</option>
<option value='13' <?php if(isset($_SESSION['type']) && $_SESSION['type'] == '13'){echo 'selected="true"';}?>>Components/Ore</option>
</select>
</div>

<div id="racepos">
<img src="assets/navtext/race.png" border="0" />
<select name="race" id="race">
<option value="%" <?php if(isset($_SESSION['race']) && $_SESSION['race'] == '0'){echo 'selected="true"';}?>>All</option>
<option value="2" <?php if(isset($_SESSION['race']) && $_SESSION['race'] == '2'){echo 'selected="true"';}?>>Jenquai Restricted</option>
<option value="4" <?php if(isset($_SESSION['race']) && $_SESSION['race'] == '4'){echo 'selected="true"';}?>>Progen Restricted</option>
<option value="1" <?php if(isset($_SESSION['race']) && $_SESSION['race'] == '1'){echo 'selected="true"';}?>>Terran Restricted</option>
<option value="5" <?php if(isset($_SESSION['race']) && $_SESSION['race'] == '5'){echo 'selected="true"';}?>>Jenquai Only</option>
<option value="3" <?php if(isset($_SESSION['race']) && $_SESSION['race'] == '3'){echo 'selected="true"';}?>>Progen Only</option>
<option value="6" <?php if(isset($_SESSION['race']) && $_SESSION['race'] == '6'){echo 'selected="true"';}?>>Terran Only</option>
</select>
</div>

<div id="classpos">
<img src="assets/navtext/class.png" border="0" />
<select name="class" id="class">
<option value="%" <?php if(isset($_SESSION['class']) && $_SESSION['class'] == '0'){echo 'selected="true"';}?>>All</option>
<option value="3" <?php if(isset($_SESSION['class']) && $_SESSION['class'] == '3'){echo 'selected="true"';}?>>Explorer Only</option>
<option value="5" <?php if(isset($_SESSION['class']) && $_SESSION['class'] == '5'){echo 'selected="true"';}?>>Trader Only</option>
<option value="6" <?php if(isset($_SESSION['class']) && $_SESSION['class'] == '6'){echo 'selected="true"';}?>>Warrior Only</option>
</select>
</div>

<!-- List of manufacturers created from manufacturer class -->

<div id="manufacturerpos">
<select name="manufacturer" id="manufacturer">
<option value="%" <?php if(isset($_SESSION['manufacturer']) && $_SESSION['manufacturer'] == '%'){echo 'selected="true"';}?>>All</option>
<?php
$manu_list = array(); // New array for manufacturer results
$manu_obj = new manufacturer_list($conn); // New manu list object
$manu_list = $manu_obj->get_manus(); // Get array of manufacturers
foreach($manu_list as $row) { 
	if($row['name'] != null && $row['name'] != 'Athatnor') { // Need this because it's misspelled in the table ?>
<option value="<?php echo $row['id']; ?>" <?php if(isset($_SESSION['manufacturer']) && $_SESSION['manufacturer'] == $row['id']){echo 'selected="true"';}?>><?php echo $row['name']; ?></option>
<?php } elseif ($row['name'] == null) { ?>
<option value="<?php echo $row['id']; ?>" <?php if(isset($_SESSION['manufacturer']) && $_SESSION['manufacturer'] == $row['id']){echo 'selected="true"';}?>>Unknown</option>
<?php } } ?>  
</select>
</div>

<div id="searcheffectspos">
<input type="text" name="special" id="special" size="49" value="<?php if(isset($_SESSION['special'])){echo $_SESSION['special'];}?>"/>
</div>

<!-- Livesearch output div resides here -->

<div id="zFix">
<div id="searchpos">
<input type="text" name="search" id="search" value="<?php if(isset($_SESSION['search'])){echo $_SESSION['search'];}?>" size="22" onkeyup="showResult(this.value)" />
<table id="livesearchpos">
	<tr>
    	<td id="livesearch">
        </td>
    </tr>
</table>
</div>

<div id="search_type_pos">
<img src="assets/navtext/mob.png" border="0" />
<input type="radio" id="searchtype-mob" name="searchtype" value="mob" /><br />
<img src="assets/navtext/vendor.png" border="0" />
<input type="radio" id="searchtype-vendor" name="searchtype" value="vendor" /><br />
<img src="assets/navtext/item.png" border="0" />
<input type="radio" id="searchtype-item" name="searchtype" value="item" checked />
</div>

<div id="sortpos">
<select name="sort" id="sort">
<option value="name" <?php if(isset($_SESSION['sort']) && $_SESSION['sort'] == 'name'){echo 'selected="true"';}?>>Alphabetical</option>
<option value="level" <?php if(isset($_SESSION['sort']) && $_SESSION['sort'] == 'level'){echo 'selected="true"';}?>>Level</option>
</select>
</div>

<div id="steppos">
<select name="step" id="step">
<option value="10" <?php if(isset($_SESSION['step']) && $_SESSION['step'] == '10'){echo 'selected="true"';}?>>10</option>
<option value="25" <?php if(isset($_SESSION['step']) && $_SESSION['step'] == '25'){echo 'selected="true"';} elseif(!isset($_SESSION['step'])) {echo 'selected="true"';}?>>25</option>
<option value="50" <?php if(isset($_SESSION['step']) && $_SESSION['step'] == '50'){echo 'selected="true"';}?>>50</option>
<option value="100" <?php if(isset($_SESSION['step']) && $_SESSION['step'] == '100'){echo 'selected="true"';}?>>100</option>
<option value="300" <?php if(isset($_SESSION['step']) && $_SESSION['step'] == '300'){echo 'selected="true"';}?>>All</option>
</select>
</div>
</div>

<div id="submitpos">
<input name="send" type="image" id="send" value="Send" src="assets/searchbutton.png" />
</div>
</div>
		</td>
    </tr>
</form>
</table>

<!-- Table for displaying error if nothing is found -->

<?php 
if(isset($total)){
	if($total == 0 && $OK == 1) { ?>
<table class="error" align="center">
	<tr>
    	<td>
        <p>Nothing was found.  This likely means whatever you were looking for has suffered a sudden total existence failure.<br />
        Oh, and make sure you reset the form to clear out any search restrictions you've set.</p>
        </td>
    </tr>
</table>
<?php } } ?>

<!-- Table for displaying category search.  Doesn't currently work because there's not much point with this DB, it's going to be trashed -->

<?php 
if($OK == 0){ ?>
<table class="midbox" id="midbox" align="center" border="0" style="background:url(assets/midboxcomingsoon.png);" >
	<tr>
        <td class="midboxcontent">
        </td>        
    </tr>
</table>
<?php } ?>

<!-- Location of newsbox, displays updates to the site -->

<?php 
// Development database for just news and feedback for the time being
if($OK == 0) { 
@ include('../cheddar/net7.enbarsenal.com_news_auth.php'); // New auth file with my own DB info, stores feedback and news
$news_db_conn = new db_conn($dbHost, $dbUser, $dbPass, $db);
$news_conn = $news_db_conn->make_conn();
$news_articles = new news($news_conn);
$articles = $news_articles->get_articles();
?>
<table class="newsbox" align="center" cellspacing="0" border="0px">
	<tr>     	   	
    	<td class="newsboxbg">
        <div>
        <div class="newsboxupper"></div>        
        <div class="newsboxcontent"> 
        <div class="links">
        <span style="font-size:14px">Spots of Interest:</span>
        <div class="linksline"></div>
        <a href="http://en.wikipedia.org/wiki/Earth_&_Beyond">Earth &amp; Beyond Wiki Entry</a>
        <br />
        <a href="http://zombo.com">The Zombo</a>
        <br />
        <a href="http://www.enb-emulator.com">The Earth and Beyond Emulator</a>
        <br />
        <a href="http://www.enbx.com/">ENBX</a>
        <br />
        <a href="http://www.earthandbeyond.ca">Original EnB Page</a>
        </div>        
      	<?php
		foreach($articles as $row){
			echo '<div class="newsboxdate">'.$row['created'].'</div>';
			echo '<div class="newsline"></div>';
			echo '<div class="newsboxtitle">'.$row['title'].'</div>'.'<br />';
			echo '<div class="newsboxsub">'.$row['subtitle'].'</div>'.'<br /><br />';			
			$contents = $row['content'];
			$contents = stripslashes($contents);
			echo '<div class="newsboxtext">'.$contents.'</div>';			
			}
		?>      
      	</div></div>                
      </td>              
    </tr>
    <tr>
    	<td>
        <div class="newsboxlower"></div>
        </td>
    </tr>
</table>
<?php } ?>

<!-- Table for display of upper navigation box, display only if $OK and $total are set -->

<?php if($OK && $total > 0 && $total > $step) { 
$navigation = true; // Lets everything else know navigation is set
?>
<table class="navigation" name="next" id="next" align="center">
<tr>
	<?php if($page > 0) { ?>
	<td>
    <form name="prevform" id="prevform" method="post" action="">
    <input type="image" name="prev" id="prev" src="assets/previous.png" value="previous" />
    <input type="hidden" name="page" id="page" value="<?php echo $page-1; ?>"  />
    </form>
    </td>
    <?php } ?>
    <?php if(($viewed+$step) < $total) { ?>
    <td align="right">
    <form name="nextform" id="nextform" method="post" action="index.php">
    <input type="image" name="next" id="next" src="assets/next.png" value="next" />
    <input type="hidden" name="page" id="page" value="<?php echo $page+1; ?>" />
    </form>
    </td>
    <?php } ?>
</tr>
</table>
<?php } ?>

<!-- Main table for displaying search results, display only if $OK and $total are set and > 0 (i.e. the search went well) -->

<?php 
$i = 0;
if($OK == 1 && $total > 0) { ?>
<table class="resultsbg" align="center" cellpadding="0" cellspacing="0">
<tr>
	<td class="resultsbgtop">
    </td>
</tr>
<?php
foreach($results as $row) { ?>
<tr>
   <td class="resultsbgmiddle">
   <table class="results" align="center" cellpadding="0" cellspacing="0">
   <tr>
   	<td class="resulttext"><div>
   <?php 
   if($searchtype == 'item'){
   // Initting new item info object for processing result IDs
   $item = new item_info($conn, $row['id']);
   // Grabs all item info
   $item_info = $item->get_all_item_info($row['id'], $row['type'], "assoc");
   // Filters type-specific item info for each result
   $type_info = $item->filter_item_info($item_info, $row['type'], "result");
   $keys = array_keys($type_info);
   foreach($keys as $info){
	$type_info[$info] = $item->format_field($type_info[$info], $info, true);
   }
   // Process 2d asset from assets table
   $image = $item->format_field($item_info['2d_asset'], '2d_asset', false);
	?>
	<a title="ajax:./tooltip/external.php?id=<?php echo $item_info['id']; ?>&type=<?php echo $item_info['type_id']; ?>" href="item/view_item.php?&id=<?php echo $item_info['id']; ?>"><img src="icons/png/<?php echo $image; ?>" border="0" style="margin-left:10px;" /></a>
   <div class="resultinfo">
   <?php
   // Link which is forwarded to the item page
   echo '<span style="font-size:16px;"><div class="field">Name: </div>'.'<a href="item/view_item.php?&id='.$row['id'].'&type='.$item_info['type_id'].'">'.$row['name'].'</a>'.'</span>'.'<br />';
   echo '<div class="field">Type: </div>'.$item_info['type'].'&nbsp;&nbsp;&nbsp;&nbsp;';
   echo '<div class="field">Level: </div>'.$row['level'].'<br />';
   // Echoes all type info initialized above
   $i = 0;
   foreach($type_info as $field){
   echo $field.' ';    
   $i++;
   if(($i%3) == 0){
	echo '<br />';
   		}
   	 } 
   } elseif($searchtype == 'mob') { ?>
   <img src="icons/png/noimg.png" border="0" style="margin-left:8px;" />
   <div class="resultinfo">   
   <span style="font-size:16px;"><div class="field">Name: </div><?php echo '<a href="mob/view_mob.php?mid='.$row['mob_id'].'">'.$row['name'].'</a>'; ?></span><br />
   <div class="field">Level: <?php echo $row['level']; ?></div>
   <?php } elseif($searchtype == 'vendor') { ?>
   <img src="icons/png/noimg.png" border="0" style="margin-left:8px;" />
   <div class="resultinfo"> 
   <span style="font-size:16px;"><div class="field">Name: </div><?php echo '<a href="vendors/view_vendor.php?vid='.$row['GroupID'].'">'.$row['GroupName'].'</a>'; ?></span>
   <?php } ?>
   </div></div>
   </td>
     </tr>
   </table>
   </td>
</tr>	
<?php } ?>
	<tr>
    	<td class="resultsbgbottom">
        </td>
    </tr>    
</table>
<?php if(!isset($navigation)) { ?>
<br />
<?php } ?>
<?php } ?>

<!-- Location of lower navigation box, same conditions as above -->

<?php if($OK && $total > 0 && $total > $step) { 
$navigation = true; // Lets everything else know navigation is set
?>
<table class="navigationud" name="next" id="next" align="center">
<tr>
	<?php if($page > 0) { ?>
	<td>
    <form name="prevform" id="prevform" method="post" action="">
    <input type="image" name="prev" id="prev" src="assets/previousud.png" value="previous" />
    <input type="hidden" name="page" id="page" value="<?php echo $page-1; ?>"  />
    </form>
    </td>
    <?php } ?>
    <?php if(($viewed+$step) < $total) { ?>
    <td align="right">
    <form name="nextform" id="nextform" method="post" action="index.php">
    <input type="image" name="next" id="next" src="assets/nextud.png" value="next" />
    <input type="hidden" name="page" id="page" value="<?php echo $page+1; ?>" />
    </form>
    </td>
    <?php } ?>
</tr>
</table>
<br />
<?php } ?>
	</div>
</div>	

<!-- The footer.  'Nough said. -->
<?php @ include('../includes/enba/footer.inc.php'); ?>

<div class="footerbar">
<!-- 5px border at the bottom of page -->
</div>

<!-- Image maps, used for resetting the form and returning the homepage -->
<map name="resetbutton" id="resetbutton">
<area shape="poly" coords="370,221,566,221,558,243,378,243" href="<?php echo $_SERVER['SCRIPT_NAME'].'?resetscripts=1'; ?>" />
<area shape="poly" coords="343,73,357,49,745,48,743,65,702,66,687,107,417,108,407,93,422,75" href="index.php" />
</map>
<map name="footer" id="footer">
<area shape="rect" coords="433,12,542,22" href="http://monterey-j.com" />
<area shape="rect" coords="340,12,373,22" href="http://enb-emulator.com" />
</map>
</body>
</html> 