<?php
include('SimpleImage.php');
// Config
$gal_full_path  = FCPATH.UPLOAD_PATH.'gallery/full/';
$gal_thumb_path = FCPATH.UPLOAD_PATH.'gallery/thumb/';
$gal_orig_path  = FCPATH.UPLOAD_PATH.'gallery/original/';

$tablename     = $this->db->dbprefix('gallery_slideshow'); // Main gallery table
$positionfield = "lorder"; // Name or order field
$idfield       = "gal_id"; // Name of gallery id field

$cat_table     = $this->db->dbprefix('gallery_cat_slideshow');; // Name of gallery category table

$thumb_width_max = 180;
$thumb_height_max = 120;
$slideShowImage_width_max = 954;
$slideShowImage_height_max = 469;

$main_gallery_script = "admin/nivo/";
$main_gallery_include = "gallery_main_slideshow.php";
$top_gallery_script  = "gallery_top_slideshow.php";
$add_gallery_script  = "gallery_add_slideshow.php";
$delete_gallery_script = "gallery_delete_slideshow.php";
$edit_gallery_script = "gallery_edit_slideshow.php";
$view_gallery_script = "gallery_view_slideshow.php";


$moveID           = '';
if(isset($_GET['moveID'])){ $moveID = $_GET['moveID']; }

$current_category = '';
if(isset($_GET['category'])){ $current_category = $_GET['category']; }

$category = 0;

if(isset($_GET['category'])){ $category = $_GET['category']; }


if(empty($current_category))
{
	$current_category = 0;
	$_GET['category'] = 0;
}

if (isset ($_GET['page']) )
{
	$page_num = $_GET['page'];
	$_SESSION['page_num'] = $page_num;
}
else
{
	unset( $_SESSION['page_num'] );
}

// Handles deleting a photo within a category
Function Delete_Photo_in_Cat ($cat_id)
{
	$q      = "SELECT *  FROM $tablename WHERE cat='".mysql_real_escape_string($cat_id)."'";
	$result = mysql_query ($q);
	$rows   = array();
	while ($row = mysql_fetch_assoc($result) )
	{
		unlink ($gal_full_path.$row['gal_full']);
		unlink ($gal_thumb_path.$row['gal_thumb']);
		unlink ($gal_orig_path.$row['gal_thumb']);
	}

	$q      = "DELETE FROM $tablename WHERE cat='".mysql_real_escape_string($cat_id)."'";
	$result = mysql_query ($q);

	if($result)
		return mysql_affected_rows();
}

// Handles rearranging the order of pictures in a gallery
if(isset($_GET['move']))
{
	$currentgroup = 0;
	$moveID = $_GET['moveID'];
	$move   = $_GET['move'];

	if($move == "up")
	{
		$msql = "SELECT $positionfield FROM $tablename WHERE $idfield ='".mysql_real_escape_string($moveID)."'";
		$mresult = mysql_query($msql);
		$currentpos = mysql_fetch_array($mresult);
		$currentgroup = addslashes($currentpos[$groupname]);

		$m2sql = "SELECT MAX($positionfield) FROM $tablename WHERE $positionfield < ".$currentpos[$positionfield]. " AND cat ='".mysql_real_escape_string($current_category)."'";

		$m2result = mysql_query($m2sql);
		if ( mysql_num_rows($m2result) > 0 )
		{
			$newpos = mysql_fetch_array($m2result);
			$usql = "UPDATE $tablename SET $positionfield = ".$currentpos[$positionfield]." WHERE $positionfield = ".$newpos[0];
			$uresult = mysql_query($usql);
			$usql = "UPDATE $tablename SET $positionfield = ".$newpos[0]." WHERE $idfield ='".mysql_real_escape_string($moveID)."'";
			$uresult = mysql_query($usql);
		}
		header("location:".BASE_URL."admin/nivo/?page=".$_SESSION['page_num']."&category=$current_category");
	}
	if($move == "down")
	{
		$msql = "SELECT $positionfield FROM $tablename WHERE $idfield ='".mysql_real_escape_string($moveID)."'";
		$mresult = mysql_query($msql);
		$currentpos = mysql_fetch_array($mresult);
		$currentgroup = addslashes($currentpos[$groupname]);

		$m2sql = "SELECT MIN($positionfield) FROM $tablename WHERE $positionfield > ".$currentpos[$positionfield] . " AND cat ='".mysql_real_escape_string($current_category)."'";
		$m2result = mysql_query($m2sql);


		if ( mysql_num_rows($m2result) > 0 )
		{

		$newpos = mysql_fetch_array($m2result);
		$usql = "UPDATE $tablename SET $positionfield = ".$currentpos[$positionfield]." WHERE $positionfield = ".$newpos[0];
		$uresult = mysql_query($usql);
		$usql = "UPDATE $tablename SET $positionfield = ".$newpos[0]." WHERE $idfield ='".mysql_real_escape_string($moveID)."'";
		$uresult = mysql_query($usql);
		}

		header("location:".BASE_URL."admin/nivo/?page=".$_SESSION['page_num']."&category=$current_category");
	}
}

$action = '';
if(isset($_GET["action"])){ $action = $_GET["action"]; } else{ $action = 'main'; }

// Handles deleting a gallery category
$getDel = '';
if(isset($_GET['Delete'])){ $getDel = $_GET['Delete']; }
if($getDel==1 || isset($_POST['Delete']))
{
	if($catid = $_GET["catid"])
	{
		$sql = "DELETE FROM $cat_table  WHERE cat_id ='".mysql_real_escape_string($catid)."'";
		mysql_query($sql) or die(mysql_error());

		if ( Delete_Photo_in_Cat($catid) )
			$msg = "Category Deleted";
		$_GET["action"] = "cats";
	}

	/*
	 * Want to keep them on the same page to see the results of their action
	 * 8/12/2011 - DH
	 */

	//header("location: gallery.php?category=$current_category");
}

// Handles adding a new gallery category to database
if(isset($_POST["add_gallery_cat"]))
{
 	$sql = "INSERT INTO $cat_table  (cat_title) VALUES ('".mysql_real_escape_string($_POST["cat_title"])."')";
	mysql_query($sql) or die(mysql_error());
	$_GET["action"] = "cats";
	$msg = "Category Added!";
}

// Handles updating a gallery category name in database
if(isset($_POST["update_gallery_cat"]))
{
 	$sql = "UPDATE $cat_table  SET cat_title = '".mysql_real_escape_string($_POST["cat_title"])."' WHERE cat_id = '".mysql_real_escape_string($_POST["cat_id"])."'";
	mysql_query($sql) or die(mysql_error());
	$_GET["action"] = "cats";
	$msg = "Category Updated!";
}


// Handles adding a new photo to the gallery
if(isset($_POST["add_photo"]))
{
	if($_FILES["photo"]['tmp_name'] != "")
	{
		$cat_id = $_POST["category"];
		$filename = $_FILES['photo']['tmp_name'];

		//rename and scan for images
		$file_split = explode(".", $_FILES['photo']['name']);
		$new_file_name = preg_replace("/[[:punct:][:blank:]]/", "", $file_split[0]).date("ymdhis").".".$file_split[1];

		/*if (file_exists($file_location))
		{
			$photo_msg .= "The file name already exists!";
		}
		else
		{*/	// upload it first
			if (move_uploaded_file($_FILES['photo']['tmp_name'], $gal_orig_path.$new_file_name))
			{
				// resize and save for slide show image

				$image = new SimpleImage();
				$image->load($gal_orig_path.$new_file_name);
				$image->shrinkToWidth($thumb_width_max);
				$image->save($gal_thumb_path.$new_file_name);

				$image = new SimpleImage();
				$image->load($gal_orig_path.$new_file_name);
				$image->shrinkToWidth($slideShowImage_width_max);
				$image->save($gal_full_path.$new_file_name);
				
				$sql = "SELECT lorder FROM $tablename ORDER BY lorder DESC LIMIT 1";
				$result = mysql_query($sql);
				$order = mysql_fetch_row($result);
				$new_order = $order[0]+1;
				$sql = "INSERT INTO 
							$tablename 
						(gal_title, gal_desc, url, gal_full, gal_thumb, gal_date, cat, lorder)
							VALUES 
						('".mysql_real_escape_string($_POST["title"])."', 
						 '".mysql_real_escape_string($_POST["description"])."', 
						 '".mysql_real_escape_string($_POST["url"])."', 
						 '".mysql_real_escape_string($new_file_name)."', 
						 '".mysql_real_escape_string($new_file_name)."', 
						 NOW(), 
						 '".mysql_real_escape_string($cat_id)."', 
						 '".mysql_real_escape_string($new_order)."')";

				$result = mysql_query($sql);
				if (mysql_affected_rows()>0)
				$photo_msg = "Photo successfully uploaded!";
			}
			else
			{
				$photo_msg = " oops. Failed upon uploading!";
				echo 'Problem!'; // oops. Failed upon uploading
			}
		//}
	}
	else
	{
		$photo_msg .="You must supply a photo!";
	}
}

// Handles deleting a photo from database and unlinking from server
if(isset($_POST["delete_photo"])){
	$delete_gal_id = $_REQUEST['gal_id'];
	$sql = "SELECT * FROM $tablename WHERE gal_id = '".$delete_gal_id."'";
	$res = mysql_query($sql);
	
	if($res && mysql_num_rows($res) > 0)
	{
		$row = mysql_fetch_array($res);
		
		unlink ($gal_full_path.$row['gal_full']);
		unlink ($gal_thumb_path.$row['gal_thumb']);
		unlink ($gal_orig_path.$row['gal_thumb']);
						
		$sql       = "DELETE FROM $tablename WHERE gal_id = '".mysql_real_escape_string($_REQUEST["gal_id"])."'";
		$result    = mysql_query($sql);
		$photo_msg = "Photo successfully removed!";
	}
}



// Hnadles updating a photo when editing
if(isset($_POST["update_photo"])){
	
	if($_FILES["photo"]['tmp_name'] != "")
	{
		$cat_id = $_POST["category"];
		$filename = $_FILES['photo']['tmp_name'];
		
		//rename and scan for images
		$file_split = explode(".", $_FILES['photo']['name']);
		$new_file_name = preg_replace("/[[:punct:][:blank:]]/", "", $file_split[0]).date("ymdhis").".".$file_split[1];
			
		if (copy($_FILES['photo']['tmp_name'], $gal_orig_path.$new_file_name)) 
		{	
			// resize and save for thumb image
			$image = new SimpleImage();
			$image->load($gal_orig_path.$new_file_name);
			$image->shrinkToWidth($thumb_width_max);
			$image->save($gal_thumb_path.$new_file_name);
			// resize and save for slide show image
			$image = new SimpleImage();
			$image->load($gal_orig_path.$new_file_name);
			$image->shrinkToWidth($slideShowImage_width_max);
			$image->save($gal_full_path.$new_file_name);
						
			$delete_gal_id = $_REQUEST['gal_id'];
			$sql = "SELECT * FROM $tablename WHERE gal_id = '".$delete_gal_id."'";
			$res = mysql_query($sql);
			
			if($res && mysql_num_rows($res) > 0)
			{
				$row = mysql_fetch_array($res);
				
				unlink ($gal_full_path.$row['gal_full']);
				unlink ($gal_thumb_path.$row['gal_thumb']);
				unlink ($gal_orig_path.$row['gal_thumb']);
			}

							
			$sql = "UPDATE $tablename
					SET gal_title = '".mysql_real_escape_string($_POST["title"])."',
						gal_desc = '".mysql_real_escape_string($_POST["description"])."',
						url = '".mysql_real_escape_string($_POST["url"])."',
						gal_full = '".mysql_real_escape_string($new_file_name)."',
						gal_thumb = '".mysql_real_escape_string($new_file_name)."',
						cat = '".mysql_real_escape_string($_POST["category"])."'
					WHERE gal_id = '".mysql_real_escape_string($_POST["gal_id"])."'";

			$result = mysql_query($sql);
			echo mysql_error();
			$photo_msg = "Photo successfully uploaded!";
		}
		else
		{
			$photo_msg = " oops. Failed upon uploading!";			
			echo 'Problem!'; // oops. Failed upon uploading
		}
	}
	else{
		$sql = "UPDATE $tablename
				SET gal_title = '".mysql_real_escape_string($_POST["title"])."',
					gal_desc = '".mysql_real_escape_string($_POST["description"])."',
					url = '".mysql_real_escape_string($_POST["url"])."',
					cat = '".mysql_real_escape_string($_POST["category"])."'
				WHERE gal_id = '".mysql_real_escape_string($_POST["gal_id"])."'";

		$result = mysql_query($sql);
		$photo_msg = "Photo successfully updated!";
	}
}

// Below are utility functions needed for gallery
function Resize($Dir,$Image,$NewDir,$NewImage,$MaxWidth,$MaxHeight,$Quality)
	{list($ImageWidth,$ImageHeight,$TypeCode)=getimagesize($Dir.$Image);
	$ImageType=($TypeCode==1?"gif":($TypeCode==2?"jpeg":
		($TypeCode==3?"png":FALSE)));
	$CreateFunction="imagecreatefrom".$ImageType;
	$OutputFunction="image".$ImageType;
	if ($ImageType) {
		$Ratio=($ImageHeight/$ImageWidth);
		$ImageSource=$CreateFunction($Dir.$Image);
		if ($ImageWidth > $MaxWidth || $ImageHeight > $MaxHeight) {
			if ($ImageWidth > $MaxWidth) {
				$ResizedWidth=$MaxWidth;
				$ResizedHeight=$ResizedWidth*$Ratio;
			} else {
				$ResizedWidth=$ImageWidth;
				$ResizedHeight=$ImageHeight;
 	  		}
			if ($ResizedHeight > $MaxHeight) {
				$ResizedHeight=$MaxHeight;
				$ResizedWidth=$ResizedHeight/$Ratio;
			}
			$ResizedImage=imagecreatetruecolor($ResizedWidth,$ResizedHeight);
			imagecopyresampled($ResizedImage,$ImageSource,0,0,0,0,$ResizedWidth,
			$ResizedHeight,$ImageWidth,$ImageHeight);
		} else {
			$ResizedWidth=$ImageWidth;
			$ResizedHeight=$ImageHeight;
			$ResizedImage=$ImageSource;
		}
		$OutputFunction($ResizedImage,$NewDir.$NewImage,$Quality);
		return true;
	} else {
		return false;
	}
}


function Resize_crop($Dir,$Image,$NewDir,$NewImage,$MaxWidth,$MaxHeight,$Quality)
	{list($ImageWidth,$ImageHeight,$TypeCode)=getimagesize($Dir.$Image);
	$ImageType=($TypeCode==1?"gif":($TypeCode==2?"jpeg":
		($TypeCode==3?"png":FALSE)));
	$CreateFunction="imagecreatefrom".$ImageType;
	$OutputFunction="image".$ImageType;
	if ($ImageType)
	{
		$Ratio=($ImageHeight/$ImageWidth);

		$ImageSource=$CreateFunction($Dir.$Image);
		if ($ImageWidth > $MaxWidth || $ImageHeight > $MaxHeight)
		{


		################# croping #########################

		list($width, $height) = getimagesize($Dir.$Image);
		// Get new dimensions
		$new_width = $MaxWidth;
		$new_height = $MaxHeight;
		$new_ratio = $new_width/$new_height;

		// need to have a portrait
		if ($new_ratio < 1 )
		{	// keep the original width and reducet
			// the height to the required proportion
			if ($width > $height * $new_ratio)
				$width = $height * $new_ratio;
			else
				$height = $width / $new_ratio;
		}
		else
		{ // need a landscape
			// keep the original height and reduce the width
			if ( $height >  $width / $new_ratio	)
				$height = $width / $new_ratio;
			else
				$width = $height * $new_ratio;
		}
		// Resample
		$ResizedImage = imagecreatetruecolor($new_width, $new_height);

		imagecopyresampled($ResizedImage, $ImageSource, 0, 0, 0, 0, $new_width, $new_height, $width, $height);

		##########################################
		}

		else {
			$ResizedWidth=$ImageWidth;
			$ResizedHeight=$ImageHeight;
			$ResizedImage=$ImageSource;
		}
		$OutputFunction($ResizedImage,$NewDir.$NewImage,$Quality);

		return true;
	} else {
		return false;
	}
}