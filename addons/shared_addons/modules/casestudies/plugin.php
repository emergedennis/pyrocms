<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Casestudies Plugin
 *
 * Create lists of posts
 *
 * @package		PyroCMS
 * @author		PyroCMS Dev Team
 * @copyright	Copyright (c) 2008 - 2011, PyroCMS
 *
 */
class Plugin_Casestudies extends Plugin
{
	/**
	 * Casestudies List
	 *
	 * Creates a list of casestudies posts
	 *
	 * Usage:
	 * {{ casestudies:posts order-by="title" limit="5" }}
	 *		<h2>{{ title }}</h2>
	 *		<p> {{ body }} </p>
	 * {{ /casestudies:posts }}
	 *
	 * @param	array
	 * @return	array
	 */
	public function posts()
	{
		$limit		= $this->attribute('limit', 10);
		$category	= $this->attribute('category');
		$order_by 	= $this->attribute('order-by', 'created_on');
													//deprecated
		$order_dir	= $this->attribute('order-dir', $this->attribute('order', 'ASC'));

		if ($category)
		{
			$this->db->where('casestudies_categories.' . (is_numeric($category) ? 'id' : 'slug'), $category);
		}

		$posts = $this->db
			->select('casestudies.*')
			->select('casestudies_categories.title as category_title, casestudies_categories.slug as category_slug')
			->select('p.display_name as author_name')
			->where('status', 'live')
			->where('created_on <=', now())
			->join('casestudies_categories', 'casestudies.category_id = casestudies_categories.id', 'left')
			->join('profiles p', 'casestudies.author_id = p.user_id', 'left')
			->order_by('casestudies.' . $order_by, $order_dir)
			->limit($limit)
			->get('casestudies')
			->result();

		foreach ($posts as &$post)
		{
			$post->url = site_url('casestudies/'.date('Y', $post->created_on).'/'.date('m', $post->created_on).'/'.$post->slug);
		}
		
		return $posts;
	}
}

/* End of file plugin.php */