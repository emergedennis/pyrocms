<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Nivo extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Nivo Slider'
			),
			'description' => array(
				'en' => 'A Proper Nivo Slider Module for PyroCMS.'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content', // You can also place modules in their top level menu. For example try: 'menu' => 'Nivo',
			'sections' => array(
				'items' => array(
					'name' 	=> 'nivo:items', // These are translated from your language file
					'uri' 	=> 'admin/nivo',
						'shortcuts' => array(
							'create' => array(
								'name' 	=> 'nivo:create',
								'uri' 	=> 'admin/nivo/create',
								'class' => 'add'
								)
							)
						)
				)
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('gallery_slideshow');
		$this->dbforge->drop_table('gallery_cat_slideshow');
		$this->db->delete('settings', array('module' => 'nivo'));

		$nivo1 = array(
                        'gal_id' => array(
									  'type' => 'MEDIUMINT',
									  'constraint' => '8',
									  'auto_increment' => TRUE
									  ),
						'gal_title' => array(
										'type' => 'VARCHAR',
										'constraint' => '255'
										),
						'gal_desc' => array(
										'type' => 'TEXT'
										),
						'gal_full' => array(
										'type' => 'VARCHAR',
										'constraint' => '255'
										),
						'gal_thumb' => array(
										'type' => 'VARCHAR',
										'constraint' => '255'
										),
						'gal_date' => array(
										'type' => 'DATETIME'
										),
						'cat' => array(
										'type' => 'VARCHAR',
										'constraint' => '100'
										),
						'lorder' => array(
										'type' => 'INT',
										'constraint' => '11'
										),
						'url' => array(
										'type' => 'VARCHAR',
										'constraint' => '200'
										)
						);

		$this->dbforge->add_field($nivo1);
		$this->dbforge->add_key('gal_id', TRUE);
		$this->dbforge->create_table('gallery_slideshow');

		$nivo2 = array(
                        'cat_id' => array(
									  'type' => 'INT',
									  'constraint' => '11',
									  'auto_increment' => TRUE
									  ),
						'cat_parent' => array(
										'type' => 'INT',
										'constraint' => '11'
										),
						'cat_order' => array(
										'type' => 'INT',
										'constraint' => '11'
										),
						'cat_title' => array(
										'type' => 'VARCHAR',
										'constraint' => '255'
										)
						);

		$this->dbforge->add_field($nivo2);
		$this->dbforge->add_key('cat_id', TRUE);
		$this->dbforge->create_table('gallery_cat_slideshow');

		$nivo_setting = array(
			'slug' => 'nivo_setting',
			'title' => 'Nivo Setting',
			'description' => 'A Yes or No option for the Nivo module',
			'`default`' => '1',
			'`value`' => '1',
			'type' => 'select',
			'`options`' => '1=Yes|0=No',
			'is_required' => 1,
			'is_gui' => 1,
			'module' => 'nivo'
		);

		if($this->db->insert('settings', $nivo_setting) AND
		   mkdir($this->upload_path.'gallery/full',0777,TRUE) AND
		   mkdir($this->upload_path.'gallery/thumb',0777,TRUE) AND
		   mkdir($this->upload_path.'gallery/original',0777,TRUE) AND
		   is_dir($this->upload_path.'nivo') OR @mkdir($this->upload_path.'nivo',0777,TRUE))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('gallery_slideshow');
		$this->dbforge->drop_table('gallery_cat_slideshow');
		$this->db->delete('settings', array('module' => 'nivo'));
		{
			return TRUE;
		}
	}


	public function upgrade($old_version)
	{
		// Your Upgrade Logic
		return TRUE;
	}

	public function help()
	{
		// Return a string containing help info
		// You could include a file and return it here.
		return "No documentation has been added for this module.<br />Contact the module developer for assistance.";
	}
}
/* End of file details.php */
