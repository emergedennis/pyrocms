<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a partners module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Partners Module
 */
class Plugin_Partners extends Plugin
{
	/**
	 * Item List
	 * Usage:
	 * 
	 * {{ partners:items limit="5" order="asc" }}
	 *      {{ id }} {{ name }} {{ slug }}
	 * {{ /partners:items }}
	 *
	 * @return	array
	 */
	function items()
	{
		$limit = $this->attribute('limit');
		$order = $this->attribute('order');
		
		return $this->db->order_by('name', $order)
						->limit($limit)
						->get('partners_items')
						->result_array();
	}
}

/* End of file plugin.php */