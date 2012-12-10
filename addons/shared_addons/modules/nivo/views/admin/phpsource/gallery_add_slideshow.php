<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td class="mainText" style="padding:10px">
	  <!--<strong><a href="<?php echo $main_gallery_script; ?>?category=<?php echo $category; ?>">Return to Photo Album</a></strong>-->
	  <?php
	  $cat = explode("_", $category);
	  ?>
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
				$selected = ($row["cat_id"] == $_GET["category"]) ? "selected": "";
				echo "<option value='".$row["cat_id"]."' ".$selected.">".$row["cat_title"]."</option>";
			}
			?>
          </select>
	      </label>
	      <br />
	  </p>
	  <p style="display:block;"><strong>Caption Title:</strong><br>
	      <input name="title" type="text" size="30">
	     </p>
	  <p style="display:block;"><strong>Caption Text:</strong><br>
	  <textarea name="description" cols="50" rows="8"></textarea>
	    </p>
        <p style="display:block;"><strong>Image/Caption URL:</strong><br>
	      <input name="url" type="text" size="70">
	     </p>
         <br />
        <p><strong style="color:#FF0000;">Important: Photo dimesions should be Xpx wide by Xpx high<br></strong></p>
		<p><strong>Photo:<br></strong>
	  <input type="file" name="photo">
	  <br /></p>
		<p>
		<!-- <input type="hidden" name="category" value="<?php echo $_GET["category"]; ?>">-->
	  <input type="submit" name="add_photo" value="Submit">
	    </p>
	  <p><strong><a class="button" href="<?php echo $main_gallery_script; ?>?category=<?php echo $category; ?>">Return to Photo Album</a></strong></p>
	  </form>
	  <?php echo form_close(); ?>
	</td>
  </tr>
</table>
