<section class="title">
	<!-- We'll use $this->method to switch between nivo.create & nivo.edit -->
	<h4><?php echo lang('nivo:'.$this->method); ?></h4>
</section>

<section class="item">

	<?php echo form_open_multipart($this->uri->uri_string(), 'class="crud"'); ?>
	
		<div class="form_inputs">
	
		<ul>
			<li class="<?php echo alternator('', 'even'); ?>">
				<label for="name"><?php echo lang('nivo:name'); ?> <span>*</span></label>
				<div class="input"><?php echo form_input('cat_title', set_value('cat_title', $cat_title), 'class="width-15"'); ?></div>
				<input type="hidden" name="cat_parent" value="0">
				<input type="hidden" name="cat_order" value="0">
			</li>
		</ul>
		
		</div>
		
		<div class="buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('save', 'cancel') )); ?>
		</div>
		
	<?php echo form_close(); ?>

</section>