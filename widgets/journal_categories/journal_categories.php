<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Show a list of journal categories.
 *
 * @author        Stephen Cozart
 * @author        PyroCMS Dev Team
 * @package       PyroCMS\Core\Modules\Journal\Widgets
 */
class Widget_Journal_categories extends Widgets
{
	public $author = 'Stephen Cozart';

	public $website = 'http://github.com/clip/';

	public $version = '1.0.0';

	public $title = array(
		'en' => 'Journal Categories',
		'br' => 'Categorias do Journal',
		'pt' => 'Categorias do Journal',
		'el' => 'Κατηγορίες Ιστολογίου',
		'fr' => 'Catégories du Journal',
		'ru' => 'Категории Блога',
		'id' => 'Kateori Journal',
            'fa' => 'مجموعه های بلاگ',
	);

	public $description = array(
		'en' => 'Show a list of journal categories',
		'br' => 'Mostra uma lista de navegação com as categorias do Journal',
		'pt' => 'Mostra uma lista de navegação com as categorias do Journal',
		'el' => 'Προβάλει την λίστα των κατηγοριών του ιστολογίου σας',
		'fr' => 'Permet d\'afficher la liste de Catégories du Journal',
		'ru' => 'Выводит список категорий блога',
		'id' => 'Menampilkan daftar kategori tulisan',
            'fa' => 'نمایش لیستی از مجموعه های بلاگ',
	);

	public function run()
	{
		$this->load->model('journal/journal_categories_m');

		$categories = $this->journal_categories_m->order_by('title')->get_all();

		return array('categories' => $categories);
	}

}
