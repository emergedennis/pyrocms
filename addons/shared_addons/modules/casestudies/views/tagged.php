<h2 id="page_title"><?php echo lang('casestudies_tagged_label').': '.str_replace('-', ' ', $tag); ?></h2>
<?php if (!empty($casestudies)): ?>
<?php foreach ($casestudies as $post): ?>
	<div class="casestudies_post">
		<!-- Post heading -->
		<div class="post_heading">
			<h2><?php echo  anchor('casestudies/' .date('Y/m', $post->created_on) .'/'. $post->slug, $post->title); ?></h2>
			<p class="post_date"><?php echo lang('casestudies_posted_label');?>: <?php echo format_date($post->created_on); ?></p>
			<?php if($post->category_slug): ?>
			<p class="post_category">
				<?php echo lang('casestudies_category_label');?>: <?php echo anchor('casestudies/category/'.$post->category_slug, $post->category_title);?>
			</p>
			<?php endif; ?>
			<?php if($post->keywords): ?>
			<p class="post_keywords">
				<?php echo lang('casestudies_tagged_label');?>:
				<?php echo $post->keywords; ?>
			</p>
			<?php endif; ?>
		</div>
		<div class="post_body">
			<?php echo $post->intro; ?>
		</div>
	</div>
<?php endforeach; ?>

<?php echo $pagination['links']; ?>

<?php else: ?>
	<p><?php echo lang('casestudies_currently_no_posts');?></p>
<?php endif; ?>