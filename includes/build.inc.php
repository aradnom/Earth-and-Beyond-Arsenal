<?php
		$page = "../item/master";	
		// 2nd category for items referencing same-category items as components
		$secondcat = $_GET['cat'];
		
		// Beginning of components
		if(isset($row['comp1']) && $row['comp1amt'] != '0'){
		$path = "../icons/";
		$name = $row['comp1'];
		$name = addslashes($name);
		$sql2 = "SELECT id, cat, image_id, articleid, name FROM components WHERE name LIKE '%$name%' UNION SELECT id, cat, image_id, articleid, name FROM ores WHERE name LIKE '%$name%' UNION SELECT id, cat, image_id, articleid, name FROM $secondcat WHERE name LIKE '%$name%'";
		$stmt = $conn->prepare($sql2);
		$result = $stmt->execute();		
		$comp1 = $row['comp1'];
		$comp1amt = $row['comp1amt'];
		if($result == 1){
			$found = 0;
			foreach($conn->query($sql2) as $row2){				
				if(strtolower($row2['name']) == strtolower($name)){
				$found = 1;
				$image = str_replace("ipu", "", $row2['image_id']);	
				$cid = $row2['id'];
				$ccat = $row2['cat'];
				$cname = $row2['name'];	
				echo '<a title="ajax:../tooltip/external.php'."?id=".$cid.'&cat='.$ccat.'">'.'<div class="iconframe"><img src="'.$path.$image.'" /></div>  ';
				echo '<div class="buildinfolinks"><a href="'.$page.'.php?itemid='.$cid.'&cat='.$ccat.'">';
				}
			}
		}
		if($found == 0){
		echo '<div class="iconframe"><img src="'.$path.'noimg.jpg'.'" /></div>';
		echo '<div class="buildinfolinks">';
		}
		echo $comp1;
		if($found == 1){
			echo '</a>'; 
			}
			echo '<div class="field"> Amount:  '.$comp1amt.'<br /></div></div>';
		}	
		
		if(isset($row['comp2']) && $row['comp2amt'] != '0'){
		$path = "../icons/";
		$name = $row['comp2'];
		$name = addslashes($name);
		$sql2 = "SELECT id, cat, image_id, articleid, name FROM components WHERE name LIKE '%$name%' UNION SELECT id, cat, image_id, articleid, name FROM ores WHERE name LIKE '%$name%' UNION SELECT id, cat, image_id, articleid, name FROM $secondcat WHERE name LIKE '%$name%'";
		$stmt = $conn->prepare($sql2);
		$result = $stmt->execute();		
		$comp2 = $row['comp2'];
		$comp2amt = $row['comp2amt'];
		if($result == 1){
			$found = 0;
			foreach($conn->query($sql2) as $row2){					
				if(strtolower($row2['name']) == strtolower($name)){
				$found = 1;
				$image = str_replace("ipu", "", $row2['image_id']);	
				$cid = $row2['id'];
				$ccat = $row2['cat'];
				$cname = $row2['name'];	
				echo '<a title="ajax:../tooltip/external.php'."?id=".$cid.'&cat='.$ccat.'">'.'<div class="iconframe"><img src="'.$path.$image.'" /></div>  ';
				echo '<div class="buildinfolinks"><a href="'.$page.'.php?itemid='.$cid.'&cat='.$ccat.'">';
				}
			}
		}
		if($found == 0){
		echo '<div class="iconframe"><img src="'.$path.'noimg.jpg'.'" /></div>';
		echo '<div class="buildinfolinks">';
		}
		echo $comp2;
		if($found == 1){
			echo '</a>'; 
			}
			echo '<div class="field"> Amount:  '.$comp2amt.'<br /></div></div>';
		}
		
		if(isset($row['comp3']) && $row['comp3amt'] != '0'){
		$path = "../icons/";
		$name = $row['comp3'];
		$name = addslashes($name);
		$sql2 = "SELECT id, cat, image_id, articleid, name FROM components WHERE name LIKE '%$name%' UNION SELECT id, cat, image_id, articleid, name FROM ores WHERE name LIKE '%$name%' UNION SELECT id, cat, image_id, articleid, name FROM $secondcat WHERE name LIKE '%$name%'";
		$stmt = $conn->prepare($sql2);
		$result = $stmt->execute();		
		$comp3 = $row['comp3'];
		$comp3amt = $row['comp3amt'];
		if($result == 1){
			$found = 0;
			foreach($conn->query($sql2) as $row2){				
				if(strtolower($row2['name']) == strtolower($name)){
				$found = 1;
				$image = str_replace("ipu", "", $row2['image_id']);	
				$cid = $row2['id'];
				$ccat = $row2['cat'];
				$cname = $row2['name'];	
				echo '<a title="ajax:../tooltip/external.php'."?id=".$cid.'&cat='.$ccat.'">'.'<div class="iconframe"><img src="'.$path.$image.'" /></div>  ';
				echo '<div class="buildinfolinks"><a href="'.$page.'.php?itemid='.$cid.'&cat='.$ccat.'">';
				}
			}
		}
		if($found == 0){
		echo '<div class="iconframe"><img src="'.$path.'noimg.jpg'.'" /></div>';
		echo '<div class="buildinfolinks">';
		}
		echo $comp3;
		if($found == 1){
			echo '</a>'; 
			}
			echo '<div class="field"> Amount:  '.$comp3amt.'<br /></div></div>';
		}
		
		if(isset($row['comp4']) && $row['comp4amt'] != '0'){
		$path = "../icons/";
		$name = $row['comp4'];
		$name = addslashes($name);
		$sql2 = "SELECT id, cat, image_id, articleid, name FROM components WHERE name LIKE '%$name%' UNION SELECT id, cat, image_id, articleid, name FROM ores WHERE name LIKE '%$name%' UNION SELECT id, cat, image_id, articleid, name FROM $secondcat WHERE name LIKE '%$name%'";
		$stmt = $conn->prepare($sql2);
		$result = $stmt->execute();		
		$comp4 = $row['comp4'];
		$comp4amt = $row['comp4amt'];
		if($result == 1){
		$found = 0;
			foreach($conn->query($sql2) as $row2){					
				if(strtolower($row2['name']) == strtolower($name)){
				$found = 1;
				$image = str_replace("ipu", "", $row2['image_id']);	
				$cid = $row2['id'];
				$ccat = $row2['cat'];
				$cname = $row2['name'];	
				echo '<a title="ajax:../tooltip/external.php'."?id=".$cid.'&cat='.$ccat.'">'.'<div class="iconframe"><img src="'.$path.$image.'" /></div>  ';
				echo '<div class="buildinfolinks"><a href="'.$page.'.php?itemid='.$cid.'&cat='.$ccat.'">';
				}
			}
		}
		if($found == 0){
		echo '<div class="iconframe"><img src="'.$path.'noimg.jpg'.'" /></div>';
		echo '<div class="buildinfolinks">';
		}
		echo $comp4;
		if($found == 1){
			echo '</a>'; 
			}
			echo '<div class="field"> Amount:  '.$comp4amt.'<br /></div></div>';
		}
		
		if(isset($row['comp5']) && $row['comp5amt'] != '0'){
		$path = "../icons/";
		$name = $row['comp5'];
		$name = addslashes($name);
		$sql2 = "SELECT id, cat, image_id, articleid, name FROM components WHERE name LIKE '%$name%' UNION SELECT id, cat, image_id, articleid, name FROM ores WHERE name LIKE '%$name%' UNION SELECT id, cat, image_id, articleid, name FROM $secondcat WHERE name LIKE '%$name%'";
		$stmt = $conn->prepare($sql2);
		$result = $stmt->execute();		
		$comp5 = $row['comp5'];
		$comp5amt = $row['comp5amt'];
		if($result == 1){
			$found = 0;
			foreach($conn->query($sql2) as $row2){					
				if(strtolower($row2['name']) == strtolower($name)){
				$found = 1;
				$image = str_replace("ipu", "", $row2['image_id']);	
				$cid = $row2['id'];
				$ccat = $row2['cat'];
				$cname = $row2['name'];	
				echo '<a title="ajax:../tooltip/external.php'."?id=".$cid.'&cat='.$ccat.'">'.'<div class="iconframe"><img src="'.$path.$image.'" /></div>  ';
				echo '<div class="buildinfolinks"><a href="'.$page.'.php?itemid='.$cid.'&cat='.$ccat.'">';
				}
			}
		}
		if($found == 0){
		echo '<div class="iconframe"><img src="'.$path.'noimg.jpg'.'" /></div>';
		echo '<div class="buildinfolinks">';
		}
		echo $comp5;
		if($found == 1){
			echo '</a>'; 
			}
			echo '<div class="field"> Amount:  '.$comp5amt.'<br /></div></div>';
		}
		
		if(isset($row['comp6']) && $row['comp6amt'] != '0'){
		$path = "../icons/";
		$name = $row['comp6'];
		$name = addslashes($name);
		$sql2 = "SELECT id, cat, image_id, articleid, name FROM components WHERE name LIKE '%$name%' UNION SELECT id, cat, image_id, articleid, name FROM ores WHERE name LIKE '%$name%' UNION SELECT id, cat, image_id, articleid, name FROM $secondcat WHERE name LIKE '%$name%'";
		$stmt = $conn->prepare($sql2);
		$result = $stmt->execute();		
		$comp6 = $row['comp6'];
		$comp6amt = $row['comp6amt'];
		if($result == 1){
			$found = 0;
			foreach($conn->query($sql2) as $row2){				
				if(strtolower($row2['name']) == strtolower($name)){
				$found = 1;
				$image = str_replace("ipu", "", $row2['image_id']);	
				$cid = $row2['id'];
				$ccat = $row2['cat'];
				$cname = $row2['name'];	
				echo '<a title="ajax:../tooltip/external.php'."?id=".$cid.'&cat='.$ccat.'">'.'<div class="iconframe"><img src="'.$path.$image.'" /></div>  ';
				echo '<div class="buildinfolinks"><a href="'.$page.'.php?itemid='.$cid.'&cat='.$ccat.'">';
				}
			}
		}
		if($found == 0){
		echo '<div class="iconframe"><img src="'.$path.'noimg.jpg'.'" /></div>';
		echo '<div class="buildinfolinks">';
		}
		echo $comp6;
		if($found == 1){
			echo '</a>'; 
			}
			echo '<div class="field"> Amount:  '.$comp6amt.'<br /></div></div>';
		}
			
		if($row['manu'] == 'No' && $row['comp1'] == null){
		echo 'Non-manufacturable.';
		} elseif($row['manu'] == 'Yes' && $row['comp1'] == null){
		echo 'Unknown.';
		} elseif($row['manu'] == 'No' && $row['comp1'] != null){
		echo 'Non-manufacturable.';	
		}
?>