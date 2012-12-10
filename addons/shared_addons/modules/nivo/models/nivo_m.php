<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a nivo module for PyroCMS
 *
 * @author 		eMerge
 * @website		http://easyemerge.com
 * @package 	PyroCMS
 * @subpackage 	Nivo Slider Module
 */
class Nivo_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		
		/**
		 * If the nivo module's table was named "nivos"
		 * then MY_Model would find it automatically. Since
		 * I named it "nivo" then we just set the name here.
		 */
		$this->_table = 'gallery_cat_slideshow';
	}
	
	//create a new item
	public function create($input)
	{
		/*$to_insert = array(
			'gal_title' => $input['gal_title'],
			'gal_desc' => $input['gal_desc'],
			'gal_full' => $input['gal_full'],
			'gal_thumb' => $input['gal_thumb'],
			'gal_date' => $input['gal_date'],
			'cat' => $input['cat'],
			'lorder' => $input['lorder'],
			'url' => $input['url']
		);

		return $this->db->insert('gallery_slideshow', $to_insert);*/

		$to_insert = array(
			'cat_title' => $input['cat_title'],
			'cat_parent' => $input['cat_parent'],
			'cat_order' => $input['cat_order']
		);

		return $this->db->insert('gallery_cat_slideshow', $to_insert);
	}

	//make sure the slug is valid
	/*public function _check_slug($slug)
	{
		$slug = strtolower($slug);
		$slug = preg_replace('/\s+/', '-', $slug);

		return $slug;
	}*/
}
