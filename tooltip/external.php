<?php 
//include('../../cheddar/arsenal.net-7.org_local_auth.php'); // Auth info variables, contains user, pwd, host and DB name
include('../../cheddar/net7.enbarsenal.com_auth.php'); // Alternate DB info from enbarsenal's server, useful if net-7 explodes
include('../../includes/enba/conn.class.php');
include('../../includes/enba/item_effects.class.php');
include('../../includes/enba/item_info.class.php');

// Gets item ID and type from index
if(array_key_exists('id', $_GET)){
$id = $_GET['id'];
$type = $_GET['type'];
}

// This array holds the fields to be displayed.  It brings down everything by default, so being selective is a good
// thing.  Going to make these context-sensitive at some point.
$display_fields = array('name', 'level', 'type', 'manufacturer', 'selling_price', 'buying_price', 'no_trade', 'no_manu', 'unique', 'description');

$db_conn = new db_conn($dbHost, $dbUser, $dbPass, $db);
$conn = $db_conn->make_conn();
// New item object for grabbing all item info
$item = new item_info($conn, $id);
// New effects object for grabbing all effects on item
$effects = new effects_info($conn, $id);

// Get all item info including type-specific info
$item_info = $item->get_all_item_info($id, $type, 'assoc');
// Get all item effects info
$item_effects = $effects->get_item_effects();
?>
<link href="../styles/tooltip.css" rel="stylesheet" type="text/css" />
<table class="container" cellpadding="0" cellspacing="0">
<?php 
if(!empty($item_info)){
?>
<tr>
   	<td class="content">
   	<div>
   	<div class="ul"></div>   
   	<?php 
	$keys = array_keys($item_info);
   	foreach($keys as $row){
		$item_info[$row] = $item->format_field($item_info[$row], $row, true);
   	}
	//print_r($item_info);
   	?>  
	<?php foreach($display_fields as $row) { ?>
    	<?php echo $item_info[$row]; ?>
        <br />
    <?php } ?>
    	
    <?php if(!empty($item_effects)){ echo '<br />'; foreach($item_effects as $effects) { ?>    
		<div class="ttfieldbox"><div class="field"><?php echo $effects['description']; ?> :: </div><?php echo $effects['stats']; ?></div>
	<?php } } ?> 
   	</div>
    </td>
<tr>
<?php } ?>
</table>