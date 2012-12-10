<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a partners module for PyroCMS
 *
 * @author 		eMerge
 * @website		http://www.easyemerge.com
 * @package 	PyroCMS
 * @subpackage 	Partners Module
 */
class Admin extends Admin_Controller
{
	protected $section = 'items';

	public function __construct()
	{
		parent::__construct();

		// Load all the required classes
		$this->load->model('partners_m');
		$this->load->library('form_validation');
		$this->lang->load('partners');

		// Set the validation rules
		$this->item_validation_rules = array(
			array(
				'field' => 'title',
				'label' => 'Name/Title',
				'rules' => 'trim|max_length[100]|required'
			),
			array(
				'field' => 'desc',
				'label' => 'Description',
				'rules' => 'trim|max_length[2700]'
			),
			array(
				'field' => 'url',
				'label' => 'Partner Website',
				'rules' => 'trim|max_length[100]'
			),
			array(
				'field' => 'video_code',
				'label' => 'Video Embed Code',
				'rules' => 'trim|max_length[2700]'
			),
			array(
				'field' => 'inactive',
				'label' => 'Disable This Entry',
				'rules' => 'trim|max_length[100]'
			),
			array(
				'field' => 'cat',
				'label' => 'Category',
				'rules' => 'trim|max_length[100]'
			),
		);

		$this->load->library('upload','partners');

		// Add WYSIWYG support to the form
		$this->template->append_metadata($this->load->view('fragments/wysiwyg', $this->data, TRUE));

		// We'll set the partials and metadata here since they're used everywhere
		$this->template->append_js('module::admin.js')
						->append_css('module::admin.css');
	}

	/**
	 * List all items
	 */
	public function index()
	{
		// here we use MY_Model's get_all() method to fetch everything
		$items = $this->partners_m->get_all();

		// Build the view with partners/views/admin/items.php
		$this->data->items =& $items;
		$this->template->title($this->module_details['name'])
						->build('admin/items', $this->data);
	}

	public function create()
	{
		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->item_validation_rules);

		// check if the form validation passed
		if($this->form_validation->run())
		{
			// See if the model can create the record
			if($this->partners_m->create($this->input->post()))
			{
				// All good...
				$this->session->set_flashdata('success', lang('partners.success'));
				redirect('admin/partners');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('partners.error'));
				redirect('admin/partners/create');
			}
		}
		
		foreach ($this->item_validation_rules AS $rule)
		{
			$this->data->{$rule['field']} = $this->input->post($rule['field']);
		}

		// Build the view using partners/views/admin/form.php
		$this->template->title($this->module_details['name'], lang('partners.new_item'))
						->build('admin/form', $this->data);
	}
	
	public function edit($id = 0)
	{
		$this->data = $this->partners_m->get($id);

		// Set the validation rules from the array above
		$this->form_validation->set_rules($this->item_validation_rules);

		// check if the form validation passed
		if($this->form_validation->run())
		{
			// get rid of the btnAction item that tells us which button was clicked.
			// If we don't unset it MY_Model will try to insert it
			unset($_POST['btnAction']);
			
			// See if the model can create the record
			if($this->partners_m->update($id, $this->input->post()))
			{
				// All good...
				$this->session->set_flashdata('success', lang('partners.success'));
				redirect('admin/partners');
			}
			// Something went wrong. Show them an error
			else
			{
				$this->session->set_flashdata('error', lang('partners.error'));
				redirect('admin/partners/create');
			}
		}

		// Build the view using partners/views/admin/form.php
		$this->template->title($this->module_details['name'], lang('partners.edit'))
						->build('admin/form', $this->data);
	}
	
	public function delete($id = 0)
	{
		// make sure the button was clicked and that there is an array of ids
		if (isset($_POST['btnAction']) AND is_array($_POST['action_to']))
		{
			// pass the ids and let MY_Model delete the items
			$this->partners_m->delete_many($this->input->post('action_to'));
		}
		elseif (is_numeric($id))
		{
			// they just clicked the link so we'll delete that one
			$this->partners_m->delete($id);
		}
		redirect('admin/partners');
	}
}
