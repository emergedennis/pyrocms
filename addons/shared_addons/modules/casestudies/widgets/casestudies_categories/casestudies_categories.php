<?php defined('BASEPATH') OR exit('No direct script access allowed');

/**
 * @package 		PyroCMS
 * @author			Patrick Patons
 *
 * Show a list of casestudies categories.
 */

class Widget_Casestudies_categories extends Widgets
{
	public $title		= array(
		'en' => 'Case Study Categories',
		'br' => 'Categorias do Casestudies',
		'ru' => 'ÐšÐ°Ñ‚ÐµÐ³Ð¾Ñ€Ð¸Ð¸ Ð‘Ð»Ð¾Ð³Ð°',
	);
	public $description	= array(
		'en' => 'Show a list of case study categories',
		'br' => 'Mostra uma lista de navegaÃ§Ã£o com as categorias do Casestudies',
		'ru' => 'Ð’Ñ‹Ð²Ð¾Ð´Ð¸Ñ‚ Ñ�Ð¿Ð¸Ñ�Ð¾Ðº ÐºÐ°Ñ‚ÐµÐ³Ð¾Ñ€Ð¸Ð¹ Ð±Ð»Ð¾Ð³Ð°',
	);
	public $author		= 'Patrick Patons';
	public $website		= 'http://github.com/ppatons/';
	public $version		= '1.0';
	
	public function run()
	{
		$this->load->model('casestudies/casestudies_categories_m');
		
		$categories = $this->casestudies_categories_m->order_by('title')->get_all();
		
		return array('categories' => $categories);
	}	
}