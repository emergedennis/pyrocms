<ol>
	<li class="even" style="height:200px;">
		<label>Number to display</label>
		<?php echo form_input('limit', $options['limit']); ?>
		<label for="id">Choose Post Category</label>
		<?php echo form_dropdown('id', $select_cat, $options['id']); ?>
		<?php echo $options['id']; ?>
	</li>
</ol>