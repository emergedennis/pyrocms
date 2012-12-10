<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * This is a partners module for PyroCMS
 *
 * @author 		eMerge
 * @website		http://www.easyemerge.com
 * @package 	PyroCMS
 * @subpackage 	Partners Module
 */
class Partners_m extends MY_Model {

	public function __construct()
	{		
		parent::__construct();
		
		/**
		 * If the partners module's table was named "partnerss"
		 * then MY_Model would find it automatically. Since
		 * I named it "partners" then we just set the name here.
		 */
		$this->_table = 'partners';
	}
	
	//create a new item
	public function create($input)
	{
		$img_name = '';

		$handle = new upload($_FILES['img']);
		if ($handle->uploaded) {
			  $handle->file_new_name_body   = 'image_resized';
			  $handle->image_resize         = true;
			  $handle->image_x              = 150;
			  $handle->image_ratio_y        = true;
			  $handle->process(FCPATH.UPLOAD_PATH.'/partners/');
			  if ($handle->processed) {
			      echo 'image resized';
			      $handle->clean();
			      $img_name = $handle->file_dst_name;
			  } else {
			      echo 'error : ' . $handle->error;
			  }
		}



		$to_insert = array(
			'title' => $input['title'],
			'desc' => $input['desc'],
			'url' => $input['url'],
			'video_code' => $input['video_code'],
			'img' => $img_name,
			'cat' => $input['cat'],
			'inactive' => $input['inactive'],
		);

		return $this->db->insert('partners', $to_insert);

		
	}

	//make sure the slug is valid
	public function _check_slug($slug)
	{
		$slug = strtolower($slug);
		$slug = preg_replace('/\s+/', '-', $slug);

		return $slug;
	}
}
