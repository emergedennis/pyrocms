<table>
  <tr>
    <td class="mainText" style="padding:10px">
	  <!--<strong><a href="<?php echo $main_gallery_script;?>?category=<?php echo $category; ?>">Return to Photo Album</a></strong>-->
	  <p>
	  <?php 
	  $photo_msg_true = '';
	  	if(isset($photo_msg)){ $photo_msg_true = $photo_msg; }
	  if($photo_msg_true != ""){
	    echo "<strong>".$photo_msg."</strong><p>";
	  }
	  $sql = "SELECT * FROM ".$tablename." WHERE gal_id = ".$_GET["id"];
	  $result = mysql_query($sql);
	  $edit_row = mysql_fetch_assoc($result);
	  ?>
	  <?php if(!isset($_POST["delete_photo"])){  ?>
	  	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
	    <form action="" method="post" enctype="multipart/form-data" name="form1">
		<?php echo "<img src='".UPLOAD_PATH."gallery/thumb/".$edit_row["gal_thumb"]."' alt='".$edit_row["gal_title"]."' border='0'>"; ?>
		<p>
		<input type="submit" name="delete_photo" value="Delete Photo"><input name="gal_id" type="hidden" value="<?php echo $edit_row["gal_id"]; ?>"><input name="gal_full" type="hidden" value="<?php echo $edit_row["gal_full"]; ?>"><input name="gal_thumb" type="hidden" value="<?php echo $edit_row["gal_thumb"]; ?>"></p>
        <p><strong><a class="button" href="<?php echo $main_gallery_script;?>?category=<?php echo $category; ?>">Return to Photo Album </a></strong></p>
	    </form>
	    <?php echo form_close(); ?>
	  <?php } ?>
	</td>
  </tr>
</table>