<section class="title">
	<!-- We'll use $this->method to switch between partners.create & partners.edit -->
	<h4><?php echo lang('partners:'.$this->method); ?></h4>
</section>

<section class="item">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
		
		<div class="form_inputs">
	
		<ul>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="name"><?php echo lang('partners:title'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('title', set_value('title', $title), 'class="width-15"'); ?></div>
			</li>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="name"><?php echo lang('partners:img'); ?> </label>
				<div class="input"><?php if(!isset($img)){$img='';} if($img != ''){ ?><h6 style="padding:0;margin:0;">Existing Image - Uploading a new image will replace the existing image</h6><div style="padding:20px;"><img src="<?php echo BASE_URL.UPLOAD_PATH.'partners/'.$img; ?>"></div><?php } ?><div>Select an Image</div><?php echo form_upload('img', set_value('img', $url), 'class="width-15"'); ?></div>
			</li>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="name"><?php echo lang('partners:desc'); ?> </label>
				<div class="input"><?php echo form_textarea('desc', set_value('desc', $desc), 'class="wysiwyg-simple"'); ?></div>
			</li>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="name"><?php echo lang('partners:url'); ?> </label>
				<div class="input"><div>Please be sure to include http:// in your URL</div><?php echo form_input('url', set_value('url', $url), 'class="width-15"'); ?></div>
			</li>
			<li style="display:none;" class="<?php echo alternator('', 'even'); ?>">
				<label for="name"><?php echo lang('partners:video_code'); ?> </label>
				<div class="input"><div>Paste your video embed code from sites like YouTube or Vimeo here</div><?php echo form_textarea('video_code', set_value('video_code', $video_code), 'class="html"'); ?></div>
			</li>
			
			<input type="hidden" value="1" name="cat">
			<input type="hidden" value="0" name="inactive">
		</ul>
		</ul>
		
		</div>
		
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
		
	<?php echo form_close(); ?>

</section>