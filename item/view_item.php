<?php
session_start(); // Initializing session

//include('../../cheddar/arsenal.net-7.org_local_auth.php'); // DB information auth info
include('../../cheddar/net7.enbarsenal.com_auth.php'); // Alternate DB info from enbarsenal's server, useful if net-7 explodes
include('../../includes/enba/conn.class.php'); // Connection class for passing to item info objects
include('../../includes/enba/item_info.class.php'); //This class contains all the code for grabbing base item info
include('../../includes/enba/drop_info.class.php');  // This class handles display of drop and mob info on items
include('../../includes/enba/item_effects.class.php'); // This class handles display of item effects info
include('../../includes/enba/manufacturer_base.class.php'); // This class is for displaying manufacturers

$id = $_GET['id']; // Main item ID, NO letter in front anymore
$type = $_GET['type']; // Item type
if(!isset($_GET['type'])){
	$type = 13;
	}
$db_conn = new db_conn($dbHost, $dbUser, $dbPass, $db); // Make new connection object
$conn = $db_conn->make_conn();
$item = new item_info($conn, $id); // New object for displaying object info
$item->set_id($id); // Make sure item_info has the correct ID set at the start
$item_info = $item->get_all_item_info($id, $type, "assoc");
$base_info = $item->filter_item_info($item_info, $type, 'base');
$type_info = $item->filter_item_info($item_info, $type, 'item');
$more_info = $item->filter_item_info($item_info, $type, 'more');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $item->get_item_attribute("name", "base"); ?> - The Earth &amp; Beyond Arsenal</title>
<script type="text/javascript" src="../js/livesearchitems.js"></script>
<script type="text/javascript" src="../js/mootools-1.2-core-nc.js"></script>
<script type="text/javascript" src="../js/mootools-1.2-more-nc.js"></script>
<script type="text/javascript" src="../js/slider.js"></script>
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
   <h2><?php echo $base_info['name']; ?></h2>
   <div class="feedback"><a href="../contact.php" target="_blank"><img src="../assets/feedbackbutton.png" border="0"/></a><br /></div>
	<div class="iconframe"><img src="../icons/png/<?php echo $item->format_field($item_info['2d_asset'], '2d_asset', false); ?>" border="0"></div><br />
    <?php
	if($type == 10){
	$base_info['launcher'] = ""; 
	$base_info['similar'] = "";	
	$ammo_info = $item->get_ammo_info($id, "item_projectile", $item_info['ammo_type_id']);
	if(empty($ammo_info[0])){
		$ammo_info = $item->get_ammo_info($id, "item_missile", $item_info['ammo_type_id']);
		}

	foreach($ammo_info[0] as $launcher){
		$base_info['launcher'] .= "<a href=\"../item/view_item.php?id=".$launcher['launcher_id']."&type=".$launcher['launcher_type']."\">".$launcher['launcher_name'].'</a> :: ';
		}
	foreach($ammo_info[1] as $ammo){
		if($id != $ammo['ammo_id']){
			$base_info['similar'] .= "<a href=\"../item/view_item.php?id=".$ammo['ammo_id']."&type=10\">".$ammo['ammo_name']."</a> :: ";
			}
		}

	if(empty($base_info['launcher'])){
	$base_info['launcher'] = 'No known launchers.';	
	} 
	if (empty($base_info['similar'])) {
	$base_info['similar'] = 'No other similar types.';	
	}
	$base_info['launcher'] = '<div class="field">Ammo Launcher: </div>'.$base_info['launcher'];
	$base_info['similar'] = '<div class="field">Similar Ammo Types: </div>'.$base_info['similar'];
	}
	$keys = array_keys($base_info);
    foreach($keys as $info){
	$base_info[$info] = $item->format_field($base_info[$info], $info, true);	
	?>
	<div class="fieldbox"><?php echo $base_info[$info]; ?></div>
   	<?php } ?>      
   </div>
   </div>
   </td>
</tr>

<!-- Beginning of additional info -->

<tr>
  <td class="moreinfobody">
  <div class="infobuttonpos"><a id="infotoggler"><img src="../assets/moreinfobuttonlong.png" alt="More Info" border="0" style="cursor:pointer;" /></a></div>
	<div id="infocontainer">
  		<div><div class="infopos">
    	<div class="infoboxtop"></div>
        <div class="infotextbg">
        
        <!-- Beginning of item effects section -->
        
        <?php
		// Create new item effects object, passing it the SQL connection and item ID
		$effects_info = new effects_info($conn, $id);
		// This will return a formatted array with 'description' and 'stats' indexed by number
		$effects = $effects_info->get_item_effects();
		if(!empty($effects)) { ?>
        
        <div class="infotext">
        <h3>Effects Information</h3><br /><br />
        <div class="infoindent">         
        
        <?php foreach($effects as $row) { ?>        
        <div class="fieldbox">
        <div class="field">
		<?php echo $row['description'].' :: '; ?>
        </div>
		<?php echo $row['stats']; ?>
        </div>        
        <?php } ?>
        
        </div>
        <br />
        </div> 
        <?php } ?>
               
        <div class="infotext">
        <h3>Other Information</h3><br /><br />
        <div class="infoindent">  
        <?php
		$keys = array_keys($type_info);
		foreach($keys as $info){
		$type_info[$info] = $item->format_field($type_info[$info], $info, true);
		?>
		<div class="fieldbox"><?php echo $type_info[$info]; ?></div>
		<?php } ?>
        <?php
		$keys = array_keys($more_info);
		foreach($keys as $info){
		$more_info[$info] = $item->format_field($more_info[$info], $info, true);
		?>
		<div class="fieldbox"><?php echo $more_info[$info]; ?></div>
		<?php } ?>
        
        <!-- Vendor locations -->
        <div class="fieldbox"><div class="field">Vendors: </div>
        <br />
		<?php 
		$vendors = $item->get_item_vendors($id);
		if (!empty($vendors)) {
			foreach($vendors as $vendor) { ?>            
			<a href="../vendors/view_vendor.php?vid=<?php echo $vendor['groupid']; ?>"><?php echo $vendor['first_name'].' '.$vendor['last_name']; ?></a> - <?php echo $vendor['name'].' Station'.' :: '.'<div class="field">Sector '.$vendor['sec_name'].'</div>'; ?>
            <br />            
		<?php } } else {
		echo "No Vendors Found for Item.";
		}
		?>
        <br /><a href="../assets/map.jpg">Map</a>
        </div>
        
        <!-- End of standard variables -->
         
		</div></div></div><div class="infoboxbottom"></div></div></div>
        </div>
        </td>
</tr>

<!-- Begin Components section.  Shouldn't change. Unless it does. In which case it will. -->

<tr>
  <td class="buildinfobody">
  <div class="infobuttonpos"><a id="buildtoggler"><img src="../assets/buildinfobuttonlong.png" alt="Build Info" border="0" style="cursor:pointer;" /></a></div>
	<div id="buildcontainer">
  	<div><div class="infopos">
    <div class="infoboxtop"></div>
    <div class="buildinfobg">
    <div class="buildtext">
    	<h3>Components</h3><br /><br />        
        
        <?php
		if($item_info['no_manu'] == 0){
		$i = 0;
        $comp[$i] = array(); 
		for($i = 1; $i < 7; $i++){
		$query = "comp_".$i;
		$comp[$i]['id'] = $item->get_secondary_attribute("$query", "item_manufacture", "item_id", "$id");
		if ($comp[$i]['id'] != -1) { 
			$item->set_id($comp[$i]['id']);
			$comp[$i]['name'] = $item->get_item_attribute('name', 'base');
			$comp[$i]['type'] = $item->get_item_attribute('type', 'base');
			$comp[$i]['image'] = $item->get_item_image($comp[$i]['id']);
			$item->set_id($id);
		?>
        
        <div class="iconframe"><img src="../icons/png/<?php $comp_image = str_ireplace('i_pu', '', $comp[$i]['image']); echo $comp_image; ?>.png" border="0"></a></div>
        <div class="comp_info_pos">
        <div class="fieldbox"><div class="field">Component <?php echo $i; ?>: </div><a href="view_item.php?id=<?php echo $comp[$i]['id']; ?>&type=<?php echo $comp[$i]['type']; ?>"><?php echo $comp[$i]['name']; ?></a></div></div>
        <?php } } } else {
			echo '<div style="z-index:16;">'.'Non-manufacturable.'.'</div>';
		}
		?>       
		
		</div></div>
        <div class="infoboxbottom"></div></div></div>
      	</div>
        </td>
</tr>

<!-- Beginning of drop info -->

<tr>
  <td class="dropinfobody">
  <div class="infobuttonpos"><a id="droptoggler"><img src="../assets/dropinfobuttonlong.png" alt="Drop Info" border="0" style="cursor:pointer;" /></a></div>
	<div id="dropcontainer">
  		<div><div class="infopos">
    	<div class="infoboxtop"></div>
        <div class="infotextbg">
        <div class="infotext">
        <h3>Drop Information</h3><br /><br />
        <div class="infoindent">
        
     <!-- Section for grabbing item drop info and sector info -->
     
     <?php	 
	 // Empty results array for mobs found
	 $results = array();
	 $i = 0;
	 // New drop info object for processing mobs found
	 $drop_info = new drop_info($conn, $id);
	 $mob_ids = $drop_info->get_mob_ids();
	 
	 // Checks if any mobs that drop were item found.  If not, display the following error message
	 if(empty($mob_ids)){
	 echo 'Not dropped or drop location unknown.<br /><br />'; 
	 }
	 
	 /* $mob_ids will be an array of mobs that drop the item.  This loop processes each id and for each 
	 grabs mob name, level and drop percentage.  It also grabs the spawn ids for the mob, which is also an array.
	 For this it flips through each spawn id and returns the id of the sector where the spawn id is located.  
	 It finally grabs the name of the sector for each sector id. */
	 foreach($mob_ids as $mob){
		$results[$i]['name'] = $drop_info->get_mob_name($mob['mob_id']);
		$results[$i]['level'] = $drop_info->get_mob_level($mob['mob_id']);
		$results[$i]['drop_chance'] = $drop_info->get_drop_chance($mob['mob_id']);
		// Process item drop brackets
		$dropchance = $results[$i]['drop_chance'];
		if($dropchance == 0){
			$dropchance = "Doesn't Drop (0%)";
			} elseif($dropchance > 0.1 && $dropchance < 5) {
			$dropchance = "Scarce (1% - 5%)";
			} elseif($dropchance >= 5 && $dropchance < 20) {
			$dropchance = "Rare (5% - 20%)";
			} elseif($dropchance >= 20 && $dropchance < 40) {
			$dropchance = "Infrequent (20% - 40%)";
			} elseif($dropchance >= 40 && $dropchance < 60) {
			$dropchance = "Common (40% - 60%)";	
			} elseif($dropchance >= 60 && $dropchance < 75) {
			$dropchance = "Frequent (60% - 75%)";	
			} elseif($dropchance >= 75 && $dropchance < 100) {
			$dropchance = "Plentiful (75% - 99%)";	
			} elseif($dropchance == 100) {
			$dropchance = "Every Time (100%)";	
			}
		$spawn_ids = $drop_info->get_spawn_locations($mob['mob_id']);
		
		if(!empty($spawn_ids)){
		$sector_ids = $drop_info->get_sector_ids($spawn_ids);
		$results[$i]['sectors'] = $drop_info->get_sector_names($sector_ids);
		// Leave for testing
		/*echo '<pre>';		
		print_r($sector_names);
		echo '</pre>';*/
		} ?>
     
     <!-- Display of mob name, level and drop chance.  Note that sector info for each mob is dealt with below this and 
     that this is still inside the foreach loop (as it processes each mob id separately) -->
     
     <div class="fieldbox"><div class="field">Mob name: </div><?php echo '<a href="../mob/view_mob.php?mid='.$mob['mob_id'].'">'.$results[$i]['name'].'</a>'; ?> - (Level <?php echo $results[$i]['level']; ?>)<br />
     <div class="field">Item drop chance: </div><?php echo $dropchance; ?><br />
     
	 <?php 
	 /* If the above functions returned sector locations for mobs, this will loop through the now-populated $results array
	 This will also check if the sector name has already been listed (as there can be several spawn ids in the same sector.
	 It will only display the first instance of a sector name. Could add specific spawn locations, but that's probably too specific. */
	 if(isset($results[$i]['sectors'])){ 
	 	echo '<div class="field">Location: </div>';
	 	for($j = 0; $j < count($results[$i]['sectors']); $j++){
			if(($j + 1) < count($results[$i]['sectors'])){
				if(isset($results[$i]['sectors'][$j][0]['name']) && $results[$i]['sectors'][$j][0]['name'] == @ $results[$i]['sectors'][$j + 1][0]['name']){
				$results[$i]['sectors'][$j][0]['name'] = null;	
				}
			}
		if(isset($results[$i]['sectors'][$j][0]['name'])){
			echo $results[$i]['sectors'][$j][0]['name']; // Echoes the processed sector names.  If the name doesn't exist, spits out an error
			if($results[$i]['sectors'][$j][0]['name'] != null && ($j + 1) < count($results[$i]['sectors'])){
			echo ', ';	
			}
		}
		} } else {
		echo 'Location unknown';	
		}
	 ?>
     </div>
        
     <?php } @ $i++; ?>
        
     </div></div></div><div class="infoboxbottom"></div></div></div>
     </div>
     </td>
</tr>

<!-- Section for items component is used in - only applies to components (type 13) -->

<?php if($type == 13) { ?>
<tr>
  <td class="buildinfobody">
  <div class="infobuttonpos"><a id="usedintoggler"><img src="../assets/usedinbuttonlong.png" alt="Used In info" border="0" style="cursor:pointer;" /></a></div>
	<div id="usedincontainer">
  	<div><div class="infopos">
    <div class="infoboxtop"></div>
    <div class="buildinfobg">
    <div class="buildtext">
    	<h3>Component Used In:</h3><br /><br />        
        
      	<?php
		$itemlist = $item->get_comp_used_info($id);
		
		if(!empty($itemlist)) {
		foreach($itemlist as $row) { ?>
    	<div>
		<div class="item_result_box">
        <div class="item_result_box_corner"></div>        		 
		<div class="tiny_icon_frame"><img src="../icons/png/<?php echo str_ireplace('tga', 'png', str_ireplace('i_pu', '', $row['filename'])); ?>" /></div>
        <div class="item_result_box_content">		
		<a href="../item/view_item.php?id=<?php echo $row['item_id']; ?>&type=<?php echo $row['type_id']; ?>"><?php echo $row['name']; ?></a> :: 	
		<div class="field">Level: </div><?php echo $row['level']; ?> ::
		<div class="field">Type: </div><?php echo $row['type']; ?> ::
		<div class="field">Manufacturer: </div>
		<?php 
		if($row['manufacturer'] == null){
			$row['manufacturer'] = 'Unknown';	
		}
		echo $row['manufacturer']; 		
		?> ::
		<div class="field">Description: </div><?php echo str_ireplace('\n', ' ', $row['description']); ?>				
        		</div>       
        	</div>
        </div>
        <?php } } else {
			echo 'Component not used to build any items.';	
			} ?>
		
		</div></div>
        <div class="infoboxbottom"></div></div></div>
      	</div>
        </td>
</tr>
<?php } ?>

<!-- End of info boxes -->

<tr>
	<td class="infoboxbottom">
    <!-- Simply an image container, check the CSS for modifying -->    
    </td>
</tr>
<tr>
	<td class="footer" align="center">
	<?php include('../../includes/enba/footer.inc.php'); ?>
    </td>
</tr>
</table>
	</div>
</div>

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