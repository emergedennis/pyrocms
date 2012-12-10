<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a nivo module for PyroCMS
 *
 * @author 		Jerel Unruh - PyroCMS Dev Team
 * @website		http://unruhdesigns.com
 * @package 	PyroCMS
 * @subpackage 	Nivo Module
 */
class Plugin_Nivo extends Plugin
{
	/**
	 * Item List
	 * Usage:
	 * 
	 * {{ nivo:items limit="5" order="asc" }}
	 *      {{ id }} {{ name }} {{ slug }}
	 * {{ /nivo:items }}
	 *
	 * @return	array
	 */
	function items()
	{
		$limit = $this->attribute('limit');
		$order = $this->attribute('order');
		
		return $this->db->order_by('name', $order)
						->limit($limit)
						->get('nivo_items')
						->result_array();
	}
}

/* End of file plugin.php */