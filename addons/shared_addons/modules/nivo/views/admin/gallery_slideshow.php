<?php
include ('phpsource/gallery_top_slideshow.php');
if(!isset($_GET['category'])){$_GET['category'] = 1;}
?>
	<div id="maincontent">
    <div class="main">
    <section class="title">
	<h4>Manage the Slideshow</h4>
    </section>
                        <section class="item">
                                    <div id="admin_containner">
                                        <?php
                                        switch ($action)
                                        {
                                            case 'main':
                                            include ("phpsource/".$main_gallery_include);
                                            break;
                                            case 'cats':
                                            include ("phpsource/".$main_gallery_include);
                                            break;
                                            case 'edit_cats':
                                            include ("phpsource/".$main_gallery_include);
                                            break;
                                            case 'add':
                                            include ("phpsource/".$add_gallery_script);
                                            break;
                                            case 'edit':
                                            include ("phpsource/".$edit_gallery_script);
                                            break;
                                            case 'view':
                                            include ("phpsource/".$view_gallery_script);
                                            break;
                                            case 'delete':
                                            include ("phpsource/".$delete_gallery_script);
                                            break;
                                        }
                                        ?>
                                    </div>
                        </section>
     
     </div>
	</div><!-- end maincontent -->