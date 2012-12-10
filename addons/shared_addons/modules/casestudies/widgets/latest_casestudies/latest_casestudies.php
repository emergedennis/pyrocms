<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @subpackage 		Latest casestudies Widget
 * @author			Patrick Patons
 *
 * Show Latest casestudies in your site with a widget. Intended for use on cms pages
 *
 * Usage : on a CMS page add {widget_area('name_of_area')}
 * where 'name_of_area' is the name of the widget area you created in the admin control panel
 */

class Widget_Latest_casestudies extends Widgets
{
	public $title		= array(
		'en' => 'Latest Case Studies',
		'br' => 'Artigos recentes do Casestudies',
		'ru' => 'ÐŸÐ¾Ñ�Ð»ÐµÐ´Ð½Ð¸Ðµ Ð·Ð°Ð¿Ð¸Ñ�Ð¸',
	);
	public $description	= array(
		'en' => 'Display latest case study posts with a widget',
		'br' => 'Mostra uma lista de navegaÃ§Ã£o para abrir os Ãºltimos artigos publicados no Casestudies',
		'ru' => 'Ð’Ñ‹Ð²Ð¾Ð´Ð¸Ñ‚ Ñ�Ð¿Ð¸Ñ�Ð¾Ðº Ð¿Ð¾Ñ�Ð»ÐµÐ´Ð½Ð¸Ñ… Ð·Ð°Ð¿Ð¸Ñ�ÐµÐ¹ Ð±Ð»Ð¾Ð³Ð° Ð²Ð½ÑƒÑ‚Ñ€Ð¸ Ð²Ð¸Ð´Ð¶ÐµÑ‚Ð°',
	);
	public $author		= 'Patrick Patons';
	public $website		= 'http://github.com/ppatons/';
	public $version		= '1.0';

	// build form fields for the backend
	// MUST match the field name declared in the form.php file
	public $fields = array(
		array(
			'field' => 'limit',
			'label' => 'Number of posts',
		),
		array(
			'field' => 'id',
			'label' => 'Category',
		),
	);


	public function form($options)
	{
		// get available categories
		$query = $this->db->get('casestudies_categories');
		$cats_available = $query->result();

		// define the category dropdown array
		$select_cat = array();
		foreach($cats_available as $cat_available)
		{
			$query = $this->db->get_where('casestudies_categories', array('id' => $cat_available->id));
			$select_cat[$cat_available->id] = $cat_available->title;
		}

		!empty($options['limit']) OR $options['limit'] = 5;
		!empty($options['id']) OR $options['id'] = 12;

		return array(
			'options' => $options,
			'select_cat' => $select_cat
		);
	}

	public function run($options)
	{
		// load the casestudies module's model
		class_exists('Casestudies_m') OR $this->load->model('casestudies/casestudies_m');

		// sets default number of posts to be shown
		empty($options['limit']) AND $options['limit'] = 5;

		//
		//if(!isset($theCat)){$theCat = null;}
		//$theCat = $options['id'];
		// sets default category
		//empty($options['id']) AND $options['id'] = 1;

		// retrieve the records using the casestudies module's model
		$casestudies_widget = $this->casestudies_m->limit($options['limit'])->get_many_by(array('status' => 'live','category' => $options['id']));

		// returns the variables to be used within the widget's view
		return array('casestudies_widget' => $casestudies_widget);
	}
}