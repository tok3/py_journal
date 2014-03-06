<?php defined('BASEPATH') or exit('No direct script access allowed');
/**
 * Categories model
 *
 * @author  Phil Sturgeon
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Journal\Models
 */
class Journal_categories_m extends MY_Model
{
	/**
	 * Insert a new category into the database
	 *
	 * @param array $input The data to insert
	 * @param bool  $skip_validation
	 *
	 * @return string
	 */
	public function insert($input = array(), $skip_validation = false)
	{
		
			parent::insert(array(
			'title' => $input['title'],
			'slug' => $input['slug'],
				'itemscope' => $input['itemscope'],
		));

		return $input['title'];
	}

	/**
	 * Update an existing category
	 *
	 * @param int   $id    The ID of the category
	 * @param array $input The data to update
	 * @param bool  $skip_validation
	 *
	 * @return bool
	 */
	public function update($id, $input, $skip_validation = false)
	{
		return parent::update($id, array(
			'title' => $input['title'],
			'slug' => $input['slug'],
	'itemscope' => $input['itemscope'],
		));
	}

	/**
	 * Callback method for validating the title
	 *
	 * @param string $title The title to validate
	 * @param int    $id    The id to check
	 *
	 * @return mixed
	 */
	public function check_title($title = '', $id = 0)
	{
		return (bool)$this->db->where('title', $title)
			->where('id != ', $id)
			->from('journal_categories')
			->count_all_results();
	}

	/**
	 * Callback method for validating the slug
	 *
	 * @param string $slug The slug to validate
	 * @param int    $id   The id to check
	 *
	 * @return bool
	 */
	public function check_slug($slug = '', $id = 0)
	{
		return (bool)$this->db->where('slug', $slug)
			->where('id != ', $id)
			->from('journal_categories')
			->count_all_results();
	}

	/**
	 * Insert a new category into the database via ajax
	 *
	 * @param array $input The data to insert
	 *
	 * @return int
	 */
	public function insert_ajax($input = array())
	{
		return parent::insert(array(
			'title' => $input['title'],
			//is something wrong with convert_accented_characters?
			//'slug'=>url_title(strtolower(convert_accented_characters($input['title'])))
			'slug' => url_title(strtolower($input['title']))
		));
	}
}
