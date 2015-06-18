<?php
if(!class_exists('Book'))
{
	class Book
	{
		const POST_TYPE	= 'book';
	
		public function __construct()
		{
			add_action('init', array(&$this, 'init'));
		}

		public function init()
		{
			$this->create_post_type();
		}

		public function create_post_type()
		{
			$labels = array(
				'name'								=> __('Library materials', 'reception'),
				'singular_name'				=> __('Library material', 'reception'),
				'menu_name'						=> __('Library materials', 'reception'),
				'name_admin_bar'			=> __('Library material', 'reception'),				
				'all_items'						=> __('All Library materials', 'reception'),
				'add_new'							=> __('Add New', 'reception'),
				'add_new_item'				=> __('Add New Library material', 'reception'),
				'edit_item'						=> __('Edit Library material', 'reception'),				
				'new_item'						=> __('New Library material', 'reception'),
				'view_item'						=> __('View Library material', 'reception'),
				'search_items'				=> __('Search Library materials', 'reception'),
				'not_found'						=> __('No materials found.', 'reception'),
				'not_found_in_trash'	=> __('No materials found in Trash.', 'reception'),
				'parent_item_colon'		=> __('Parent Library material:', 'reception'),
			);
			$args = array(
				'taxonomies'					=> array('post_tag'),
				'labels'							=> $labels,
				'public'							=> true,
				'publicly_queryable'	=> true,
				'show_ui'							=> true,
				'show_in_menu'				=> true,
				'query_var'						=> true,
				'rewrite'							=> array('slug' => self::POST_TYPE),
				'capability_type'			=> 'post',
				'has_archive'					=> true,
				'hierarchical'				=> false,
				'menu_position'				=> 9,
				'description'					=> __('Book or other material in the Library'),
				'menu_icon'						=> 'dashicons-book-alt',
				'supports'						=> array('title', 'editor', 'thumbnail')
			);
			register_post_type(self::POST_TYPE, $args);
		}
	}
}
?>