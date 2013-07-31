<?PHP
session_start(); // Initializing session

//include('../../cheddar/arsenal.net-7.org_local_auth.php'); // DB information auth info
include('../../cheddar/net7.enbarsenal.com_auth.php'); // Alternate DB info from enbarsenal's server, useful if net-7 explodes
include('../../includes/enba/conn.class.php'); // Connection class for passing to item info objects
include('../../includes/enba/item_info.class.php'); //This class contains all the code for grabbing base item info
include('../../includes/enba/drop_info.class.php');  // This class handles display of drop and mob info on items
include('../../includes/enba/item_effects.class.php'); // This class handles display of item effects info
include('../../includes/enba/manufacturer_base.class.php'); // This class is for displaying manufacturers

$id = $_GET['iid']; // Main item ID, keep in mind it has that 'i' on the front
$db_conn = new db_conn($dbHost, $dbUser, $dbPass, $db); // Make new connection object
$conn = $db_conn->make_conn();
$item_info = new item_info($dbHost, $dbUser, $dbPass, $id); // New object for displaying object info
$item_info->set_id($id); // Make sure item_info has the correct ID set at the start

// This switch is for displaying the correct table headers and table output depending on what type of item it is
// You can have any number of qstats between 1 and 5.  Note that 5 is set up to handle things that need conversion
// like item type and damage type, so if a stat needs to be converted from a number to an actual type, use $qstat5
switch($item_info->get_item_attribute("type", "base")) {
     case 0:
	  //systems
	  break;
	 case 1:
	  //weapon
	  break;
	 case 2:
	  //shields
	  $ktable="item_shield";
	  $qstat1 = "cap_100"; $qstat2 = "recharge_100"; $qstat3 = "energy_100"; $qstat4 = "range_100";
	  $hstat1 = "Capacity"; $hstat2 = "Recharge"; $hstat3 = "Energy Use"; $hstat4 = "Range";
	  $stat1unit = ' units'; $stat2unit = ' units'; $stat3unit = ' units'; $stat4unit = ' km';
	  break;
	 case 3:
	  //sensor
	  break;
	 case 4:
	  //Ejector
	  break;
	 case 5:
	  //turret
	  break;
	 case 6:
	  //engine
	  $ktable = "item_engine";
	  $qstat1 = "warp"; $qstat2 = "warp_drain_100"; $qstat3 = "thrust_100"; $qstat4 = "signature_100"; $qstat5 ="energy_100";
	  $hstat1 = "Warp"; $hstat2 = "Drain"; $hstat3 = "Thrust"; $hstat4 = "Signature"; $hstat5 = "Energy Use";
	  $stat1unit = ' m/s'; $stat2unit = ' units'; $stat3unit = ' m/s'; $stat4unit = ' m'; $stat5unit = ' units';
	  break;
	 case 7:
	  //reactor
	  $ktable = "item_reactor";
	  $qstat1 = "cap_100"; $qstat2 = "recharge_100"; $qstat3 = "energy_100"; $qstat4 = "range_100";
	  $hstat1 = "Capacity"; $hstat2 = "Recharge"; $hstat3 = "Energy Use"; $hstat4 = "Range";
	  $stat1unit = ' units'; $stat2unit = ' units'; $stat3unit = ' units'; $stat4unit = ' m';
	  break;
	 case 8:
	  //controller
	  break;
	 case 9:
	  //robot
	  break;
	 case 10:
	  //ammo
	  $ktable = "item_ammo";
	  $qstat3 = 'damage_100'; $qstat4 = 'range_100'; $qstat5 = "damage_type";
	  $hstat3 = 'Damage'; $hstat4 = 'Range'; $hstat5 = "Damage Type";
	  $stat3unit = ' units'; $stat4unit = ' m'; $stat5unit = ' ';
	  break;
	 case 11:
	  //devices
	  $ktable = "item_device";
	  $qstat1 = "energy_100"; $qstat2 = "range_100";
	  $hstat1 = "Energy"; $hstat2 = "Range";
	  $stat1unit = ' units'; $stat2unit = ' m';
	  break;
	 case 12:
	  //system
	  break;
	 case 13:
	  //base
	  break;
	 case 14:
	  //beam weapon
	  $ktable = "item_beam";
	  $qstat1 = "damage_100"; $qstat2 = "range_100"; $qstat3 = "energy_100"; $qstat4 = "reload_100"; $qstat5 ="damage_type";
	  $hstat1 = "Damage"; $hstat2 = "Range"; $hstat3 = "Energy"; $hstat4 = "Reload"; $hstat5 = "Damage Type";
	  $stat1unit = ' units'; $stat2unit = ' m'; $stat3unit = ' units'; $stat4unit = ' seconds'; $stat5unit = ' ';
	  break;
	 case 15:
	  //missle launcher
	  $ktable = "item_missile";
	  $qstat1 = "energy_100"; $qstat2 = "reload_100"; $qstat3 = "ammo_per_shot"; $qstat5 ="ammo_type_id";
	  $hstat1 = "Energy"; $hstat2 = "Reload"; $hstat3 = "Fires"; $hstat5 = "Ammo";	
	  $stat1unit = ' units'; $stat2unit = ' seconds'; $stat3unit = ' round(s)'; $stat5unit = ' ';
	  break;
	 case 16:
	  //projectile weapon
	  $ktable = "item_projectile";
	  $qstat1 = "energy_100"; $qstat2 = "reload_100"; $qstat3 = "ammo_per_shot"; $qstat4 = "range_100"; $qstat5 ="ammo_type_id";
	  $hstat1 = "Energy"; $hstat2 = "Reload"; $hstat3 = "Fires"; $hstat4 = "Range"; $hstat5 = "Ammo";
	  $stat1unit = ' units'; $stat2unit = ' seconds'; $stat3unit = ' round(s)'; $stat4unit = ' m'; $stat5unit = ' ';
	  break;
	 case 17:
	  //countermeasure
	  break;
	 case 18:
	  //over rides
	  break;
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?PHP echo $item_info->get_item_attribute("name", "base", "1"); ?> - The Earth &amp; Beyond Arsenal</title>
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
<input name="search" type="text" id="search" value="<?php if(isset($_SESSION['search'])){echo $_SESSION['search'];}?>" size="31"/>
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
   <h2><?PHP echo $item_info->get_item_attribute("name", "base", "1"); ?></h2>
   <div class="feedback"><a href="../contact.php" target="_blank"><img src="../assets/feedbackbutton.png" border="0"/></a><br /></div>
	<div class="iconframe"><img src="../icons/<?PHP $image = $item_info->get_item_image($id); $image = str_ireplace('i_pu', '', $image); echo $image; ?>.jpg" border="0"></div><br />
    <!-- Name variable -->
    <div class="fieldbox"><div class="field">Name: </div><?PHP echo $item_info->get_item_attribute("name", "base", "1"); ?></div>
    <!-- Level variable -->
    <div class="fieldbox"><div class="field">Level: </div><?PHP echo $item_info->get_item_attribute("Level", "base", "1"); ?></div>
    <!-- Type variable -->
    <div class="fieldbox"><div class="field">Type: </div>
	<?PHP 
	/* This grabs the item type then looks up the actual item type name for display */
	$type = $item_info->get_item_attribute("type", "base", "1");
	$type_text = $item_info->get_secondary_attribute("name", "item_type", "id", $type, "1");
	echo $type_text; 
	?>
    </div> 
    <!-- Class and race variables.  This checks for the presence of $qstat1 because if this is set it means
    that the item type is one that has race and class information. -->
    <?php if(isset($qstat1)) { ?>
    <div class="fieldbox"><div class="field">Race: </div>
	<?php 
	$race = $item_info->get_secondary_attribute("rest_race", "$ktable", "item_id", substr($id, 1), "1"); 
	if($race == 0){
	$race = 'All';
	} elseif($race == 1) {
	$race = 'Terran Restricted';
	} elseif($race == 2) {
	$race = 'Jenquai Restricted';
	} elseif($race == 3) {
	$race = 'Progen Only';
	} elseif($race == 4) {
	$race = 'Progen Restricted';	
	} elseif($race == 5) {
	$race = 'Jenquai Only';
	} elseif($race == 6) {
	$race = 'Terran Only';	
	} else {
	$race = 'Unknown';	
	}
	
	echo $race;
	?>    
    </div>
    <!-- Class variable, similar process to race processing above -->
    <div class="fieldbox"><div class="field">Class: </div>
	<?php 
	$class = $item_info->get_secondary_attribute("rest_prof", "$ktable", "item_id", substr($id, 1), "1"); 
	if($class == 0){
	$class = 'All';	
	} elseif($class == 3) {
	$class = 'Explorer Only';
	} elseif($class == 5) {
	$class = 'Trader Only';	
	} elseif($class == 6) {
	$class = 'Warrior Only';
	} else {
	$class = 'Unknown';
	}	
	
	echo $class;
	?>    
    </div>
    <?php } ?>
    <!-- Manufacturable variable -->
    <div class="fieldbox"><div class="field">Manufacturable: </div>
	<?PHP 
	$manufacturable = $item_info->get_item_attribute("no_manu", "base", "1"); 
	if($manufacturable == 1){
	$manufacturable = 'No';
	} else {
	$manufacturable = 'Yes';
	}
	
	echo $manufacturable;
	?>
    </div>
    <!-- Subcategory variable, honestly this is redundant for most item types -->
    <div class="fieldbox"><div class="field">Sub-category : </div>
	<?PHP 
	$sub_type = $item_info->get_item_attribute("sub_category", "base", "1"); 
	$sub_type_text = $item_info->get_secondary_attribute("subcategory", "item_subcategories", "id", $sub_type, "1");
	
	echo $sub_type_text;
	?>
    </div> 
    <!-- Description variable -->   
    <div class="fieldbox"><div class="field">Description: </div><?PHP echo $item_info->get_item_attribute("Description", "base", "1"); ?></div>  
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
        <div class="infotext">
        <h3>Effects Information</h3><br /><br />
        <div class="infoindent">
        
        <!-- Beginning of item effects section -->
        
        <?php		
		$effects_info = new effects_info($conn, $id);
		$effect_ids = $effects_info->get_item_effects();
		foreach($effect_ids as $effect) {
			$description = $effects_info->get_description($effect['item_effect_base_id']);
			/* Finds and replaces the regex with the applicable variable.  After running through these it'll return $description[0]['Tooltip'] 
			with properly formatted values for each item effect in $description[0]['Description'].  Can be done with preg_match_all, but it's 
			not worth the trouble.  Don't need to check if VarDatas are set because they'll be 0 if they're not set and the regex won't find 
			anything to replace anyway because %value% should always correspond to the number of VarDatas */
			$description[0]['Tooltip'] = preg_replace("/%value\d.\df%/i", number_format($effect['Var1Data'], 1), $description[0]['Tooltip'], 1);
			$description[0]['Tooltip'] = preg_replace("/%value\d.\df%/i", number_format($effect['Var2Data'], 1), $description[0]['Tooltip'], 1);
			$description[0]['Tooltip'] = preg_replace("/%value\d.\df%/i", number_format($effect['Var3Data'], 1), $description[0]['Tooltip'], 1);
		?>
        
        <div class="fieldbox">
        <div class="field"><?php echo $description[0]['Description'].' :: '; ?></div><?php echo $description[0]['Tooltip']; ?>
        </div>
            
		<?php } ?>
        
        </div>
        <br />
        </div>        
        <div class="infotext">
        <h3>Other Information</h3><br /><br />
        <div class="infoindent">   
		<!-- Unique variable -->        
        <div class="fieldbox"><div class="field">Unique: </div>
		<?PHP 
		$unique = ($item_info->get_item_attribute("unique", "base") == "1") ? "Yes" : "No"; // Check if item is unique
		echo $unique; 
		?>
        </div>
        <!-- Custom variable -->
        <div class="fieldbox"><div class="field">Custom: </div>
		<?PHP 
		$custom = ($item_info->get_item_attribute("custom_flag", "base") == "1") ? "Yes" : "No"; // Check if item is custom
		echo $custom; 
		?>
        </div>
               
        <!-- Additional stats, have to check if each one is set before displaying --> 
        
        <?php if(isset($qstat1)) { ?>
        <div class="fieldbox"><div class="field"><?PHP echo $hstat1,": "; ?></div><?PHP echo $item_info->get_secondary_attribute("$qstat1", "$ktable", "item_id", substr($id, 1), "1"); ?><?php echo $stat1unit; ?></div>
        <?php } ?>
        <?php if(isset($qstat2)) { ?>
        <div class="fieldbox"><div class="field"><?PHP echo $hstat2,": "; ?></div><?PHP echo $item_info->get_secondary_attribute("$qstat2", "$ktable", "item_id", substr($id, 1), "1"); ?><?php echo $stat2unit; ?></div>
        <?php } ?>
        <?php if(isset($qstat3)) { ?>
        <div class="fieldbox"><div class="field"><?PHP echo $hstat3,": "; ?></div><?PHP echo $item_info->get_secondary_attribute("$qstat3", "$ktable", "item_id", substr($id, 1), "1"); ?><?php echo $stat3unit; ?></div>
        <?php } ?>
        <?php if(isset($qstat4)) { ?>  
        <div class="fieldbox"><div class="field"><?PHP echo $hstat4,": "; ?></div>
		<?PHP 
		$qstat4 = $item_info->get_secondary_attribute("$qstat4", "$ktable", "item_id", substr($id, 1), "1"); 
		if($qstat4 == null){
		echo 'Unknown';
		} else {
		echo $qstat4.$stat4unit;
		}
		?>
        </div>
        <?php } ?>
        <?php if(isset($qstat5)) { ?>
        <div class="fieldbox"><div class="field"><?PHP echo $hstat5,": "; ?></div>
		<?PHP 
		/* $qstat5 is special because it handles damage and ammo types, so if there's a damage type (ammo, beams, launchers), it'll
		look that up and get the damage type name.  It'll also look up ammo types for launchers.  If not it'll just display the regular
		$qstat5 variable */
		if($qstat5 == 'damage_type'){
			$qstat5 = $item_info->get_secondary_attribute("$qstat5", "$ktable", "item_id", substr($id, 1), "1"); 
			if($qstat5 == 0){
			$damage_type = 'Impact';
			} elseif($qstat5 == 1) {
			$damage_type = 'Explosive';
			} elseif($qstat5 == 2) {
			$damage_type = 'Plasma';
			} elseif($qstat5 == 3) {
			$damage_type = 'Energy';
			} elseif($qstat5 == 4) {
			$damage_type = 'EMP';
			} elseif($qstat5 == 5) {
			$damage_type = 'Chemical';
			} else {
			$damage_type = 'Unknown';
			}
			echo $damage_type;
		} elseif($qstat5 == 'ammo_type_id') {
			$qstat5 = $item_info->get_secondary_attribute("$qstat5", "$ktable", "item_id", substr($id, 1), "1");
			$ammo_type = $item_info->get_secondary_attribute("name", "item_ammo_type", "id", $qstat5, "1"); 
			echo $ammo_type;
		} else {
		$qstat5 = $item_info->get_secondary_attribute("$qstat5", "$ktable", "item_id", substr($id, 1), "1"); 
		echo $qstat5;
		}
		echo $stat5unit;
		?>
        </div>       
        <?php } ?>
        <!-- Selling price variable -->
        <div class="fieldbox"><div class="field">Vendor Selling Price: </div><?PHP echo number_format($item_info->get_item_attribute("selling_price", "base", "1")).' credits'; ?></div>
        <!-- Buying price variable -->
        <div class="fieldbox"><div class="field">Vendor Buying Price: </div><?PHP echo number_format($item_info->get_item_attribute("buying_price", "base", "1")).' credits'; ?></div>
        <!-- Stack variable -->
        <div class="fieldbox"><div class="field">Stack: </div><?PHP echo $item_info->get_item_attribute("max_stack", "base", "1"); ?> units</div>
         
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
		if($manufacturable == 'Yes'){
		$i = 0;
        $comp[$i] = array(); 
		for($i = 1; $i < 7; $i++){
		$query = "comp_".$i;
		$comp[$i]['id'] = $item_info->get_item_attribute_fk("$query", "item_manufacture", "item_id", "1");
		if ($comp[$i]['id'] != -1) { 
			$item_info->set_id('i'.$comp[$i]['id']);
			$comp[$i]['name'] = $item_info->get_item_attribute('name', 'base', '1');			
			$comp[$i]['image'] = $item_info->get_item_image($comp[$i]['id']);
			$item_info->set_id($id);
		?>
        
        <div class="iconframe"><img src="../icons/<?PHP $comp_image = str_ireplace('i_pu', '', $comp[$i]['image']); echo $comp_image; ?>.jpg" border="0"></a></div>
        <div class="comp_info_pos">
        <div class="fieldbox"><div class="field">Component <?php echo $i; ?>: </div><a href="view_item.php?iid=i<?php echo $comp[$i]['id']; ?>"><?PHP echo $comp[$i]['name']; ?></a></div></div>
        <?php } } } else {
			echo 'Non-manufacturable.';
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
     
     <div class="fieldbox"><div class="field">Mob name: </div><?php echo $results[$i]['name']; ?> - (Level <?php echo $results[$i]['level']; ?>)<br />
     <div class="field">Item drop chance: </div><?php echo $results[$i]['drop_chance']; ?>%<br />
     
	 <?php 
	 /* If the above functions returned sector locations for mobs, this will loop through the now-populated $results array
	 This will also check if the sector name has already been listed (as there can be several spawn ids in the same sector.
	 It will only display the first instance of a sector name. Could add specific spawn locations, but that's probably too specific. */
	 if(isset($results[$i]['sectors'])){ 
	 	echo '<div class="field">Location: </div>';
	 	for($j = 0; $j < count($results[$i]['sectors']); $j++){
			if(($j + 1) < count($results[$i]['sectors'])){
				if(isset($results[$i]['sectors'][$j][0]['name']) && $results[$i]['sectors'][$j][0]['name'] == $results[$i]['sectors'][$j + 1][0]['name']){
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