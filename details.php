<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 * Journal module
 *
 * @author  PyroCMS Dev Team
 * @package PyroCMS\Core\Modules\Journal
 */
class Module_Journal extends Module
{
	public $version = '0.0.14';

	public function info()
	{
		$info = array(
			'name' => array(
				'en' => 'Journal',
				'ar' => 'المدوّنة',
				'br' => 'Journal',
				'pt' => 'Journal',
				'el' => 'Ιστολόγιο',
				'fa' => 'بلاگ',
				'he' => 'בלוג',
				'id' => 'Journal',
				'lt' => 'Journalas',
				'pl' => 'Journal',
				'ru' => 'Блог',
				'tw' => '文章',
				'cn' => '文章',
				'hu' => 'Journal',
				'fi' => 'Journali',
				'th' => 'บล็อก',
				'se' => 'Journalg',
				),
			'description' => array(
				'en' => 'Post journal entries.',
				'ar' => 'أنشر المقالات على مدوّنتك.',
				'br' => 'Escrever publicações de journal',
				'pt' => 'Escrever e editar publicações no journal',
										   'cs' => 'Publikujte nové články a příspěvky na journal.', #update translation
										   'da' => 'Skriv journalindlæg',
										   'de' => 'Veröffentliche neue Artikel und Journal-Einträge', #update translation
										   'sl' => 'Objavite journal prispevke',
										   'fi' => 'Kirjoita journali artikkeleita.',
										   'el' => 'Δημιουργήστε άρθρα και εγγραφές στο ιστολόγιο σας.',
										   'es' => 'Escribe entradas para los artículos y journal (web log).', #update translation
										   'fa' => 'مقالات منتشر شده در بلاگ',
										   'fr' => 'Poster des articles d\'actualités.',
										   'he' => 'ניהול בלוג',
										   'id' => 'Post entri journal',
										   'it' => 'Pubblica notizie e post per il journal.', #update translation
										   'lt' => 'Rašykite naujienas bei journal\'o įrašus.',
										   'nl' => 'Post nieuwsartikelen en journals op uw site.',
										   'pl' => 'Dodawaj nowe wpisy na journalu',
										   'ru' => 'Управление записями блога.',
										   'tw' => '發表新聞訊息、部落格等文章。',
										   'cn' => '发表新闻讯息、部落格等文章。',
										   'th' => 'โพสต์รายการบล็อก',
										   'hu' => 'Journal bejegyzések létrehozása.',
										   'se' => 'Inlägg i journalgen.',
										   ),
'frontend' => true,
'backend' => true,
'skip_xss' => true,
'menu' => 'content',

'roles' => array(
	'put_live', 'edit_live', 'delete_live'
	),

'sections' => array(
	'posts' => array(
		'name' => 'journal:posts_title',
		'uri' => 'admin/journal',
		'shortcuts' => array(
			array(
				'name' => 'journal:create_title',
				'uri' => 'admin/journal/create',
				'class' => 'add',
				),
			),
		),
	'categories' => array(
		'name' => 'cat:list_title',
		'uri' => 'admin/journal/categories',
		'shortcuts' => array(
			array(
				'name' => 'cat:create_title',
				'uri' => 'admin/journal/categories/create',
				'class' => 'add',
				),
			),
		),
	),
);

if (function_exists('group_has_role'))
{
	if(group_has_role('journal', 'admin_journal_fields'))
	{
		$info['sections']['fields'] = array(
			'name' 	=> 'global:custom_fields',
			'uri' 	=> 'admin/journal/fields',
			'shortcuts' => array(
				'create' => array(
					'name' 	=> 'streams:add_field',
					'uri' 	=> 'admin/journal/fields/create',
					'class' => 'add'
					)
				)
			);
	}
}
return $info;
}

public function install()
{
	$this->dbforge->drop_table('journal_categories');

	$this->load->driver('Streams');
	$this->streams->utilities->remove_namespace('journals');

	  // Just in case.
	$this->dbforge->drop_table('journal');

	if ($this->db->table_exists('data_streams'))
	{
		$this->db->where('stream_namespace', 'journals')->delete('data_streams');
	}

	  // Create the journal categories table.
	$this->install_tables(array(
		'journal_categories' => array(
			'id' => array('type' => 'INT', 'constraint' => 11, 'auto_increment' => true, 'primary' => true),
			'slug' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true, 'key' => true),
			'title' => array('type' => 'VARCHAR', 'constraint' => 100, 'null' => false, 'unique' => true),
			),
		));

	$this->streams->streams->add_stream(
		'lang:journal:journal_title',
		'journal',
		'journals',
		null,
		null
		);

	

	$folder_name = "journal";

	  // get folders tree
	$folders = $this->get_folder_tree();
	  // check if folder exists 
	$folder_id = array_search($folder_name ,$folders);
	if (!$folder_id) 
	{

		$this->load->library('files/files');
		$folder = Files::create_folder(0, $folder_name);
		$folder_id =  $folder['data']['id'];

	}

/*	foreach ($folders as $key => $value) {
		$this->load->library('files/files');
		Files::delete_folder($key);
	}
*/

	$fields = array(
		array(
			'name'		=> 'lang:journal:teaser_img_label',
			'slug'		=> 'teaser_image',
			'namespace' => 'journals',
			'type'		=> 'image',
			'assign'	=> 'journal',
			'extra'		=> array('folder' => $folder_id),
			'required'	=> false
			),
		array(
			'name'		=> 'lang:journal:teaser_img_displ_type',
			'slug'		=> 'teaser_image_displ_prop',
			'namespace' => 'journals',
			'type'		=> 'choice',
			'assign'	=> 'journal',
			'extra'		=> array('choice_type' => 'radio'
				,'choice_data'=>'fw : lang:journal:fw
				tl : lang:journal:tl
				tr : lang:journal:tr',
				'default_value'=>'fw'),
			'required'	=> false
			)
		);


	$this->streams->fields->add_fields($fields);



	  // Ad the rest of the journal fields the normal way.
	$journal_fields = array(
		'title' => array('type' => 'VARCHAR', 'constraint' => 200, 'null' => false, 'unique' => true),
		'slug' => array('type' => 'VARCHAR', 'constraint' => 200, 'null' => false),
		'category_id' => array('type' => 'INT', 'constraint' => 11, 'key' => true),
		'teaser' => array('type' => 'TEXT'),
		'parsed_teaser' => array('type' => 'TEXT'),
		'body' => array('type' => 'TEXT'),
		'parsed_body' => array('type' => 'TEXT'),
		'keywords' => array('type' => 'VARCHAR', 'constraint' => 32, 'default' => ''),
		'author_id' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
		'created_on' => array('type' => 'INT', 'constraint' => 11),
		'updated_on' => array('type' => 'INT', 'constraint' => 11, 'default' => 0),
		'comments_enabled' => array('type' => 'ENUM', 'constraint' => array('no','1 day','1 week','2 weeks','1 month', '3 months', 'always'), 'default' => '3 months'),
		'status' => array('type' => 'ENUM', 'constraint' => array('draft', 'live'), 'default' => 'draft'),
		'type_teaser' => array('type' => 'SET', 'constraint' => array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple'), 'default' => 'markdown'),
		'type_body' => array('type' => 'SET', 'constraint' => array('html', 'markdown', 'wysiwyg-advanced', 'wysiwyg-simple'), 'default' => 'markdown'),

		'preview_hash' => array('type' => 'CHAR', 'constraint' => 32, 'default' => ''),
		);
return $this->dbforge->add_column('journal', $journal_fields);
}

public function get_folder_tree() 
{
	$this->load->model('files/file_folders_m');
	$data = array();
	$file_folders = $this->file_folders_m->get_folders();

	foreach($file_folders as $folder) 
	{ 
		$indent = repeater('— ', $folder->depth);   /*dashes to denote nested folders in the dropdown list*/
		$data[$folder->id] = $indent . $folder->name;

	}

	return $data;
}

public function uninstall()
{


	$this->dbforge->drop_table('journal');
	$this->dbforge->drop_table('journal_categories');

	  //	$this->streams->fields->delete_field('teaser_image', 'journals');
	  //	$this->streams->fields->delete_field('intro', 'journals');

	return true;
}

public function upgrade($old_version)
{
	return true;
	/*$fields = array(
		'parsed' => array(
			'name' => 'parsed_body',
			'type' => 'TEXT',
			),

		);
	$this->dbforge->modify_column('journal', $fields);
*/
	
	 $fields = array(
	 	'itemscope' => array('type' => 'ENUM', 'constraint' => array('Article','NewsArticle','TechArticle','ScholarlyArticle', 'BlogPosting'), 'default' => 'Article'),		);
	
	 $this->dbforge->add_column('journal_categories', $fields);

	return true;
}
}
