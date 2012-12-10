<?php
$category = $_GET["category"];

if($category=="") { $category = 0; }

if ($category )
#Photo Title has been commented out and description is displayed instead
	$sql = "SELECT COUNT(gal_id) AS total FROM ".$tablename." WHERE cat = '$category'";
else
	$sql = "SELECT COUNT(gal_id) AS total FROM ".$tablename;

$result = mysql_query($sql);
$row = mysql_fetch_assoc($result);

$total = $row["total"];
$num_per_page = 10;
$num_pages = ceil($total/$num_per_page);

$page = '';
if(isset($_GET["page"]) && !empty($_GET["page"])){ $page = $_GET["page"]; } else{ $page = 1; }

$offset = ($page == 1) ? 0: $num_per_page*($page-1);
$prev_link = ($page == 1) ? "Previous" : "<a href='".$_SERVER["PHP_SELF"]."?page=".($page-1)."&category=".$category."'>Previous</a>";
$next_link = (($page*$num_per_page) > $total) ? "Next" : "<a href='".$_SERVER["PHP_SELF"]."?page=".($page+1)."&category=".$category."'>Next</a>";
$page_array = array();
for($i=1; $i<= $num_pages; $i++){
	if($page == $i){
		$page_array[] = "<strong>".$i."</strong>";
	}
	else{
		$page_array[] = "<a href='".$_SERVER["PHP_SELF"]."?page=".($i)."&category=".$category."'>".$i."</a>";
	}
}
$pages = implode(", ", $page_array);
?>
<style type="text/css">
<!--
.style1 {font-weight: bold}
-->
</style>

<style type="text/css">
.wrapper table {width:618px;}
</style>

<table class="gallery-table2" width="628" border="0" cellspacing="0" cellpadding="0">
  <tr>
     <td class="" style="padding:10px">
<?php
$isCat = '';
if(isset($_GET["action"])){ $isCat = $_GET["action"]; }
if ($isCat=='cats' || $isCat=='edit_cats'){?>
	<style type="text/css">
    <!--
    .style1 {font-weight: bold}
    -->
    </style>

	<!--
    <p><strong>Manage Gallery Categories</strong></p>
    <p><a href="gallery.php"><strong>Return to Manage Gallery</strong></a></p>
     <strong><?php echo $msg;?></strong>
      <?php if(isset($_GET["edit_cat"])){
                $sql = "SELECT * FROM ".$cat_table." WHERE cat_id = '".$_GET["edit_cat"]."'";
                $result = mysql_query($sql);
                $edit_row = mysql_fetch_assoc($result);
                ?>


    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" name="form1">

      <p>Category Name:
        <input name="cat_title" type="text" value="<?php echo $edit_row["cat_title"]; ?>" />
    </p>
      <p>
        <label>
        <input type="submit" name="update_gallery_cat" id="button" value="Update Gallery Category" />
        <input type="hidden" name="cat_id" value="<?php echo $edit_row["cat_id"]; ?>" />
        <span class="style1"><a href="gallery.php?action=cats">Add Gallery Cagegory</a> </span></label>
    </p>
    </form>
    <?php }
 		else { ?>
    <form action="<?php echo $_SERVER['PHP_SELF'];?>" method="post" enctype="multipart/form-data" name="form1">
      <p>Category Name:
        <input name="cat_title" type="text" />
    </p>
      <p>
        <label>
        <input type="submit" name="add_gallery_cat" id="button" value="Add Gallery Category" />
        </label>
    </p>
    </form><br /><br /><br />
	-->
    
    <?php
    }
	
    $sql = "SELECT * FROM ".$cat_table." ORDER BY cat_title";
    $result = mysql_query($sql);
    if(mysql_num_rows($result) == 0){
        echo "No Categories!";
    }
    else{
        echo "<table width='100%' border='1' cellpadding='5' cellspacing='0'>";
        while($row = mysql_fetch_assoc($result)){
            echo "<tr>
							<td ><strong>".$row["cat_title"]."</strong></td>
							<td align='center' width='120px'>
							<a href='".$main_gallery_script."?action=cats&edit_cat=".$row["cat_id"]."'>Edit</a> | "; ?>
            <a href="javascript:delCat('<?php echo str_replace("'", "", $row["cat_title"]);?>',<?php echo $row["cat_id"]; ?>);">Remove</a> <?php echo "</td>";
        }
        echo "</table>";
    }
    ?>
<?php }
else {?>

		<a class="button" href="<?php echo $main_gallery_script; ?>?action=add&amp;category=<?php echo $category; ?>"><strong>&#43; Add Photos</strong></a> </strong>
<!--    <p><strong><a href="gallery.php?action=cats">MANAGE CATEGORIES</a></strong></p>
	   <p><strong>1.</strong> Click on the photo<strong> thumbnail</strong> or <strong>title</strong> to view the photo.<strong><br>
       2. </strong>Click on the <strong>edit</strong> link below the title to edit the photo.<strong><br>
       3. </strong>Click on the <strong>delete</strong> link below the title to remove the photo.</p>
-->
        <script type="text/javascript">
<!--
function MM_jumpMenu(targ,selObj,restore){ //v3.0
  eval(targ+".location='"+selObj.options[selObj.selectedIndex].value+"'");
  if (restore) selObj.selectedIndex=0;
}
//-->
</script>
	
         <p><strong>Category:</strong>
       <form action="" method="get">
        <select name="category" id="select" onchange="MM_jumpMenu('parent',this,0)">
            <?php
			$sql = "SELECT * FROM ".$cat_table." ORDER BY cat_title";
			$result = mysql_query($sql);
			echo "<option value='".$main_gallery_script."?category=0'>please select</option>";

			while($row = mysql_fetch_assoc($result)){
				$selected = ($category == $row["cat_id"]) ? "selected": "";
				echo "<option value='".$main_gallery_script."?category=".$row["cat_id"]."' ".$selected.">".$row["cat_title"]."</option>";
			}
			?>
          </select>
          <a class="button" href='admin/nivo/create' style="line-height:20px;height:20px;width:170px;display:block;">&#43;	Create New Category</a>
       </form>
          </p>
          
          <p style="font-style:italic;">Total Images: <?php echo $total; ?> - <a href='admin/nivo/?action=add&category=<?php echo $category; ?>'>Add a photo</a></p>

<table id="gallery-table" width="628" border="0" cellpadding="5" cellspacing="1" bgcolor="black">
	     <tr>
		   <td width='25%' class='bodyCopy' style="border:1px solid #D3CFCF; background:#EFEFEF;">
		     <table width="100%"  border="0" cellspacing="0" cellpadding="0">
			   <tr style="color:#3C3C3C;">
			     <td width="5"><?php echo $prev_link; ?></td>
				 <td align="center"><?php echo $pages; ?></td>
				 <td width="5" align="right"><?php echo $next_link; ?></td>
			   </tr>
			 </table>
		   </td>
		 </tr>
	   </table>
      <br /><br />

	   <?php
	   #$sql = "SELECT * FROM gallery WHERE gal_date > '$date' AND gal_date < '$end_date' AND cat = '$category' ORDER BY gal_date DESC LIMIT ".$offset.",".$num_per_page;
	   if ( $category)
			$sql = "SELECT * FROM ".$tablename." WHERE cat = '$category' ORDER BY lorder, gal_date DESC LIMIT ".$offset.",".$num_per_page;
		else
			$sql = "SELECT * FROM ".$tablename." ORDER BY lorder, gal_date DESC LIMIT ".$offset.",".$num_per_page;

	   $result = mysql_query($sql);
	   if(mysql_num_rows($result) == 0 && $category!=0) {
		   echo "<p>There are currently no photos!</p>";
	   }
	   else{
	     $column_count = 0;
		 $max_columns = 1;
		 echo "<table width='100%' cellpadding='0' cellspacing='0' border='0'>";
		 echo "<tr>";
		 while($row = mysql_fetch_assoc($result)){
		   if($column_count == $max_columns){
		     echo "</tr><tr>";
			 $column_count = 0;
		   }
		   echo "<td width='100' align='center' style='padding: 10px; border-bottom: 1px dashed #F06098;'>";
		   echo "<a href='".$main_gallery_script."?action=view&amp;id=".$row["gal_id"]."&category=".$category."'>
						<img src='".UPLOAD_PATH."gallery/thumb/".$row["gal_thumb"]."'  width='90px' alt='".$row["gal_desc"]."' border='0'>
					</a></td>";
		   echo "<td align='justify' valign='top' style='padding: 10px; border-bottom: 1px dashed #F06098;'>";
		   echo "<a href='".$main_gallery_script."?action=view&amp;id=".$row["gal_id"]."&category=".$category."'><strong>".$row["gal_title"]."</strong></a><br><br>Posted on ".$row["gal_date"]."</td>";
		   echo "<td  align='center' valign='top' style='padding: 10px; border-bottom: 1px dashed #F06098;'>";
		   echo "<a class='button' href='".$main_gallery_script."?action=edit&amp;id=".$row["gal_id"]."&category=".$category."'>Edit</a> &nbsp;|&nbsp; <a class='button' href='".$main_gallery_script."?action=delete&amp;id=".$row["gal_id"]."&category=".$category."'>Delete</a>";


		   // Disable moving order of pictures if no category is selected, table design does not support this atm - DH August 19, 2011

		   $thePageNum = '';
		   if(isset($_SESSION['page_num'])){ $thePageNum = $_SESSION['page_num']; }


		   if(isset($_GET['category']) && $_GET['category'] != 0)
		   {
			   echo "&nbsp;|&nbsp; <a href='admin/nivo/?moveID=".$row["gal_id"]."&page=".$thePageNum."&move=up&category=".$_GET["category"]."'><img src='".SHARED_ADDONPATH."modules/nivo/img/uparrow.gif' width='15' height='15' border='0'></a>
					  <a href='admin/nivo/?moveID=".$row["gal_id"]."&page=".$thePageNum."&move=down&category=".$_GET["category"]."'><img src='".SHARED_ADDONPATH."modules/nivo/img/downarrow.gif' width='15' height='15' border='0'></a>";
			}


		   $column_count++;
		   echo "</td>";
		 }
		 echo "</tr>";
		 echo "</table>";
	   }
	   ?>
	   <br>
	   <table width="628" border="0" cellpadding="5" cellspacing="1" bgcolor="black">
	     <tr>
		   <td width='25%' class='' style="border:1px solid #D3CFCF; background:#EFEFEF;">
		      <table width="100%"  border="0" cellspacing="0" cellpadding="0">
			    <tr style="color:#3C3C3C;">
				  <td width="5"><?php echo $prev_link; ?></td>
				  <td align="center"><?php echo $pages; ?></td>
				  <td width="5" align="right"><?php echo $next_link; ?></td>
				</tr>
			  </table>
		   </td>
         </tr>
	   </table>
       <?php } ?>
    </td>
  </tr>
  </table>