<?php if(count($images) != 0): ?>
	<!-- theme settings -->
	<?php if($options['theme'] === 'none' || $options['theme'] === 'default'): ?>
		<div id="slider-images-wrapper" class="slider-wrapper <?php echo ($options['theme'] != 'none') ? 'theme-default' : null; ?>" >
	<?php else: ?>
		<div id="slider-images-wrapper" class="slider-wrapper theme-<?php echo $options['theme']; ?>" >
	<?php endif; ?>
		<div id="slider-images" class="nivoSlider">
			
			<?php foreach($images as $image): ?>

					<?php if($image->url): ?>
						<a href="<?php echo $image->url; ?>">
							<img src="<?php echo BASE_URL.UPLOAD_PATH; ?>gallery/full/<?php echo $image->gal_full; ?>" alt="" <?php echo ($options['controlNavThumbs'] === 'true') ? 'data-thumb="'.BASE_URL.UPLOAD_PATH.'gallery/thumb/'.$image->gal_thumb.'"' : null; ?> <?php echo ($options['captions'] === 'true') ? 'title="#caption_'.$image->gal_id.'"' : null; ?> />
						</a>
					<?php else: ?>
						<img src="<?php echo BASE_URL.UPLOAD_PATH; ?>gallery/full/<?php echo $image->gal_full; ?>" alt="" <?php echo ($options['controlNavThumbs'] === 'true') ? 'data-thumb="'.BASE_URL.UPLOAD_PATH.'gallery/thumb/'.$image->gal_thumb.'"' : null; ?> <?php echo ($options['captions'] === 'true') ? 'title="#caption_'.$image->gal_id.'"' : null; ?> />
					<?php endif; ?>
				
			<?php endforeach; ?>
		</div>
	</div>

	<?php if($options['captions'] === 'true'): ?>
		<?php foreach($images as $image): ?>
			<?php if($image->gal_desc || $image->gal_title): ?>

				<div id="caption_<?php echo $image->gal_id; ?>" class="nivo-html-caption">
		    		<div class="caption-title"><?php echo $image->gal_title; ?></div>
		    		<div class="caption-desc"><?php echo $image->gal_desc; ?><a class="caption-link" href="<?php echo $image->url; ?>">...Read More</a></div>
				</div>

			<?php else: ?>
			<?php endif; ?>
		<?php endforeach; ?>
	<?php endif; ?>

	<br style="clear:both;">

	<script type="text/javascript">
	$('#slider-images').nivoSlider({
		<?php echo ($options['effect']) ? 'effect: "'.$options['effect'].'",' : null; ?>
		<?php echo ($options['animSpeed']) ? 'animSpeed: "'.$options['animSpeed'].'",' : null; ?>
		<?php echo ($options['pauseTime']) ? 'pauseTime: "'.$options['pauseTime'].'",' : null; ?>
		<?php echo ($options['directionNav']) ? 'directionNav: '.$options['directionNav'].',' : null; ?>
		<?php echo ($options['directionNavHide']) ? 'directionNavHide: '.$options['directionNavHide'].',' : null; ?>
		<?php echo ($options['controlNav']) ? 'controlNav: '.$options['controlNav'].',' : null; ?>
		<?php echo ($options['controlNavThumbs']) ? 'controlNavThumbs: '.$options['controlNavThumbs'].',' : null; ?>
		<?php echo ($options['controlNavThumbs']) ? 'controlNavThumbsFromRel: '.$options['controlNavThumbs'].',' : null; ?>
		<?php echo ($options['keyboardNav']) ? 'keyboardNav: '.$options['keyboardNav'].',' : null; ?>
		<?php echo ($options['pauseOnHover']) ? 'pauseOnHover: '.$options['pauseOnHover'].',' : null; ?>
		<?php echo ($options['manualAdvance']) ? 'manualAdvance: '.$options['manualAdvance'].',' : null; ?>
		<?php echo ($options['slices']) ? 'slices: '.$options['slices'].',' : null; ?>
		<?php echo ($options['boxCols']) ? 'boxCols: '.$options['boxCols'].',' : null; ?>
		<?php echo ($options['boxRows']) ? 'boxRows: '.$options['boxRows'].',' : null; ?>
	});
	</script>
<?php else: ?>
	<div class="slider-wrapper">Slider contains no images.</div>
<?php endif; ?>
<br style="clear:both;">