<div class="case-study-widget">
	<?php foreach($casestudies_widget as $post_widget): ?>
		<div><?php echo anchor('casestudies/'.date('Y/m', $post_widget->created_on) .'/'.$post_widget->slug, $post_widget->title); ?></div>
		<div><?php echo $post_widget->intro; ?></div>
	<?php endforeach; ?>
</div>