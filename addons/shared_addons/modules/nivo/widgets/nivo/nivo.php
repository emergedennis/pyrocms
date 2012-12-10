<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @subpackage 		Nivo Slider
 * @author			Michael Giuliana & eMerge
 *
 * Display a slider configured in the Sliders Module
 *
 * Usage : on a CMS page add {widget_area('name_of_area')}
 * where 'name_of_area' is the name of the widget area you created in the admin control panel
 */

class Widget_Nivo extends Widgets
{
	public $title		= array(
		'en' => 'Nivo',
	);
	public $description	= array(
		'en' => 'Display a Nivo Slider on your website.',
	);

	public $author		= 'Michael Giuliana & eMerge';
	public $website		= 'http://www.easyemerge.com';
	public $version		= '1.0';

	public $fields = array(
		array(
			'field' => 'slider_id',
			'label' => 'Slider',
		),
		array(
			'field' => 'theme',
			'label' => 'Theme',
		),
		array(
			'field' => 'effect',
			'label' => 'Effect',
		),
		array(
			'field' => 'captions',
			'label' => 'Captions',
		),
		array(
			'field' => 'animSpeed',
			'label' => 'Animation Speed',
		),
		array(
			'field' => 'pauseTime',
			'label' => 'Pause Time',
		),
		array(
			'field' => 'directionNav',
			'label' => 'Direction Nav',
		),
		array(
			'field' => 'directionNavHide',
			'label' => 'Direction Nav Hide',
		),
		array(
			'field' => 'controlNav',
			'label' => 'Control Nav',
		),
		array(
			'field' => 'controlNavThumbs',
			'label' => 'Show Thumbnails',
		),
		array(
			'field' => 'keyboardNav',
			'label' => 'Keyboard Nav',
		),
		array(
			'field' => 'pauseOnHover',
			'label' => 'Pause On Hover',
		),
		array(
			'field' => 'manualAdvance',
			'label' => 'Manual Advance',
		),
		array(
			'field' => 'slices',
			'label' => 'Slices',
		),
		array(
			'field' => 'boxCols',
			'label' => 'Box Columns',
		),
		array(
			'field' => 'boxRows',
			'label' => 'Box Rows',
		),
	);


	public function form($options)
	{
		// load classes, libs
		$this->load->library(array('files/files'));
		$this->load->model(array(
			'nivo/nivo_m',
		));

		// get settings
		//$settings = $this->nivo_m->get_settings();

		// get available categories
		$query = $this->db->get('gallery_cat_slideshow');
		$cats_available = $query->result();

		// define the category dropdown array
		$select_slider = array();
		foreach($cats_available as $cat_available)
		{
			$query = $this->db->get_where('gallery_cat_slideshow', array('cat_id' => $cat_available->cat_id));
			$select_slider[$cat_available->cat_id] = $cat_available->cat_title;
		}

		// option defaults
		!empty($options['slider_id'])				OR $options['slider_id'] = null;
		!empty($options['captions'])				OR $options['captions'] = 'false';
		!empty($options['theme'])					OR $options['theme'] = 'default';
		!empty($options['effect'])					OR $options['effect'] = 'fade';
		!empty($options['animSpeed'])				OR $options['animSpeed'] = 500;
		!empty($options['pauseTime'])				OR $options['pauseTime'] = 3000;
		!empty($options['directionNav'])			OR $options['directionNav'] = 'true';
		!empty($options['directionNavHide'])		OR $options['directionNavHide'] = 'true';
		!empty($options['controlNav'])				OR $options['controlNav'] = 'true';
		!empty($options['controlNavThumbs'])		OR $options['controlNavThumbs'] = 'false';
		!empty($options['keyboardNav'])				OR $options['keyboardNav'] = 'true';
		!empty($options['pauseOnHover'])			OR $options['pauseOnHover'] = 'true';
		!empty($options['manualAdvance'])			OR $options['manualAdvance'] = 'false';
		!empty($options['slices'])					OR $options['slices'] = 15;
		!empty($options['boxCols'])					OR $options['boxCols'] = 8;
		!empty($options['boxRows'])					OR $options['boxRows'] = 4;

		// return the good stuff
		return array(
			'options'	=> $options,
			'select_slider'	=> $select_slider,
		);
	}


	public function run($options)
	{
		// load classes, libs
		//$this->load->library(array('files/files'));
		$this->load->model(array(
			'nivo/nivo_m'
		));

		// get settings
		//$settings = $this->nivo_m->get_settings();

		// get images from 'gallery_slideshow' where the category is the same as the widget setting
		$slider_cat = $options['slider_id'];
		$query = $this->db->get_where('gallery_slideshow', array('cat =' => $slider_cat));
		$images = $query->result();


		// get slider and images
		//$folder = $this->file_folders_m->get($options['slider_id']);
		/*$images = array();
		foreach($images as $image){
		$query = $this->db->order_by('lorder', 'asc')->get_where('gallery_slideshow', array('gal_full' => $image->gal_full));
		$images[$image->gal_full] = $query->result();
		}*/
		// check that the images descriptions are valid urls
		//for($i = 0; $i < count($images); $i++)
		//{
		//	$images[$i]->description = preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $images[$i]->description) ? $images[$i]->description : null;
		//}

		// add path to module assets
		// MODIFY THIS PATH IF YOU'D LIKE TO KEEP THE MODULE ELSEWHERE
		Asset::add_path('nivo', 'addons/shared_addons/modules/nivo/');

		// include jQuery if needed
		/*if($settings->jquery == 1)
		{
			$this->template->append_js(array(
				'nivo::jquery-1.8.3.min.js',
				'nivo::jquery.nivo.slider.js',
			));
		}
		else
		{*/
			$this->template->append_js('nivo::jquery.nivo.slider.js');
		//}

		// append slider themes
		if($options['theme'] != 'none')
		{
			$this->template->append_css(array(
				'nivo::nivo-slider.css',
				'nivo::nivo-themes/'.$options['theme'].'.css',
			));
		}
		else
		{
			$this->template->append_css(array('nivo::nivo-slider.css',));
		}

		// return vars
		return array(
			'options'	=> $options,
			'images'	=> $images,
		);
	}
}
