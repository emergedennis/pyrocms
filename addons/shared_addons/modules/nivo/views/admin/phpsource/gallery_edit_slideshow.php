<?php
//include ('../phpsource/adminfunctions.php');
$sql = "SELECT * FROM ".$tablename." WHERE gal_id = ".$_GET["id"]."";
$result = mysql_query($sql);
$edit_row = mysql_fetch_assoc($result);
?>
<table>
  <tr>
    <td class="mainText" style="padding:10px">
	  <!--<strong><a href="<?php echo $main_gallery_script;?>?category=<?php echo $category; ?>">Return to Photo Album </a></strong>-->
	  <p>
	  <?php
	  $photo_msg_true = '';
	  	if(isset($photo_msg)){ $photo_msg_true = $photo_msg; }

	  if($photo_msg_true != ""){
	    echo "<strong>".$photo_msg."</strong><p>";
	  }
	  ?>
	  <?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
	  <form action="" method="post" enctype="multipart/form-data" name="form1">
	  <p style="display:block;"><strong>Photo Category:</strong><br />
	      <label>
	        <select name="category" id="select">
            <?php
			$sql = "SELECT * FROM ".$cat_table." ORDER BY cat_id";
			$result = mysql_query($sql);

				echo "<option value='0'> - select - </option>";
			while($row = mysql_fetch_assoc($result)){
				$selected = ($row["cat_id"] == $edit_row["cat"]) ? "selected": "";
				echo "<option value='".$row["cat_id"]."' ".$selected.">".$row["cat_title"]."</option>";
			}
			?>
          </select>
	      </label>
	      <br />
	  </p>
      <p style="display:block;">
	  <strong>Caption Title:</strong><br>
	  <input name="title" type="text" value="<?php echo $edit_row["gal_title"]; ?>" size="30">
      </p>
	  <p  style="display:block;"><strong>Caption Text:</strong><br>
	  <textarea name="description" cols="50" rows="8"><?php echo $edit_row["gal_desc"]; ?></textarea></p>
	  <p>
      <p  style="display:block;"><strong>Image/Caption URL:</strong><br>
	  <input name="url" type="text" value="<?php echo $edit_row["url"]; ?>" size="70"></p>
      <br />
	  <?php echo "<img src='".UPLOAD_PATH."gallery/thumb/".$edit_row["gal_thumb"]."' alt='".$row["gal_title"]."' border='0'>"; ?>
	  <br />
      <p><strong style="color:#FF0000;">Important: Photo dimesions should be 444px wide by 244px high<br></strong></p>
	  <strong>Photo: </strong>(changing a photo will remove the old one)<br>
	  <input type="file" name="photo"> 
	  </p>

	  <input type="submit" name="update_photo" value="Update"><input name="gal_id" type="hidden" value="<?php echo $edit_row["gal_id"]; ?>"><input name="gal_full" type="hidden" value="<?php echo $edit_row["gal_full"]; ?>"><input name="gal_thumb" type="hidden" value="<?php echo $edit_row["gal_thumb"]; ?>">
	  </p>
	  <p><strong><a class="button" href="<?php echo $main_gallery_script;?>?category=<?php echo $category; ?>">Return to Photo Album </a></strong></p>
	  </form>
	  <?php echo form_close(); ?>
	</td>
  </tr>
</table>