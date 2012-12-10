<table>
  <tr>
    <td class="mainText" style="padding:10px">
	  <strong><a class="button" href="<?php echo $main_gallery_script; ?>?category=<?php echo $category; ?>">Return to Photo Album </a></strong>
	  <p>
	    <?php
	    $photo_msg_true = '';
	  	if(isset($photo_msg)){ $photo_msg_true = $photo_msg; }
	    if($photo_msg_true != ""){
		  echo "<strong>".$photo_msg."</strong><p>";
		}
		$sql = "SELECT * FROM ".$tablename." WHERE gal_id = ".$_GET["id"]."";
		$result = mysql_query($sql);
		$row = mysql_fetch_assoc($result);
		?>
		<?php echo " <div align='center'><img src='".UPLOAD_PATH."gallery/full/".$row["gal_thumb"]."' alt='".$row["gal_title"]."' border='0'></div>"; ?>
		<p><?php echo "<strong>".$row["gal_title"]."</strong><br>".$row["gal_desc"]."<p>".$row["gal_date"]."</p>"; ?></p>
		<p><strong><a class="button" href="<?php echo $main_gallery_script;?>?category=<?php echo $category; ?>">Return to Photo Album </a></strong></p>
	  </td>
	</tr>
</table>