<section class="title">
	<h4><?php echo lang('partners:item_list'); ?></h4>
</section>

<section class="item">
	<?php echo form_open('admin/partners/delete');?>
	
	<?php if (!empty($items)): ?>
	
		<table>
			<thead>
				<tr>
					<th><?php echo form_checkbox(array('name' => 'action_to_all', 'class' => 'check-all'));?></th>
					<th><?php echo lang('partners:name'); ?></th>
					<th><?php echo lang('partners:slug'); ?></th>
					<th></th>
				</tr>
			</thead>
			<tfoot>
				<tr>
					<td colspan="5">
						<div class="inner"><?php $this->load->view('admin/partials/pagination'); ?></div>
					</td>
				</tr>
			</tfoot>
			<tbody>
				<?php foreach( $items as $item ): ?>
				<tr>
					<td><?php echo form_checkbox('action_to[]', $item->id); ?></td>
					<td><?php echo $item->title; ?></td>
					<td><a href="<?php echo rtrim(site_url(), '/').'/partners'; ?>">
						<?php echo rtrim(site_url(), '/').'/partners'; ?></a></td>
					<td class="actions">
						<?php echo
						anchor('partners', lang('partners:view'), 'class="button" target="_blank"').' '.
						anchor('admin/partners/edit/'.$item->id, lang('partners:edit'), 'class="button"').' '.
						anchor('admin/partners/delete/'.$item->id, 	lang('partners:delete'), array('class'=>'button')); ?>
					</td>
				</tr>
				<?php endforeach; ?>
			</tbody>
		</table>
		
		<div class="table_action_buttons">
			<?php $this->load->view('admin/partials/buttons', array('buttons' => array('delete'))); ?>
		</div>
		
	<?php else: ?>
		<div class="no_data"><?php echo lang('partners:no_items'); ?></div>
	<?php endif;?>
	
	<?php echo form_close(); ?>
</section>