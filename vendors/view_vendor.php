<?php
session_start(); // Initializing session

//include('../../cheddar/arsenal.net-7.org_local_auth.php'); // DB information auth info
include('../../cheddar/net7.enbarsenal.com_auth.php'); // Alternate DB info from enbarsenal's server, useful if net-7 explodes
include('../../includes/enba/conn.class.php'); // Connection class for passing to item info objects
include('../../includes/enba/vendor_info.class.php'); // Grabs mob drop info
include('../../includes/enba/manufacturer_base.class.php'); // This class is for displaying manufacturers

// Initializing mob ID and array for results, item results and mob locations
$vid = $_GET['vid']; // Main item ID, NO letter in front anymore
$results = array();
$itemresults = array();
$location = array();
//$vid = 53;
$db_conn = new db_conn($dbHost, $dbUser, $dbPass, $db); // Make new connection object
$conn = $db_conn->make_conn();
$vendor_info = new vendor_info($conn, $vid); // New object for displaying object info
$vendor_info->set_id($vid); // Make sure item_info has the correct ID set at the start
$results = $vendor_info->get_vendor_info();
$location = $vendor_info->get_vendor_location();
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php if(!empty($location)) { echo $location['first_name'].' '.$location['last_name']; } ?> - The Earth &amp; Beyond Arsenal</title>
<script type="text/javascript" src="../js/livesearchitems.js"></script>
<link href="../styles/items.css" rel="stylesheet" type="text/css" />
<link href="../styles/tooltip.css" rel="stylesheet" type="text/css" />
<!--[if IE 7]><link rel="stylesheet" type="text/css" href="../styles/itemsie7.css" />
<link rel="stylesheet" type="text/css" href="../styles/tooltipie7.css" /><![endif]-->
<link rel="shortcut icon" href="../assets/shortcut.ico" />
</head>
<body>

<!-- Begin regular attribs.  Changes based on item type. -->

<div class="container">
	<div class="containerin">
<table class="content" cellpadding="0" cellspacing="0" align="center" border="0px">
	<tr>
    	<td class="searchbox" align="center">        
        <form name="searchform" id="searchform" method="post" action="../index.php">	
        <div><div class="mainbox"><img src="../assets/itemsearchboxcondensed.png" border="0" usemap="#homepage"/></div>
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
</select>
</div>

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
<option value='lootother' <?php if(isset($_SESSION['type']) && $_SESSION['type'] == 'lootother'){echo 'selected="true"';}?>>Loots and Other</option>
</select>
</div>

<div id="racepos">
<img src="../assets/navtext/racesmall.png" border="0" />
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
<img src="../assets/navtext/classsmall.png" border="0" />
<select name="class" id="class">
<option value="%" <?php if(isset($_SESSION['class']) && $_SESSION['class'] == '0'){echo 'selected="true"';}?>>All</option>
<option value="3" <?php if(isset($_SESSION['class']) && $_SESSION['class'] == '3'){echo 'selected="true"';}?>>Explorer Only</option>
<option value="5" <?php if(isset($_SESSION['class']) && $_SESSION['class'] == '5'){echo 'selected="true"';}?>>Trader Only</option>
<option value="6" <?php if(isset($_SESSION['class']) && $_SESSION['class'] == '6'){echo 'selected="true"';}?>>Warrior Only</option>
</select>
</div>

<div id="manufacturerpos">
<select name="manufacturer" id="manufacturer">
<option value="%" <?php if(isset($_SESSION['manufacturer']) && $_SESSION['manufacturer'] == '%'){echo 'selected="true"';}?>>All</option>
<?php
$manu_list = array();
$manu_obj = new manufacturer_list($conn);
$manu_list = $manu_obj->get_manus();
foreach($manu_list as $row) { 
	if($row['name'] != null && $row['name'] != 'Athatnor') { ?>
<option value="<?php echo $row['id']; ?>" <?php if(isset($_SESSION['manufacturer']) && $_SESSION['manufacturer'] == $row['id']){echo 'selected="true"';}?>><?php echo $row['name']; ?></option>
<?php } elseif ($row['name'] == null) { ?>
<option value="<?php echo $row['id']; ?>" <?php if(isset($_SESSION['manufacturer']) && $_SESSION['manufacturer'] == $row['id']){echo 'selected="true"';}?>>Unknown</option>
<?php } } ?> 
</select>
</div>

<div id="searcheffectspos">
<input name="special" type="text" id="special" value="<?php if(isset($_SESSION['special'])){echo $_SESSION['special'];}?>" size="44"/>
</div>

<div id="searchpos">
<input name="search" type="text" id="search" value="<?php if(isset($_SESSION['search'])){echo $_SESSION['search'];}?>" size="31" onkeyup="showResult(this.value)" />
<table id="livesearchpos">
	<tr>
    	<td id="livesearch">
        </td>
    </tr>
</table>
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
<option value="25" <?php if(isset($_SESSION['step']) && $_SESSION['step'] == '25'){echo 'selected="true"';}?>>25</option>
<option value="50" <?php if(isset($_SESSION['step']) && $_SESSION['step'] == '50'){echo 'selected="true"';}?>>50</option>
<option value="100" <?php if(isset($_SESSION['step']) && $_SESSION['step'] == '100'){echo 'selected="true"';}?>>100</option>
<option value="300" <?php if(isset($_SESSION['step']) && $_SESSION['step'] == '300'){echo 'selected="true"';}?>>All</option>
</select>
</div>

<div id="submitpos">
<input name="send" type="submit" id="send" value="Send" src="../assets/itemsearchbutton.png" />
</div>
</div>
</form>
        </td>
  </tr>
<tr>
	<td class="infoboxtop">
    <!-- Placeholder cell for boxtop image -->
    </td>
</tr>

<!-- Beginning of basic item information -->

<tr>
   <td class="header">   
   <div><div class="baseinfopos">   
   <div class="feedback"><a href="../contact.php" target="_blank"><img src="../assets/feedbackbutton.png" border="0"/></a></div>
   <?php if(!empty($location)) { ?>
   <h2><?php echo $location['first_name'].' '.$location['last_name']; ?></h2>
   
   	<div class="fieldbox"><div class="field">Name: </div><?php echo $location['first_name'].' '.$location['last_name']; ?></div>
    <div class="fieldbox"><div class="field">Level: </div><?php echo $location['level']; ?></div>
    <div class="fieldbox"><div class="field">Location: </div><?php echo $location['name'].' :: '.$location['sec_name']; ?></div>
    
    <br /><br />
	<?php 
	foreach($results as $row) {	$itemresults = $vendor_info->get_item_info($row['itemid']); 
		if(!empty($itemresults)) { ?>
    	<div>
		<div class="item_result_box">
        <div class="item_result_box_corner"></div>        		 
		<div class="tiny_icon_frame"><img src="../icons/png/<?php echo str_ireplace('tga', 'png', str_ireplace('i_pu', '', $itemresults[0]['filename'])); ?>" /></div>
        <div class="item_result_box_content">		
		<a href="../item/view_item.php?id=<?php echo $itemresults[0]['item_id']; ?>&type=<?php echo $itemresults[0]['type']; ?>"><?php echo $itemresults[0]['name']; ?></a> :: 	
		<div class="field">Level: </div><?php echo $itemresults[0]['level']; ?> ::
		<div class="field">Type: </div><?php echo $itemresults[0]['type_name']; ?> ::
		<div class="field">Manufacturer: </div>
		<?php 
		if($itemresults[0]['manu_name'] == null){
			$itemresults[0]['manu_name'] = 'Unknown';	
		}
		echo $itemresults[0]['manu_name']; 
		?> ::
		<div class="field">Description: </div><?php echo str_ireplace('\n', ' ', $itemresults[0]['description']); ?> ::	
        </div>       
        </div>
        </div>
	<?php } } ?>
   <?php } ?>
   </div>
   </div>   
   </td>
</tr>

<!-- End of info boxes -->

<tr>
	<td class="infoboxbottom">
    <!-- Simply an image container, check the CSS for modifying -->    
    </td>
</tr>
</table>
	</div>
</div>

<!-- Footer -->

<?php include('../../includes/enba/footer.inc.php'); ?>
<div class="footerbar">
<!-- 5px border at the bottom of page -->
</div>

<!-- Image maps for the homepage button and footer link -->

<map name="homepage" id="homepage">
<area shape="poly" coords="427,16,585,16,585,46,425,47" href="../index.php" />
</map>
<map name="footer" id="footer">
<area shape="rect" coords="433,12,542,22" href="http://monterey-j.com" />
<area shape="rect" coords="340,12,373,22" href="http://enb-emulator.com" />
</map>

</body>
</html>