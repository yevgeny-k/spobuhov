<?php
if(!class_exists('Bill'))
{
	class Bill
	{
		const POST_TYPE	= 'bill';
	
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
				'name'								=> __('Bills', 'reception'),
				'singular_name'				=> __('Bill', 'reception'),
				'menu_name'						=> __('Bills', 'reception'),
				'name_admin_bar'			=> __('Bill', 'reception'),				
				'all_items'						=> __('All Bills', 'reception'),
				'add_new'							=> __('Add New', 'reception'),
				'add_new_item'				=> __('Add New Bill', 'reception'),
				'edit_item'						=> __('Edit Bill', 'reception'),				
				'new_item'						=> __('New Bill', 'reception'),
				'view_item'						=> __('View Bill', 'reception'),
				'search_items'				=> __('Search Bills', 'reception'),
				'not_found'						=> __('No Bills found.', 'reception'),
				'not_found_in_trash'	=> __('No Bills found in Trash.', 'reception'),
				'parent_item_colon'		=> __('Parent Bill:', 'reception'),
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
				'description'					=> __('Bills of deputies'),
				'menu_icon'						=> 'dashicons-book-alt',
				//'supports'						=> array( 'title', 'editor', 'author' )
			);
			register_post_type(self::POST_TYPE, $args);
		}
	}
}
?>