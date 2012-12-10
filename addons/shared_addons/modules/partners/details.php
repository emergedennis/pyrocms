<?php defined('BASEPATH') or exit('No direct script access allowed');

class Module_Partners extends Module {

	public $version = '1.0';

	public function info()
	{
		return array(
			'name' => array(
				'en' => 'Partners'
			),
			'description' => array(
				'en' => 'Add a list of partner companies and their information to your website'
			),
			'frontend' => TRUE,
			'backend' => TRUE,
			'menu' => 'content', // You can also place modules in their top level menu. For example try: 'menu' => 'Partners',
			'sections' => array(
				'items' => array(
					'name' 	=> 'partners:items', // These are translated from your language file
					'uri' 	=> 'admin/partners',
						'shortcuts' => array(
							'create' => array(
								'name' 	=> 'partners:create',
								'uri' 	=> 'admin/partners/create',
								'class' => 'add'
								)
							)
						)
				)
		);
	}

	public function install()
	{
		$this->dbforge->drop_table('partners');
		$this->db->delete('settings', array('module' => 'partners'));

		$partners = array(
                        'id' => array(
									  'type' => 'INT',
									  'constraint' => '11',
									  'auto_increment' => TRUE
									  ),
                        'cat' => array(
										'type' => 'VARCHAR',
										'constraint' => '100'
										),
                        'title' => array(
										'type' => 'VARCHAR',
										'constraint' => '100'
										),
                        'desc' => array(
										'type' => 'VARCHAR',
										'constraint' => '2700'
										),
                        'img' => array(
										'type' => 'VARCHAR',
										'constraint' => '100'
										),
                        'url' => array(
										'type' => 'VARCHAR',
										'constraint' => '100'
										),
						'video_code' => array(
										'type' => 'VARCHAR',
										'constraint' => '2700'
										),
						'inactive' => array(
										'type' => 'VARCHAR',
										'constraint' => '100'
										)
						);

		$partners_setting = array(
			'slug' => 'partners_setting',
			'title' => 'Partners Setting',
			'description' => 'A Yes or No option for the Partners module',
			'`default`' => '1',
			'`value`' => '1',
			'type' => 'select',
			'`options`' => '1=Yes|0=No',
			'is_required' => 1,
			'is_gui' => 1,
			'module' => 'partners'
		);

		$this->dbforge->add_field($partners);
		$this->dbforge->add_key('id', TRUE);

		if($this->dbforge->create_table('partners') AND
		   $this->db->insert('settings', $partners_setting) AND
		   is_dir($this->upload_path.'partners') OR @mkdir($this->upload_path.'partners',0777,TRUE))
		{
			return TRUE;
		}
	}

	public function uninstall()
	{
		$this->dbforge->drop_table('partners');
		$this->db->delete('settings', array('module' => 'partners'));
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
